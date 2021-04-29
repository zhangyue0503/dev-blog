<?php

// 数组搜索

$array = [0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red'];

echo array_search('green', $array), PHP_EOL; // 2;
echo array_search('red', $array), PHP_EOL;   // 1;



$array = [0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red', 4=>"7"];

echo array_search(7, $array), PHP_EOL; // 4
var_dump(array_search(7, $array, true)); // bool(false)

var_dump(in_array(7, $array)); // bool(true)
var_dump(in_array(7, $array, true)); // bool(false)

$array = [['a', 'b'], ['c', 'd'], 'e'];

var_dump(array_search(['c', 'd'], $array)); // int(1)
var_dump(array_search(['d', 'c'], $array)); // bool(false)

var_dump(in_array(['c', 'd'], $array)); // bool(true)
var_dump(in_array(['d', 'c'], $array)); // bool(false)





// 数组反转
$input  = ["php", "a" => 6, 4.0, ["green", "red"]];
$reversed = array_reverse($input);
$preserved = array_reverse($input, true);

print_r($input);
print_r($reversed);
print_r($preserved);
// Array
// (
//     [0] => php
//     [a] => 6
//     [1] => 4
//     [2] => Array
//         (
//             [0] => green
//             [1] => red
//         )

// )
// Array
// (
//     [0] => Array
//         (
//             [0] => green
//             [1] => red
//         )

//     [1] => 4
//     [a] => 6
//     [2] => php
// )
// Array
// (
//     [2] => Array
//         (
//             [0] => green
//             [1] => red
//         )

//     [1] => 4
//     [a] => 6
//     [0] => php
// )

$str = 'abc';
echo implode("",array_reverse(str_split($str, 1))), PHP_EOL; // cba

// 数组替换
$base = ["orange", "banana", "apple", "raspberry"];
$replacements = [0 => "pineapple", 4 => "cherry"];
$replacements2 = [0 => "grape", 6 => "watermelon"];

$basket = array_replace($base, $replacements, $replacements2);
print_r($basket);
// Array
// (
//     [0] => grape
//     [1] => banana
//     [2] => apple
//     [3] => raspberry
//     [4] => cherry
//     [6] => watermelon
// )

$base = ['citrus' => ["orange"], 'berries' => ["blackberry", "raspberry"], ];
$replacements = ['citrus' => ['pineapple'], 'berries' => ['blueberry']];

$basket = array_replace_recursive($base, $replacements);
print_r($basket);
// Array
// (
//     [citrus] => Array
//         (
//             [0] => pineapple
//         )

//     [berries] => Array
//         (
//             [0] => blueberry
//             [1] => raspberry
//         )

// )

$basket = array_replace($base, $replacements);
print_r($basket);
// Array
// (
//     [citrus] => Array
//         (
//             [0] => pineapple
//         )

//     [berries] => Array
//         (
//             [0] => blueberry
//         )

// )

// array_reduce
// src/Illuminate/Pipeline/Pipeline.php
function sum($carry, $item)
{
    $carry += $item;
    return $carry;
}

function product($carry, $item)
{
    $carry *= $item;
    return $carry;
}

$a = [1, 2, 3, 4, 5];
$x = [];

var_dump(array_reduce($a, "sum")); // int(15)
var_dump(array_reduce($a, "product", 10)); // int(1200), because: 10*1*2*3*4*5
var_dump(array_reduce($x, "sum", "No data to reduce")); // string(17) "No data to reduce"

var_dump(array_reduce($a, function ($carry, $item) {
    echo $carry, '----', $item, PHP_EOL;
    $carry *= $item;
    return $carry;
}, 10));
// 10----1
// 10----2
// 20----3
// 60----4
// 240----5
// int(1200)

// 并集运算

$arr1 = [0 => 'zero', 1 => 'one'];
$arr2 = [1 => 'one', 2 => 'two', 3 => 'three'];

print_r($arr1 + $arr2);
// Array
// (
//     [0] => zero
//     [1] => one
//     [2] => two
//     [3] => three
// )

print_r(array_merge($arr1, $arr2));
// Array
// (
//     [0] => zero
//     [1] => one
//     [2] => one
//     [3] => two
//     [4] => three
// )

$arr1 = ["color" => "red", 2, 4];
$arr2 = ["a", "b", "color" => "green", "shape" => "trapezoid", 4];

print_r(array_merge($arr1, $arr2));
// Array
// (
//     [color] => green
//     [0] => 2
//     [1] => 4
//     [2] => a
//     [3] => b
//     [shape] => trapezoid
//     [4] => 4
// )

print_r($arr1 + $arr2);
// Array
// (
//     [color] => red
//     [0] => 2
//     [1] => 4
//     [shape] => trapezoid
//     [2] => 4
// )


$ar1 = ["color" => ["favorite" => "red"], 5];
$ar2 = [10, "color" => ["favorite" => "green", "blue"]];
print_r(array_merge_recursive($ar1, $ar2));
// Array
// (
//     [color] => Array
//         (
//             [favorite] => Array
//                 (
//                     [0] => red
//                     [1] => green
//                 )

//             [0] => blue
//         )

//     [0] => 5
//     [1] => 10
// )
