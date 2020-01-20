<?php

namespace A;

include 'namespace/file1.php';
include 'namespace/file2.php';
// include 'namespace/file1-1.php'; // Cannot redeclare FILE1\testA()
include 'namespace/file1-2.php';

use FILE1, FILE2; 
use FILE1\objectA as objectB;

const CONST_A = 1;
function testA(){
    echo 'A\testA()', PHP_EOL;
}

class objectA{
    function test(){
        echo 'A\ObjectA', PHP_EOL;
    }
}

// 当前命名空间
echo CONST_A, PHP_EOL; // 1
testA(); // A\testA()
$oA = new objectA();
$oA->test(); // A\ObjectA

// FILE1
echo FILE1\CONST_A, PHP_EOL; // 2
FILE1\testA(); // FILE1\testA()
$oA = new FILE1\objectA();
$oA->test(); // FILE1\ObjectA

$oB = new objectB();
$oB->test(); // FILE1\ObjectA

// FILE2
echo FILE2\CONST_A, PHP_EOL; // 3
FILE2\testA(); // FILE2\testA()
$oA = new FILE2\objectA();
$oA->test(); // FILE2\ObjectA

// FILE1_2
echo FILE1\CONST_A, PHP_EOL; // 3
FILE1\testA1_2(); // FILE1-2\testA()
$oA = new FILE1\objectA1_2();
$oA->test(); // FILE1-2\ObjectA






