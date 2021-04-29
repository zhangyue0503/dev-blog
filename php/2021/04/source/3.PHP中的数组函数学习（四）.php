<?php

// 数组数量
echo count([1,2,3]), PHP_EOL; // 3

$arr = [1,2,3,4=>[5, 6]];
echo count($arr), PHP_EOL; // 4
echo count($arr, COUNT_RECURSIVE), PHP_EOL; // 6

var_dump(count($arr) === count($arr, COUNT_RECURSIVE)); // bool(false)




// 数组与变量的转换

$a = '1';
$b = '2';
$c = '3';

print_r(compact('a'));
// Array
// (
//     [a] => 1
// )

// 7.3以后会 E_NOTICE
print_r(compact(['b', 'c', 'd'])); 
// Array
// (
//     [b] => 2
//     [c] => 3
// )

print_r(compact('a', 'b', ['c']));
// Array
// (
//     [a] => 1
//     [b] => 2
//     [c] => 3
// )

extract(['aa'=>11, 'bb'=>22, 'cc'=>33]);
echo $aa, PHP_EOL; // 11
echo $bb, PHP_EOL; // 22
echo $cc, PHP_EOL; // 33

$aaa = '111';
extract(['aaa'=>1111111]);
echo $aaa, PHP_EOL; // 1111111

$aaa = '111';
extract(['aaa'=>1111111], EXTR_SKIP);
echo $aaa, PHP_EOL; // 111

$aaa = '111';
extract(['aaa'=>1111111], EXTR_PREFIX_SAME, "new");
echo $aaa, PHP_EOL; // 111
echo $new_aaa, PHP_EOL; // 1111111


// 遍历数组
$arr = ["d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple"];
array_walk($arr, function ($value, $index) {
    echo $index . " : " . $value, PHP_EOL;
});
// d : lemon
// a : orange
// b : banana
// c : apple

array_walk($arr, function (&$value, $index, $prefix) {
    $value = $prefix . ' . ' . $index . " : " . $value;
}, 'fruit');
print_r($arr);
// Array
// (
//     [d] => fruit . d : lemon
//     [a] => fruit . a : orange
//     [b] => fruit . b : banana
//     [c] => fruit . c : apple
// )

print_r(array_map(function ($v) {
    if (strpos($v, 'c') !== false) {
        return 'No Map ' . $v;
    } else {
        return 'Map ' . $v;
    }
}, $arr));
// Array
// (
//     [d] => Map fruit . d : lemon
//     [a] => Map fruit . a : orange
//     [b] => Map fruit . b : banana
//     [c] => No Map fruit . c : apple
// )

var_dump(array_map(function ($v) {

}, $arr));
// array(4) {
//     ["d"]=>
//     NULL
//     ["a"]=>
//     NULL
//     ["b"]=>
//     NULL
//     ["c"]=>
//     NULL
//   }

var_dump(array_map(null, $arr));
// array(4) {
//     ["d"]=>
//     string(17) "fruit . d : lemon"
//     ["a"]=>
//     string(18) "fruit . a : orange"
//     ["b"]=>
//     string(18) "fruit . b : banana"
//     ["c"]=>
//     string(17) "fruit . c : apple"
//   }

var_dump(array_map(function ($a, $b, $c) {
    return $a . ' * ' . $b . '*' . $c;
}, $arr, [1, 2, 3], ['a', 'b', 'c', 4]));
// array(4) {
//     [0]=>
//     string(23) "fruit . d : lemon * 1*a"
//     [1]=>
//     string(24) "fruit . a : orange * 2*b"
//     [2]=>
//     string(24) "fruit . b : banana * 3*c"
//     [3]=>
//     string(22) "fruit . c : apple * *4"
//   }

// 返回数组中所有的值
print_r(array_values(['a', '1.2', 'c', 4, 'g' => 1.2, 'c', 'd', 'e', '4']));
// Array
// (
//     [0] => a
//     [1] => 1.2
//     [2] => c
//     [3] => 4
//     [4] => 1.2
//     [5] => c
//     [6] => d
//     [7] => e
//     [8] => 4
// )

// 数组去重
print_r(array_unique(['a', 'b', 'c', 'b', 'c', 'd', 'e']));
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
//     [5] => d
//     [6] => e
// )

print_r(array_unique(['a', '1.2', 'c', 4, 'g' => 1.2, 'c', 'd', 'e', '4']));
// Array
// (
//     [0] => a
//     [1] => 1.2
//     [2] => c
//     [3] => 4
//     [5] => d
//     [6] => e
// )

// 数组求和
echo array_sum([1, 2, 3]), PHP_EOL; // 6

echo array_sum([1.1, 2, 3.3]), PHP_EOL; // 6.4

echo array_sum([1, 2, 'c', '4d']), PHP_EOL; // 7





// 数组截取
$input = ["a", "b", "c", "d", "e"];
print_r(array_slice($input, 2));
// Array
// (
//     [0] => c
//     [1] => d
//     [2] => e
// )

print_r(array_slice($input, -2, 1));
// Array
// (
//     [0] => d
// )

print_r(array_slice($input, 0, 3));
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
// )

print_r(array_slice($input, 2, -1));
// Array
// (
//     [0] => c
//     [1] => d
// )

print_r(array_slice($input, 2, -1, true));
// Array
// (
//     [2] => c
//     [3] => d
// )

$inputKV = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
print_r(array_slice($inputKV, 2));
// Array
// (
//     [c] => 3
//     [d] => 4
//     [e] => 5
// )

// 截取替换

$input = ["red", "green", "blue", "yellow"];
print_r(array_splice($input, 2));
// Array
// (
//     [0] => blue
//     [1] => yellow
// )

$input = ["red", "green", "blue", "yellow"];
print_r(array_splice($input, 1, -1));
// Array
// (
//     [0] => green
//     [1] => blue
// )

$input = ["red", "green", "blue", "yellow"];
print_r(array_splice($input, 1, count($input), "orange"));
print_r($input);
// Array
// (
//     [0] => green
//     [1] => blue
//     [2] => yellow
// )
// Array
// (
//     [0] => red
//     [1] => orange
// )

$input = ["red", "green", "blue", "yellow"];
print_r(array_splice($input, -1, 1, ["black", "maroon"]));
print_r($input);
// Array
// (
//     [0] => yellow
// )
// Array
// (
//     [0] => red
//     [1] => green
//     [2] => blue
//     [3] => black
//     [4] => maroon
// )
