<?php

/*
    https://www.php.net/manual/en/function.array-merge
    
    the values of the right array are appended to the end of the left array
    
    for (non-numeric) keys that exist in both arrays
        the right value for the key will overwrite the left one
    if the arrays contain numeric keys
        the right value will not overwrite the left value, but will be appended
*/

(function () {
    echo PHP_EOL;
    echo "BOTH SEQUENTIAL:" . PHP_EOL;
    echo str_repeat("-", 20) . PHP_EOL;
    $left  = ["a", "b", "c"];
    $right = ["d", "e", "f", "g"];
    $merge = array_merge($left, $right);
    print_r(compact("left", "right", "merge"));
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
        [merge] => Array
            (
                [0] => a
                [1] => b
                [2] => c
                [3] => d
                [4] => e
                [5] => f
                [6] => g
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
    $merge = array_merge($left, $right);
    print_r(compact("left", "right", "merge"));
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
        [merge] => Array
            (
                [a] => pear
                [b] => strawberry
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
    $merge = array_merge($left, $right);
    print_r(compact("left", "right", "merge"));
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
        [merge] => Array
            (
                [a] => pear
                [b] => strawberry
                [d] => durian
                [0] => melon
                [1] => peach
                [c] => cherry
                [2] => grape
            )
    ) */
})();