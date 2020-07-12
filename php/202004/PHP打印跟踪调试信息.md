# PHP打印跟踪调试信息

对于大部分编译型语言来说，比如 C 、 Java 、 C# ，我们都能很方便地进行断点调试，但是 PHP 则必须安装 XDebug 并且在编辑器中进行复杂的配置才能实现断点调试的能力。不过，如果只是简单的调试并且查看堆栈回溯的话，其实 PHP 已经为我们准备好了两个函数，能够让我们非常方便的看到程序运行时的调用情况。

## debug_backtrace()

从这个方法的字面意思上就可以看出，它的意思就是调试回溯，返回的也正是一段回溯信息的数组。

```php
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
```

这个方法必须在函数中调用，在函数方法外部使用是不会有内容的。从内容中看，它输出了关于这个函数的 \_\_FILE__ 、 \_\_LINE__ 、 \_\_FUNCTION__ 、$argv 等信息。其实就是关于当前打印这行所在函数的相关内容。

我们当然也可以多嵌套几层函数来看一下打印出的内容是什么。

```php
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
```

没错，数组的输出顺序就是一个栈的执行顺序，b_test() 最先调用，所以它在栈底，对应的输出也就是数组中的最后一个元素。

在类中也是类似的使用方法。

```php
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
```

在类中使用的时候，在数组项中会多出一个 object 字段，显示的是这个方法所在类的信息。

debug_backtrace() 的函数声明是：

```php
debug_backtrace ([ int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT [, int $limit = 0 ]] ) : array
```

其中 \\$options 是有两个常量可以定义，DEBUG_BACKTRACE_PROVIDE_OBJECT 表明是否填充 "object" 的索引；DEBUG_BACKTRACE_IGNORE_ARGS 是否忽略 "args" 的索引，包括所有的 function/method 的参数，能够节省内存开销。 $limits 可用于限制返回堆栈帧的数量，默认为0返回所有的堆栈。

debug_backtrace() 以及下面要介绍的 debug_print_backtrace() 方法都是支持 require/include 文件以及 eval() 中的代码的，在嵌入文件时，会输出嵌入文件的路径，这个大家可以自行尝试。

## debug_print_backtrace()

这个方法从名称也可以看出，它会直接打印回溯内容，它的函数声明和 debug_backtrace() 是一样的，不过 $options 默认是 DEBUG_BACKTRACE_IGNORE_ARGS ，也就是说，它只打印调用所在文件及行数。

```php
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
```

另外就是这个函数不需要使用 var_dump() 或 print_r() 进行输出，直接使用这个函数就会进行输出。能够非常快捷方便的让我们进行调试，比如在 laravel 这类大型框架中，我们在控制器需要查看堆栈信息时，就可以使用 debug_print_backtrace() 快速地查看当前的堆栈调用情况。而 debug_backtrace() 如果没有指定 $options 的话，则会占用非常大的内存容量或者无法完整显示。

## 总结

今天介绍的这两个函数能够灵活地帮助我们调试代码或者了解一个框架的调用情况。当然，在正式的情况下还是推荐使用 Xdebug 加上编辑器的支持来进行断点调试，因为使用 debug_backtrace() 这两个方法我们无法看到变量的变化情况。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E6%89%93%E5%8D%B0%E8%B7%9F%E8%B8%AA%E8%B0%83%E8%AF%95%E4%BF%A1%E6%81%AF.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E6%89%93%E5%8D%B0%E8%B7%9F%E8%B8%AA%E8%B0%83%E8%AF%95%E4%BF%A1%E6%81%AF.php)

参考文档：
[https://www.php.net/manual/zh/function.debug-backtrace.php](https://www.php.net/manual/zh/function.debug-backtrace.php)
[https://www.php.net/manual/zh/function.debug-print-backtrace.php](https://www.php.net/manual/zh/function.debug-print-backtrace.php)