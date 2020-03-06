# 一起搞懂PHP的错误和异常（三）

关于错误与异常的最后一篇文章，我们来进行一些总结。

## PHP中错误和异常的区别

通过前面两篇文章的学习，我们来直接将错误和异常摆上来进行对比，看看他们的区别与联系：

- 错误的出现通常是语法或编译运行时错误，是我们要避免的。而异常一般与业务逻辑有关，基本上是人为抛出，需要上层来处理
- 错误有通知、警告类不会中断程序运行，有严重错误会让程序立即中止运行。中止运行的程序没有别的方式让程序继续运行。异常可以通过try...catch捕获，捕获后的异常可以继续运行，不捕获的异常直接导致程序中止运行
- 错误的提示与php.ini中的配置有关，线上尽量不要显示错误。错误也尽量不要带线上。线上的错误记录到日志中，开发的错误显示则尽量打开方便开发人员及时调试。

## PHP7对待错误的变化
PHP7中重新定义了一些错误的处理方式，让大部分错误可以进行捕获。而且增加了一个 Throwable 接口，它可以捕获大部分的错误和所有的异常。

也就是说，很多错误可以通过try...catch进行捕获了。而无法捕获的基本上是警告类的错误，这些错误可以通过  set_exception_handler() 进行注册处理。

Error 类不是继承自 Exception 类，所以想全局捕获的话最好还是使用 Throwable 来进行捕获，不管是 Error 还是 Exception 都实现了这个接口。

```php
try {
    test();
} catch (Throwable $e) {
    print_r($e);
}

echo '未定义test()', PHP_EOL;


try {
    new PDO();
} catch (ArgumentCountError $e) {
    print_r($e);
}

echo '没给PDO参数', PHP_EOL;

function test1() : int{
    return 'test';
}
try {
    test1();
} catch (TypeError $e) {
    print_r($e);
}

echo '返回值类型不正确', PHP_EOL;
```

上面的例子中我们捕获了在PHP5中被定义为错误的异常。如果不使用try...catch进行捕获的话，它们在PHP7中依然会被当做错误来对待。我们来看看 Throwable 下面都有哪些新增加的错误异常处理类。

Throwable
- Error
    - ArithmeticError
        - DivisionByZeroError
    - AssertionError
    - CompileError
        - ParseError
    - TypeError
        - ArgumentCountError
- Exception
    - ...

另外我们还可以通过全局注册来对异常进行全局处理，也就是上面所说的 set_exception_handler() 方法。注意，使用这个全局注册异常处理后，出现异常后面的代码将不执行了。相当于进行了截断，这样的话只能记录一个异常日志。

```php
set_exception_handler(function ($ex) {
    echo 'set_exception_handler：', PHP_EOL;
    print_r($ex);
});
test();
echo 'Not Execute...'; // 不会输出了
```

像是除0这种错误，经过测试发现 DivisionByZeroError 类还是无法捕获，这样的错误如果想捕获，我们可以使用 set_error_handler() 获取异常后再抛出错误。

```php
set_error_handler(function ($errno, $errmsg) {
    if($errmsg == 'Division by zero'){
        throw new DivisionByZeroError();
    }else{
        throw new Error($errmsg, $errno + 10000);
    }
});

try{
    100 / 0; // DivisionByZeroError：DivisionByZeroError Object
    // echo $f; // Error: code = 10008
}catch(DivisionByZeroError $e){
    echo 'DivisionByZeroError：'; 
    print_r($e);
}catch(Error $e){
    echo 'Error'; 
    print_r($e);
}
```

通过 set_error_handler() 抛出异常，我们就可以捕获这些警告类型的错误了，不管是 warning 还是 notice 。可以切换注释来查看除0错误和未定义变量错误分别抛出的异常。不过就像我们一直强调的那样，这类错误是可以直接避免的，除前先对除数判断一下就可以直接抛出异常或者返回错误信息了，不要让PHP来报错。

## 总结

通过这三篇文章，可以说我们基本上能够清楚地了解PHP中错误和异常的区别、特点以及他们的使用场景，并且能够针对不同的错误和异常进行相应的处理了。当然，相关的内容其实还有很多，将来在发现类似的内容时我们还会通过单独的文章来进行独立的讲解。这次我们就先完结了总体的错误和异常的学习哈。接下来的学习将继续围绕PHP官方文档进行，后续依然精彩！！

测试代码：

参考文档：
[https://www.php.net/manual/zh/language.errors.php7.php](https://www.php.net/manual/zh/language.errors.php7.php)
[https://www.php.net/manual/zh/function.set-exception-handler.php](https://www.php.net/manual/zh/function.set-exception-handler.php)
[https://www.php.net/manual/en/class.error.php](https://www.php.net/manual/en/class.error.php)
