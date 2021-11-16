<?php

$baseArr = [
    "apple" => 12,
    "grape" => "56",
    "peach" => [7, 8],
    "melon" => ["a", "b"],
];

$optArr = [
    "-apple" => null,           // REMOVES KEY/VALUE
    "+pear"  => 34,             // ADDS NEW KEY/VALUE
    "+grape" => 56,             // OVERWRITES VALUE
    
    "peach-" => 8,              // REMOVES ARRAY ITEM
    "peach+" => 9,              // APPENDS ARRAY ITEM
    "melon&" => ["c", "d"],     // MERGES ARRAYS
];

process($baseArr, $optArr, $options) => [
    "pear"  => 34,
    "grape" => 56,
    "peach" => [7, 9],
    "melon" => ["a", "b", "c", "d"],
];

// ==================================================

$options = [
    "unique" => [
        "keepLeft"  => true,
        "keepRight" => true,
    ],
    "common" => [
        "scalars" => [
            "overwrite" => true,
        ],
        "arrays" => [
            "sequential" => [
                "overwrite" => false,
                "merge"     => !overwrite,
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
    ],
];

