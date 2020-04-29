<?php


function a_test($str)
{
    echo "Hi: $str", PHP_EOL;
    var_dump(debug_backtrace());
}

var_dump(debug_backtrace());

a_test("A");

// Hi: A/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:7:
// array(1) {
//   [0] =>
//   array(4) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(12)
//     'function' =>
//     string(6) "a_test"
//     'args' =>
//     array(1) {
//       [0] =>
//       string(1) "A"
//     }
//   }
// }

function b_test(){
    c_test();
}

function c_test(){
    a_test("b -> c -> a");
}

b_test();

// Hi: b -> c -> a
// /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:7:
// array(3) {
//   [0] =>
//   array(4) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(37)
//     'function' =>
//     string(6) "a_test"
//     'args' =>
//     array(1) {
//       [0] =>
//       string(11) "b -> c -> a"
//     }
//   }
//   [1] =>
//   array(4) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(33)
//     'function' =>
//     string(6) "c_test"
//     'args' =>
//     array(0) {
//     }
//   }
//   [2] =>
//   array(4) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(40)
//     'function' =>
//     string(6) "b_test"
//     'args' =>
//     array(0) {
//     }
//   }
// }

class A{
    function test_a(){
        $this->test_b();
    }
    function test_b(){
        var_dump(debug_backtrace());
    }
}

$a = new A();
$a->test_a();

// /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:90:
// array(2) {
//   [0] =>
//   array(7) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(87)
//     'function' =>
//     string(6) "test_b"
//     'class' =>
//     string(1) "A"
//     'object' =>
//     class A#1 (0) {
//     }
//     'type' =>
//     string(2) "->"
//     'args' =>
//     array(0) {
//     }
//   }
//   [1] =>
//   array(7) {
//     'file' =>
//     string(93) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php"
//     'line' =>
//     int(95)
//     'function' =>
//     string(6) "test_a"
//     'class' =>
//     string(1) "A"
//     'object' =>
//     class A#1 (0) {
//     }
//     'type' =>
//     string(2) "->"
//     'args' =>
//     array(0) {
//     }
//   }
// }

function a() {
    b();
}

function b() {
    c();
}

function c(){
    debug_print_backtrace();
}

a();

#0  c() called at [/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:144]
#1  b() called at [/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:140]
#2  a() called at [/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/PHP打印跟踪调试信息.php:151]


