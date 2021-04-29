<?php

// 根据范围创建数组
print_r(range(-2,10));
// Array
// (
//     [0] => -2
//     [1] => -1
//     [2] => 0
//     [3] => 1
//     [4] => 2
//     [5] => 3
//     [6] => 4
//     [7] => 5
//     [8] => 6
//     [9] => 7
//     [10] => 8
//     [11] => 9
//     [12] => 10
// )

print_r(range('A', 'Z'));
// Array
// (
//     [0] => A
//     [1] => B
//     [2] => C
//     [3] => D
//     [4] => E
//     [5] => F
//     [6] => G
//     [7] => H
//     [8] => I
//     [9] => J
//     [10] => K
//     [11] => L
//     [12] => M
//     [13] => N
//     [14] => O
//     [15] => P
//     [16] => Q
//     [17] => R
//     [18] => S
//     [19] => T
//     [20] => U
//     [21] => V
//     [22] => W
//     [23] => X
//     [24] => Y
//     [25] => Z
// )

print_r(range('A', 'Z', 2));
// Array
// (
//     [0] => A
//     [1] => C
//     [2] => E
//     [3] => G
//     [4] => I
//     [5] => K
//     [6] => M
//     [7] => O
//     [8] => Q
//     [9] => S
//     [10] => U
//     [11] => W
//     [12] => Y
// )




// 数组随机排序
$arr = range('A', 'Z', 2);
shuffle($arr);
print_r($arr);
// Array
// (
//     [0] => S
//     [1] => W
//     [2] => I
//     [3] => E
//     [4] => M
//     [5] => U
//     [6] => G
//     [7] => C
//     [8] => O
//     [9] => K
//     [10] => A
//     [11] => Q
//     [12] => Y
// )

$arr = ['A'=>1, 'B'=>2, 'C'=>3];
shuffle($arr);
print_r($arr);
// Array
// (
//     [0] => 1
//     [1] => 3
//     [2] => 2
// )

// 普通排序

$arr = range(1, 10);
shuffle($arr);

sort($arr);
print_r($arr);
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
//     [4] => 5
//     [5] => 6
//     [6] => 7
//     [7] => 8
//     [8] => 9
//     [9] => 10
// )

shuffle($arr);

rsort($arr);
print_r($arr);
// Array
// (
//     [0] => 10
//     [1] => 9
//     [2] => 8
//     [3] => 7
//     [4] => 6
//     [5] => 5
//     [6] => 4
//     [7] => 3
//     [8] => 2
//     [9] => 1
// )

$fruits = ["d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple"];
sort($fruits);
print_r($fruits);
// Array
// (
//     [0] => apple
//     [1] => banana
//     [2] => lemon
//     [3] => orange
// )

// 保持索引关系排序

$fruits = ["d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple"];
asort($fruits);
print_r($fruits);
// Array
// (
//     [c] => apple
//     [b] => banana
//     [d] => lemon
//     [a] => orange
// )

$fruits = ["d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple"];
arsort($fruits);
print_r($fruits);
// Array
// (
//     [a] => orange
//     [d] => lemon
//     [b] => banana
//     [c] => apple
// )



// 键排序 

$keys = range(0, 9);
shuffle($keys);
$arr = array_combine($keys, range(1, 10));
print_r($arr);
// Array
// (
//     [6] => 1
//     [3] => 2
//     [1] => 3
//     [2] => 4
//     [9] => 5
//     [5] => 6
//     [8] => 7
//     [0] => 8
//     [4] => 9
//     [7] => 10
// )

ksort($arr);
print_r($arr);
// Array
// (
//     [0] => 8
//     [1] => 3
//     [2] => 4
//     [3] => 2
//     [4] => 9
//     [5] => 6
//     [6] => 1
//     [7] => 10
//     [8] => 7
//     [9] => 5
// )

$arr = array_combine($keys, range(1, 10));
print_r($arr);
// Array
// (
//     [6] => 1
//     [3] => 2
//     [1] => 3
//     [2] => 4
//     [9] => 5
//     [5] => 6
//     [8] => 7
//     [0] => 8
//     [4] => 9
//     [7] => 10
// )

krsort($arr);
print_r($arr);
// Array
// (
//     [9] => 5
//     [8] => 7
//     [7] => 10
//     [6] => 1
//     [5] => 6
//     [4] => 9
//     [3] => 2
//     [2] => 4
//     [1] => 3
//     [0] => 8
// )

// 自然排序
// strnatcmp() 学习PHP中的字符串操作函数（一）

$arr = ['img11', 'img21', 'img1', 'img2', 'img3', 'img4'];
sort($arr);
print_r($arr);
// Array
// (
//     [0] => img1
//     [1] => img11
//     [2] => img2
//     [3] => img21
//     [4] => img3
//     [5] => img4
// )

$arr = ['img11', 'img21', 'img1', 'img2', 'img3', 'img4'];
natsort($arr);
print_r($arr);
// Array
// (
//     [2] => img1
//     [3] => img2
//     [4] => img3
//     [5] => img4
//     [0] => img11
//     [1] => img21
// )

$arr = ['img11', 'Img21', 'Img1', 'Img2', 'img3', 'img4'];
natsort($arr);
print_r($arr);
// Array
// (
//     [2] => Img1
//     [3] => Img2
//     [1] => Img21
//     [4] => img3
//     [5] => img4
//     [0] => img11
// )

$arr = ['img11', 'Img21', 'Img1', 'Img2', 'img3', 'img4'];
natcasesort($arr);
print_r($arr);
// Array
// (
//     [2] => Img1
//     [3] => Img2
//     [4] => img3
//     [5] => img4
//     [0] => img11
//     [1] => Img21
// )

// 人工排序

$arr = range(1, 10);
shuffle($arr);
usort($arr, function($a, $b){
    return $a < $b;
}); 
print_r($arr);
// Array
// (
//     [0] => 10
//     [1] => 9
//     [2] => 8
//     [3] => 7
//     [4] => 6
//     [5] => 5
//     [6] => 4
//     [7] => 3
//     [8] => 2
//     [9] => 1
// )


shuffle($arr);
usort($arr, function($a, $b){
    return $a > $b;
}); 
print_r($arr);
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
//     [4] => 5
//     [5] => 6
//     [6] => 7
//     [7] => 8
//     [8] => 9
//     [9] => 10
// )

$arr = array_combine($keys, range(1, 10));
uksort($arr, function($a, $b){
    return $a <=> $b;
});
print_r($arr);
// Array
// (
//     [0] => 7
//     [1] => 4
//     [2] => 1
//     [3] => 10
//     [4] => 8
//     [5] => 2
//     [6] => 9
//     [7] => 3
//     [8] => 6
//     [9] => 5
// )

$fruits = ["d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple"];
uasort($fruits, function($a, $b){
    return $a <=> $b;
});
print_r($fruits);
// Array
// (
//     [c] => apple
//     [b] => banana
//     [d] => lemon
//     [a] => orange
// )

// 多维数组排序
$arr = [
    [
        'id'=>5,
        'name'=>'zhang'
    ],
    [
        'id'=>4,
        'name'=>'li'
    ],
    [
        'id'=>2,
        'name'=>'yang'
    ],
    [
        'id'=>6,
        'name'=>'liu'
    ],
    [
        'id'=>1,
        'name'=>'bai'
    ],
];

$ids = array_column($arr, 'id');

array_multisort($ids, SORT_DESC, $arr);
print_r($arr);
// Array
// (
//     [0] => Array
//         (
//             [id] => 6
//             [name] => liu
//         )

//     [1] => Array
//         (
//             [id] => 5
//             [name] => zhang
//         )

//     [2] => Array
//         (
//             [id] => 4
//             [name] => li
//         )

//     [3] => Array
//         (
//             [id] => 2
//             [name] => yang
//         )

//     [4] => Array
//         (
//             [id] => 1
//             [name] => bai
//         )

// )

$names = array_column($arr, 'name');

array_multisort($names, SORT_ASC, $arr);
print_r($arr);
// Array
// (
//     [0] => Array
//         (
//             [id] => 1
//             [name] => bai
//         )

//     [1] => Array
//         (
//             [id] => 4
//             [name] => li
//         )

//     [2] => Array
//         (
//             [id] => 6
//             [name] => liu
//         )

//     [3] => Array
//         (
//             [id] => 2
//             [name] => yang
//         )

//     [4] => Array
//         (
//             [id] => 5
//             [name] => zhang
//         )

// )

// 多个数组排序
$arr1 = [10, 100, 100, 0];
$arr2 = [1, 3, 2, 4];
array_multisort($arr1, $arr2);

print_r($arr1);
// Array
// (
//     [0] => 0
//     [1] => 10
//     [2] => 100
//     [3] => 100
// )

print_r($arr2);
// Array
// (
//     [0] => 4
//     [1] => 1
//     [2] => 2
//     [3] => 3
// )

