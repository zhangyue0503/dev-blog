<?php

// 引用不是指针
$a = 1;
$b = &$a;
echo $a, '===', $b, PHP_EOL;
unset($b);
echo $a, '===', $b, PHP_EOL;


// 数组引用问题
$arr1 = ["a", "b"];
$t1 = &$arr1[1];
$arr2 = $arr1;
$arr2[1] = "c";
var_dump($arr1);

// array(2) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     &string(1) "c"
// }

$arr1 = ["a", "b"];
$t1 = &$arr1[1];
unset($t1); // unset 掉引用
$arr2 = $arr1;
$arr2[1] = "c";
var_dump($arr1);

// array(2) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     string(1) "b"
// }

// 对象引用问题
$o1 = new stdClass();
$o1->a = 'a';
var_dump($o1);
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(1) "a"
// }

$o2 = &$o1;
$o3 = $o1;

$o2->a = 'aa';

var_dump($o1);
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(2) "aa"
// }

var_dump($o3); // $o2修改了$a为'aa'，$o3也变成了'aa'
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(2) "aa"
// }

$o1->a = 'aaa';
$o1 = null;
var_dump($o2); // $o2引用变成了null
// NULL

var_dump($o3); // $o3不仅引用还存在，并且$a变成了'aaa'
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(3) "aaa"
// }

// 引用传递
error_reporting(E_ALL);
function foo(&$var)
{
    $var++;
    echo 'foo：', $var;
}
function bar() // Note the missing &
{
    $a = 5;
    return $a;
}
foo(bar()); // 自 PHP 5.0.5 起导致致命错误，自 PHP 5.1.1 起导致严格模式错误
            // 自 PHP 7.0 起导致 notice 信息,Notice: Only variables should be passed by reference
foo($a = 5); // 表达式，不是变量, Notice: Only variables should be passed by reference
// foo(5); // 导致致命错误 !5是个常量!

///////////////////////////////
// 正确的传递类型
$a = 5;
foo($a); // 变量

function &baz() // Note the missing &
{
    $a = 5;
    return $a;
}
foo(baz()); // 从函数中返回的引用

function foo1(&$var)
{
    print_r($var);
}
foo1(new stdClass()); // new 表达式

// 引用返回
$a = 1;
function &test(){
    global $a;
    return $a;
}

$b = &test($a);
$b = 2;
echo $a, PHP_EOL;

// 引用取消
$a = 1;
$b = &$a;
$c = &$b;
$b = 2;
echo '定义引用后：', $a, '===', $b, '===', $c, PHP_EOL;

unset($b);
$b = 3;
echo '取消$b的引用，不影响$a、$c：', $a, '===', $b, '===', $c, PHP_EOL;

$b = &$a;
unset($a);
echo '取消$a，不影响$b、$c：', $a, '===', $b, '===', $c, PHP_EOL;

// 定义引用后：2===2===2
// 取消$b的引用：2===3===2
// 取消$a，不影响$c：===3===2


$a = 1;
$b = & $a;
$c = & $b; // $a, $b, $c reference the same content '1'

$a = NULL; // All variables $a, $b or $c are unset
echo '所有引用成空：', $a, '===', $b, '===', $c, PHP_EOL;


