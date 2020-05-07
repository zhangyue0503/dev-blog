# 一起搞懂PHP的错误和异常（一）

在PHP的学习过程中，我们会接触到两个概念，一个是错误，一个是异常。啥玩意？他们不是一个东西嘛？如果接触过Java、C#之类的纯面向对象语言的同学，可能对异常是没有什么问题，毕竟所有的问题都可以try...catch来解决。但是像PHP这种从面向过程发展到面向对象的语言来说，错误和异常就是两个完全不同的东西了。

我们将用一系列的文章来彻底的搞懂PHP中的错误和异常到底是怎么回事，有哪些处理这些错误和异常的机制，我们应该如何对待它们。

## 什么是错误？

错误，一般是由PHP本身的因素所导致的问题，错误的语法、环境的配置不当等都会引起错误。错误和php.ini文件当中的error_reporting参数有直接的关系。相信大家都配过这个参数。一般会把它配置为 E_ALL & ~E_NOTICE 。这是什么意思呢？我们先来看看PHP中有哪些错误类型：

- Fatal Error:致命错误（脚本终止运行）
    - E_ERROR         // 致命的运行错误，错误无法恢复，暂停执行脚本
    - E_CORE_ERROR    // PHP启动时初始化过程中的致命错误
    - E_COMPILE_ERROR // 编译时致命性错，就像由Zend脚本引擎生成了一个E_ERROR
    - E_USER_ERROR    // 自定义错误消息。像用PHP函数trigger_error（错误类型设置为：E_USER_ERROR）

- Parse Error：编译时解析错误，语法错误（脚本终止运行）
    - E_PARSE  //编译时的语法解析错误

- Warning Error：警告错误（仅给出提示信息，脚本不终止运行）
    - E_WARNING         // 运行时警告 (非致命错误)。
    - E_CORE_WARNING    // PHP初始化启动过程中发生的警告 (非致命错误) 。
    - E_COMPILE_WARNING // 编译警告
    - E_USER_WARNING    // 用户产生的警告信息

- Notice Error：通知错误（仅给出通知信息，脚本不终止运行）
    - E_NOTICE      // 运行时通知。表示脚本遇到可能会表现为错误的情况.
    - E_USER_NOTICE // 用户产生的通知信息。

在配置文件中的 E_ALL & ~E_NOTICE 就是显示所有错误但通知错误类错误除外的意思。当然，我们在代码中也可以手动的改变这种错误信息的通知。

```php
error_reporting(E_ALL);
```

通过这行代码，我们就让当前文件代码中的错误全部显示出来了。Notice 和 Warning 类型的错误是不会中断代码运行的，他们是通知和报警，并不是致命的错误。而其他类型的错误则会中断代码的执行。

```php
$a = 100 / 0; // Warning: Division by zero
echo $f; // Notice: Undefined variable: f 
test(); // Fatal error: Uncaught Error: Call to undefined function test()

echo 1;
```

上述代码中分别是Warning的除0错误警告和echo $f;的未定义变量提示，这两行代码都是可以在报错后可以继续向下运行的。而未定义的方法则是Fatal级别的致命错误了。所以最后那个1也不会输出了。

那么错误要如何处理呢？原则上我们应该是要去消灭这些错误的，因为他们基本上不会是我们写代码的逻辑没理清而产生的逻辑错误，是实打实的一些语法及环境错误，这种错误在生产环境是不应该出现的。同时，它们与异常最最重要的一个区别就是，它们无法通过try...catch进行捕获。也就是说，这种错误没有非常好的错误后处理机制。

```php
try {
    $a = 100 / 0; // Warning: Division by zero
    echo $f; // Notice: Undefined variable: f 
} catch (Excepiton $e) {
    print_r($e); // 无法捕获
} 
```

不过，PHP还是提供了一些处理错误的函数供我们使用。

1. set_error_handler()

基本上只能处理 Warning 和 Notice 级别的错误。

```php
set_error_handler(function( $errno , $errstr ){
    echo 'set_error_handler：', $errno, $errstr, PHP_EOL;
});
$a = 100 / 0; // Warning: Division by zero
echo $f; // Notice: Undefined variable: f 
test(); // Fatal error: Uncaught Error: Call to undefined function test()

// set_error_handler：2Division by zero
// set_error_handler：8Undefined variable: f
```

从代码中可以看出，Fatal error这种致命错误并没有捕获到。

2. register_shutdown_function()

其实它也不是用来处理错误的，这个函数的作用是在发生致命错误，程序停止前最后会调用的一个函数。可以用来记录日志或者关闭一些重要的外部句柄，不过在生产环境中，我们一般会用php.ini中的log_error来进行日志的记录。所以这个函数也用得并不多。

```php
register_shutdown_function(function(){
    echo 'register_shutdown_function：', PHP_EOL;
    print_r(error_get_last());
});
test();

// register_shutdown_function：
// Array
// (
//     [type] => 1
//     [message] => Uncaught Error: Call to undefined function test() in /php/202002/source/一起搞懂PHP的错误和异常（一）.php:16
// Stack trace:
// #0 {main}
//   thrown
//     [file] => /php/202002/source/一起搞懂PHP的错误和异常（一）.php
//     [line] => 16
// )
```

这个函数的回调函数中没有任何的参数变量，所以我们需要通过 error_get_last() 来拿到本次执行中发生的所有错误情况。另外要注意的是，只有在运行时产生的错误都会调用到这个注册函数的回调中，编译时的错误是也是无法通过这个函数捕获到的，比如直接的语法错误：

```php
register_shutdown_function(function(){
    echo 'register_shutdown_function：', PHP_EOL;
    print_r(error_get_last());
});

test(a+-); // Parse error: syntax error, unexpected ')' 
```

## 总结 

综上所述，就像在文章前面说过的，错误是应该尽量不要带到生产环境中去的，它们并没有很好的处理机制。或者说，错误就是我们要尽量避免的东西，因为大部分情况下它和我们的逻辑代码并没有太大的关系。而且严重的错误会直接导致程序运行的中止，无法像异常一样通过catch机制保证程序继续运行。

下一篇我们将继续学习下一个知识点：**异常**及其处理机制。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E4%B8%80%E8%B5%B7%E6%90%9E%E6%87%82PHP%E7%9A%84%E9%94%99%E8%AF%AF%E5%92%8C%E5%BC%82%E5%B8%B8%EF%BC%88%E4%B8%80%EF%BC%89.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E4%B8%80%E8%B5%B7%E6%90%9E%E6%87%82PHP%E7%9A%84%E9%94%99%E8%AF%AF%E5%92%8C%E5%BC%82%E5%B8%B8%EF%BC%88%E4%B8%80%EF%BC%89.php)

参考文档：
[https://www.cnblogs.com/zyf-zhaoyafei/p/6928149.html](https://www.cnblogs.com/zyf-zhaoyafei/p/6928149.html)
[https://www.php.net/manual/zh/language.errors.basics.php](https://www.php.net/manual/zh/language.errors.basics.php)
[https://www.php.net/manual/zh/errorfunc.constants.php](https://www.php.net/manual/zh/errorfunc.constants.php)
[https://www.php.net/manual/zh/errorfunc.configuration.php#ini.error-reporting](https://www.php.net/manual/zh/errorfunc.configuration.php#ini.error-reporting)
[https://www.php.net/manual/zh/function.error-reporting.php](https://www.php.net/manual/zh/function.error-reporting.php)
[https://www.php.net/manual/zh/function.set-error-handler.php](https://www.php.net/manual/zh/function.set-error-handler.php)
[https://www.php.net/manual/zh/function.register-shutdown-function.php](https://www.php.net/manual/zh/function.register-shutdown-function.php)
