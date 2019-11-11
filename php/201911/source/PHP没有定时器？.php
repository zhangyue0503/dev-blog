<?php
// PHP定时器，测试后面的代码请注释掉这一段
// ==============
// function do_tick($str = '')
// {
//     list($sec, $usec) = explode(' ', microtime());
//     printf("[%.4f] Tick.%s\n", $sec + $usec, $str);
// }
// register_tick_function('do_tick');

// do_tick('--start--');
// declare (ticks = 1) {
//     while (1) {
//         sleep(1); // 这里，每执行一次就去调用一次do_tick()
//     }
// }
// // ==============

function test_tick()
{
    static $i = 0;
    echo 'test_tick:' . $i++, PHP_EOL;
}
register_tick_function('test_tick');
test_tick(); // test_tick:0

$j = 0; 
declare (ticks = 1) {
    $j++; // test_tick:1

    $j++; // test_tick: 2
    
    sleep(1); //  停1秒后，test_tick:3

    $j++; // test_tick:4

    if ($j == 3) { // 判断表达式在结束时计算tick

        echo "aa", PHP_EOL; // test_tick:5 \n   test_tick:6，PHP_EOL会计一次ticks
    }
}

// declare使用花括号后面所有代码无效果
echo "bbb"; // 
echo "ccc"; // 
echo "ddd"; // 

function test_tick1() 
{
    static $i = 0;
    echo 'test_tick1:' . $i++, PHP_EOL;
}
register_tick_function('test_tick1');

$j = 0;
declare (ticks = 2); 
$j++; // test_tick1:0 

$j++; 

sleep(1); //  停1秒后 test_tick1:1

$j++; 

$j++; // test_tick1:2

if ($j == 4) { // 判断表达式不会进行ticks计算
    // echo "aa", PHP_EOL;
    echo "aa"; // test_tick:10,test_tick1不执行，没有跳两步，如果用了,PHP_EOL，那么算两步，会输出test_tick1:3
}

//  declare没有使用花括号将对后面所有代码起效果，如果是require或者include将不会对父页面后续内容进行处理
echo "bbb"; // test_tick1:3
echo "ccc"; // 
echo "ddd"; // test_tick1:4