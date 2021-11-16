<?php

function merge(array $leftArray, ?array $rightArray, $options = []) {
    
    if (empty($rightArray)) {
        return $leftArray;
    }
    
    // the bracket notation is tedious when dealing with nested arrays
    Collection::resolveDotAssignments($options, [
        "forcePath" => true,
    ]);
    
    if (\is_array($options)) {
        // the bracket notation is tedious when dealing with nested arrays
        $options = Object2::fromArray($options);
    }
    
    optionsDefaults: {
        overview: {
          /* "options" => [
                "unique" => {
                    "keepLeft"  => true,
                    "keepRight" => true,
                },
                "common" => {
                    "scalars" => {
                        "overwrite" => true,
                    },
                    "arrays" => {
                        "sequential" => [
                            "overwrite" => false,
                            "merge"     => !overwrite,
                            "unique"    => false,
                        ],
                        "mixed" => [
                            "overwrite" => true,
                        ],
                    },
                    "mixed" => {
                        "overwrite"  => true,
                        "ignoreNull" => false,
                    },
                },
            ]; */
        }
        defaults: {
            // ugly, but needs to be done
            $options->unique ??= Object2::fromArray([
                "keepLeft"  => true,
                "keepRight" => true,
            ]);
            $options->common ??= Object2::fromArray([
                "scalars" => [
                    "overwrite" => true,
                ],
                "arrays" => [
                    "sequential" => [
                        "overwrite" => false,
                        "merge"     => true,
                        "unique"    => false,
                    ],
                    "mixed" => [
                        "overwrite" => true,
                    ],
                ],
                "mixed" => [
                    "overwrite"  => true,
                    "ignoreNull" => false,
                ],
            ]);
            $options->common->scalars ??= Object2::fromArray([
                "overwrite" => true,
            ]);
            $options->common->arrays ??= Object2::fromArray([
                "sequential" => [
                    "overwrite" => false,
                    "merge"     => true,
                    "unique"    => false,
                ],
                "mixed" => [
                    "overwrite" => true,
                ],
            ]);
            $options->common->arrays->sequential ??= Object2::fromArray([
                "overwrite" => false,
                "merge"     => true,
                "unique"    => false,
            ]);
            $options->common->arrays->mixed ??= Object2::fromArray([
                "overwrite" => true,
            ]);
            $options->common->mixed ??= Object2::fromArray([
                "overwrite"  => true,
                "ignoreNull" => false,
            ]);
            $options->unique->keepLeft  ??= true;
            $options->unique->keepRight ??= false;
            $options->common->scalars->overwrite ??= true;
            $options->common->arrays->sequential->overwrite ??= false;
            $options->common->arrays->sequential->merge ??= true;
            $options->common->arrays->sequential->merge =
                !$options->common->arrays->sequential->overwrite;
            $options->common->arrays->mixed->overwrite ??= true;
            $options->common->mixed->overwrite  ??= true;
            $options->common->mixed->ignoreNull ??= false;
        }
    }
    
    $leftArrayKeys  = \array_keys($leftArray);
    $rightArrayKeys = \array_keys($rightArray);
    $commonKeys     = \array_keys(\array_intersect_key($leftArray, $rightArray));
    
    $result = [];
    
    if ($options->unique->keepLeft) {
        $uniqueLeftArrayKeys = \array_diff($leftArrayKeys, $rightArrayKeys);
        foreach ($uniqueLeftArrayKeys as $key) {
            // do we need cloning here like we did in js?
            $result[$key] = $leftArray[$key];
        }
    }
    
    if ($options->unique->keepRight) {
        $uniqueRightArrayKeys = \array_diff($rightArrayKeys, $leftArrayKeys);
        foreach ($uniqueRightArrayKeys as $key) {
            // do we need cloning here like we did in js?
            $result[$key] = $rightArray[$key];
        }
    }
    
    foreach ($commonKeys as $key) {
        
        $leftValue  = $leftArray[$key];
        $rightValue = $rightArray[$key];
        
        // two scalars
        if ( \is_scalar($leftValue)  || \is_null($leftValue) &&
             \is_scalar($rightValue) || \is_null($rightValue) )
        {
            if ($options->common->scalars->overwrite) {
                $result[$key] = $rightValue;
            }
        }
        
        // two arrays
        else if (\is_array($leftValue) && \is_array($rightValue)) {
            
            $leftValueIsSequential  = Array2::isSequential($leftValue);
            $rightValueIsSequential = Array2::isSequential($rightValue);
            
            // both sequential
            if ($leftValueIsSequential && $rightValueIsSequential) {
                if ($options->common->arrays->sequential->merge) {
                    $result[$key] = \array_merge($leftValue, $rightValue);
                    if ($options->common->arrays->sequential->unique) {
                        $result[$key] = \array_unique($result[$key]);
                    }
                } else {
                    $result[$key] = $rightValue;
                }
            }
            
            // both associative
            else if (!$leftValueIsSequential && !$rightValueIsSequential) {
                $result[$key] = merge($leftValue, $rightValue, $options);
            }
            
            // mixed (one sequential and one associative)
            else {
                if ($options->common->arrays->mixed->overwrite) {
                    $result[$key] = $rightValue;
                } else {
                    $result[$key] = $leftValue;
                }
            }
        }
        
        // mixed
        else {
            if ($options->common->mixed->overwrite) {
                if ( (\is_null($rightValue) && !$options->common->mixed->ignoreNull) ||
                     !\is_null($rightValue) )
                {
                    $result[$key] = $rightValue;
                }
            }
        }
        
    }
    
    return $result;
}