<?php

// 命名空间
include 'namespace/file1.php';

use FILE1\objectA;
use FILE1\objectA as objectB;

echo FILE1\CONST_A, PHP_EOL; // 2

$oA = new objectA();
$oA->test(); // FILE1\ObjectA

$oB = new objectB();
$oB->test(); // FILE1\ObjectA

// trait
trait A
{
    public function testTrait()
    {
        echo 'This is Trait A!', PHP_EOL;
    }
}

class B
{
    use A;
}

$b = new B();
$b->testTrait();

// 匿名函数传参
$a = 1;
$b = 2;
// function test($fn) use ($a) // arse error: syntax error, unexpected 'use' (T_USE), expecting '{' 
function test($fn)
{
    global $b;
    echo 'test:', $a, '---', $b, PHP_EOL; // test:---2
    $fn(3);
}

test(function ($c) use ($a) {
    echo $a, '---', $b, '---', $c, PHP_EOL;
});
// 1------3
