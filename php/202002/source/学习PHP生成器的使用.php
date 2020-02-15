<?php

function test1()
{
    for ($i = 0; $i < 3; $i++) {
        yield $i + 1;
    }
    yield 1000;
}

foreach (test1() as $t) {
    echo $t, PHP_EOL;
}

// 1
// 2
// 3
// 1000

// 是一个生成器对象
var_dump(test1());

// Generator Object
// (
// )

// 内存占用测试
$start_time = microtime(true);
function test2($clear = false)
{
    $arr = [];
    if($clear){
        $arr = null;
        return;
    }
    for ($i = 0; $i < 1000000; $i++) {
        $arr[] = $i + 1;
    }
    return $arr;
}
$array = test2();
foreach ($array as $val) {
}
$end_time = microtime(true);

echo "time: ", bcsub($end_time, $start_time, 4), PHP_EOL;
echo "memory (byte): ", memory_get_usage(true), PHP_EOL;

// time: 0.0513
// memory (byte): 35655680

$start_time = microtime(true);
function test3()
{
    for ($i = 0; $i < 1000000; $i++) {
        yield $i + 1;
    }
}
$array = test3();
foreach ($array as $val) {

}
$end_time = microtime(true);

echo "time: ", bcsub($end_time, $start_time, 4), PHP_EOL;
echo "memory (byte): ", memory_get_usage(true), PHP_EOL;

// time: 0.0517
// memory (byte): 2097152

// 返回空值以及中断
function test4()
{
    for ($i = 0; $i < 10; $i++) {
        if ($i == 4) {
            yield; // 返回null值
        }
        if ($i == 7) {
            return; // 中断生成器执行
        }
        yield $i + 1;
    }
}

foreach (test4() as $t) {
    echo $t, PHP_EOL;
}


// 1
// 2
// 3
// 4

// 5
// 6
// 7

// 返回键值对形式
function test5()
{
    for ($i = 0; $i < 10; $i++) {
        yield 'key.' . $i => $i + 1;
    }
}

foreach (test5() as $k=>$t) {
    echo $k . ':' . $t, PHP_EOL;
}

// key.0:1
// key.1:2
// key.2:3
// key.3:4
// key.4:5
// key.5:6
// key.6:7
// key.7:8
// key.8:9
// key.9:10

// 外部传递数据
function test6()
{
    for ($i = 0; $i < 10; $i++) {
        // 正常获取循环值，当外部send过来值后，yield获取到的就是外部传来的值了
        $data = (yield $i + 1);
        if($data == 'stop'){
            return;
        }
    }
}
$t6 = test6();
foreach($t6 as $t){
    if($t == 3){
        $t6->send('stop');
    }
    echo $t, PHP_EOL;
}

// 1
// 2
// 3



$c = count(test1()); // Warning: count(): Parameter must be an array or an object that implements Countable
// echo $c, PHP_EOL;

// 利用生成器生成斐波那契数列
function fibonacci($item)
{
    $a = 0;
    $b = 1;
    for ($i = 0; $i < $item; $i++) {
        yield $a;
        $a = $b - $a;
        $b = $a + $b;
    }
}

$fibo = fibonacci(10);
foreach ($fibo as $value) {
    echo "$value\n";
}
