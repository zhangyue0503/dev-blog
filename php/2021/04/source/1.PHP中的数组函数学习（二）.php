<?php

// 随机取出一个数组键

echo array_rand(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']); // 6

print_r(array_rand(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'], 3));
// Array
// (
//     [0] => 0
//     [1] => baz
//     [2] => 6
// )

// 队列、栈式操作

$arr = ['a', 'b'];

print_r(array_push($arr, 'c')); // 3
print_r($arr);
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
// )

echo array_pop($arr), PHP_EOL; // c
print_r($arr);
// Array
// (
//     [0] => a
//     [1] => b
// )

echo array_unshift($arr, 'c'), PHP_EOL; // 3
print_r($arr);
// Array
// (
//     [0] => c
//     [1] => a
//     [2] => b
// )

echo array_shift($arr), PHP_EOL; // c
print_r($arr);
// Array
// (
//     [0] => a
//     [1] => b
// )

array_push($arr, 'c', 'd', 'e');
print_r($arr);
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
//     [3] => d
//     [4] => e
// )

// 数组所有乘积

echo array_product([2,3,4]), PHP_EOL; // 24

echo array_product([2,3,'c']), PHP_EOL; // 0

echo array_product([]), PHP_EOL; // 1

// 填补数组
print_r(array_pad(['a', 'b'], 5, 'cc'));
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => cc
//     [3] => cc
//     [4] => cc
// )

print_r(array_pad(['a', 'b'], -5, 'cc'));
// Array
// (
//     [0] => cc
//     [1] => cc
//     [2] => cc
//     [3] => a
//     [4] => b
// )

print_r(array_pad(['a', 'b'], 2, 'cc'));
// Array
// (
//     [0] => a
//     [1] => b
// )

// 遍历数组
array_map(function($v){
    
    echo "元素值为：{$v} .", PHP_EOL;

}, ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']);
// 元素值为：a .
// 元素值为：b .
// 元素值为：1 .
// 元素值为：2 .
// 元素值为：c .

array_map(function($v1, $v2){
    
    echo "元素值为：{$v1}, {$v2} .", PHP_EOL;

}, ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'], ['d', 'e']);
// 元素值为：a, d .
// 元素值为：b, e .
// 元素值为：1,  .
// 元素值为：2,  .
// 元素值为：c,  .

// 键操作

print_r(array_keys(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']));
// Array
// (
//     [0] => 0
//     [1] => 1
//     [2] => foo
//     [3] => baz
//     [4] => 6
// )

echo array_key_first(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']), PHP_EOL; // 0
echo array_key_last(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']), PHP_EOL; // 6

var_dump(array_key_exists('foo', ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'])); // bool(true)
var_dump(array_key_exists('foo1', ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'])); // bool(false)
var_dump(array_key_exists(6, ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'])); // bool(true)

var_dump(key_exists('foo', ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'])); // bool(true)

echo key(['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c']), PHP_EOL; // 0

$arr = ['a', 'b', 'foo' => 1, 'baz' => 2, 6 => 'c'];
while ($v = current($arr)) {
    echo key($arr), PHP_EOL;
    next($arr);
}
// 0
// 1
// foo
// baz
// 6

// 交集

print_r(array_intersect(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x']));
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_intersect_assoc(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x']));
// Array
// (
//     [4] => x
// )

print_r(array_intersect_key(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', 'x'], ['a', 'c', 'b', '1', 'x']));
// Array
// (
//     [0] => a
//     [1] => 1
//     [2] => b
//     [3] => c
// )

print_r(array_intersect_key(['a' => 1, 'b' => 2], ['b' => 3, 'd' => 4]));
// Array
// (
//     [b] => 2
// )

print_r(array_intersect_uassoc(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [4] => x
// )

print_r(array_intersect_ukey(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [0] => a
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_uintersect(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_uintersect(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_uintersect_assoc(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [4] => x
// )

print_r(array_uintersect_uassoc(['a', 1, 'b', 'c', 'x'], ['b', 'c', 'd', '1', 'x'], ['a', 'c', 'b', '1', 'x'], function ($a, $b) {
    return $a <=> $b;
}, function ($a, $b) {
    return $a <=> $b;
}));
// Array
// (
//     [4] => x
// )
