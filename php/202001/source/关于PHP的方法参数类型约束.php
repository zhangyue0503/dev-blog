<?php
class A{}
function testA(A $a){
    var_dump($a);
}

testA(new A());
// testA(1); 
// Fatal error: Uncaught TypeError: Argument 1 passed to testA() must be an instance of A, int given,


function testB(int $a){
    var_dump($a);
}
testB(1);
testB('52aadfdf'); // 字符串强转为int了
// testB('a');
// Fatal error: Uncaught TypeError: Argument 1 passed to testB() must be of the type int, string given

function testC(string $a){
    var_dump($a);
}
testC('测试');
testC(1);  // 数字会强转为字符串
// testC(new A()); 
// Fatal error: Uncaught TypeError: Argument 1 passed to testC() must be of the type string

// 接口类型
interface D{}
class childD implements D{}
function testD(D $d){
    var_dump($d);
}
testD(new childD());

// 回调匿名函数类型
function testE(Callable $e, string $data){
    $e($data);
}
testE(function($data){
    var_dump($data);
}, '回调函数');


