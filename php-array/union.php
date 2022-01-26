<?php

/*
    https://www.php.net/manual/en/language.operators.array.php
    
    returns the right-hand array appended to the left-hand array
    
    for keys that exist in both arrays
        the keys/values from the left array will be used
        the keys/values from the right array will be ignored
*/

(function () {
    echo PHP_EOL;
    echo "BOTH SEQUENTIAL:" . PHP_EOL;
    echo str_repeat("-", 20) . PHP_EOL;
    $left  = ["a", "b", "c"];
    $right = ["d", "e", "f", "g"];
    $union = $left + $right;
    print_r(compact("left", "right", "union"));
    /* Array
    (
        [left] => Array
            (
                [0] => a
                [1] => b
                [2] => c
            )
        [right] => Array
            (
                [0] => d
                [1] => e
                [2] => f
                [3] => g
            )
        [union] => Array
            (
                [0] => a
                [1] => b
                [2] => c
                [3] => g
            )
    ) */
})();

(function () {
    echo PHP_EOL;
    echo "BOTH ASSOCIATIVE:" . PHP_EOL;
    echo str_repeat("-", 20) . PHP_EOL;
    $left = [
        "a" => "apple",
        "b" => "banana",
        "d" => "durian",
    ];
    $right = [
        "a" => "pear",
        "b" => "strawberry",
        "c" => "cherry",
        "f" => "fig",
    ];
    $union = $left + $right;
    print_r(compact("left", "right", "union"));
    /* Array
    (
        [left] => Array
            (
                [a] => apple
                [b] => banana
                [d] => durian
            )
        [right] => Array
            (
                [a] => pear
                [b] => strawberry
                [c] => cherry
                [f] => fig
            )
        [union] => Array
            (
                [a] => apple
                [b] => banana
                [d] => durian
                [c] => cherry
                [f] => fig
            )
    ) */
})();

(function () {
    echo PHP_EOL;
    echo "MIXED:" . PHP_EOL;
    echo str_repeat("-", 20) . PHP_EOL;
    $left = [
        "a" => "apple",
        "b" => "banana",
        "d" => "durian",
        "melon",
    ];
    $right = [
        "peach",
        "a" => "pear",
        "b" => "strawberry",
        "c" => "cherry",
        "grape",
    ];
    $union = $left + $right;
    print_r(compact("left", "right", "union"));
    /* Array
    (
        [left] => Array
            (
                [a] => apple
                [b] => banana
                [d] => durian
                [0] => melon
            )
        [right] => Array
            (
                [0] => peach
                [a] => pear
                [b] => strawberry
                [c] => cherry
                [1] => grape
            )
        [union] => Array
            (
                [a] => apple
                [b] => banana
                [d] => durian
                [0] => melon
                [c] => cherry
                [1] => grape
            )
    ) */
})();