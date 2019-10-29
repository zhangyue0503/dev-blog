<?php

var_dump([1, 2] == [2, 1]); // false

var_dump([1, 2, 3] > [3, 2, 1]); // false

var_dump([4, 5, 6] > [1, 2, 3, 4]); // false

var_dump(['a' => 1, 'b' => 2] == ['b' => 2, 'a' => 1]); // ture
var_dump(['a' => 1, 'b' => 2] == ['a' => 2, 'b' => 1]); // false

var_dump(['a' => 1, 'b' => 5] < ['a' => 2, 'b' => 1]); // true

var_dump([['aa' => 1], ['bb' => 1, 'dd' => 2]] == [['aa' => 2], ['bb' => 1]]); // false
var_dump([['aa' => 1], ['bb' => 1, 'dd' => 2]] < [['aa' => 2], ['bb' => 1]]); // true
var_dump([['aa' => 1], ['bb' => 1, 'dd' => 2]] < [['aa' => 1, 'cc' => 1], ['bb' => 1]]); // true

function array_equal($a, $b)
{
    return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
}

function array_identical($a, $b)
{
    return (is_array($a) && is_array($b) && array_diff_assoc($a, $b) === array_diff_assoc($b, $a));
}

$arr1 = [
    'John',
    '178cm',
    '62kg',
];
$arr2 = [
    '62kg',
    'John',
    '178cm',
];

var_dump(array_equal($arr1, $arr2));
// 元素不一样的话
$arr2 = [
    '62kg',
    'John Jobs',
    '178cm',
];
var_dump(array_equal($arr1, $arr2)); // false

$arr1 = [
    [
        '55kg',
        'Bob',
        '172cm',
        [
            'employee',
            '20year'
        ],
    ],
    [
        'John',
        '178cm',
        '62kg',
        [
            'manager',
        ],
    ],
];
$arr2 = [
    [
        '62kg',
        'John',
        '178cm',
        [
            'manager',
        ],
    ],
    [
        [
            '20year',
            'employee',
        ],
        '55kg',
        '172cm',
        'Bob',

    ],
];
var_dump(array_equal($arr1, $arr2));

var_dump(array_equal(['b'=>1, 'a'=>2], ['b'=>2, 'a'=>1])); // true
