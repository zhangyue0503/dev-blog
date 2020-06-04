<?php

print_r($argv);
// php 如何获取PHP命令行参数.php --a=1 -b=2 -c=3 -d=4 --e=5 ccc ddd 
// Array
// (
//     [0] => 如何获取PHP命令行参数.php
//     [1] => --a=1
//     [2] => -b=2
//     [3] => -c=3
//     [4] => -d=4
//     [5] => --e=5
//     [6] => ccc
//     [7] => ddd
// )

print_r(getopt('a:b:c:d:e:f:'));
// Array
// (
//     [b] => 2
//     [c] => 3
//     [d] => 4
// )

print_r(getopt('', ['a:','b:','c:','d:','e:','f:']));
// Array
// (
//     [a] => 1
//     [e] => 5
// )

print_r(getopt('a:b:c:d:e:f:', ['a:','b:','c:','d:','e:','f:']));
// Array
// (
//     [a] => 1
//     [b] => 2
//     [c] => 3
//     [d] => 4
//     [e] => 5
// )

print_r(getopt('abcdef', []));
// Array
// (
//     [b] => 
//     [c] => 
//     [d] => 
// )

// php 如何获取PHP命令行参数.php -f
print_r(getopt('f::'));
// Array
// (
//     [f] => 
// )
print_r(getopt('f:'));
// Array
// (
// )

// php 如何获取PHP命令行参数.php -f 22
print_r(getopt('f::'));
// Array
// (
//     [f] => 
// )
print_r(getopt('f:'));
// Array
// (
//     [f] => 22
// )

// php 如何获取PHP命令行参数.php -f=22
print_r(getopt('f::'));
// Array
// (
//     [f] => 22
// )
print_r(getopt('f:'));
// Array
// (
//     [f] => 22
// )


// php 如何获取PHP命令行参数.php -f=22 aa -b=33
// 选项的解析会终止于找到的第一个非选项，之后的任何东西都会被丢弃。
// Array
// (
//     [f] => 22
// )

$optind = null;
getopt('f:b:', [], $optind);
echo $optind, PHP_EOL; // 2
echo $argv[$optind], PHP_EOL; // aa

