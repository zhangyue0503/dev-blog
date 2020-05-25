# 一起学习PHP中断言函数的使用

原来一直以为断言相关的函数是 PHPUnit 这些单元测试组件提供的，在阅读手册后才发现，这个 assert() 断言函数是 PHP 本身就自带的一个函数。也就是说，我们在代码中进行简单的测试的时候是不需要完全引入整个单元测试组件的。

## assert() 断言函数

```php

assert(1==1);

assert(1==2);
// assert.exception = 0 时，Warning: assert(): assert(1 == 2)
// assert.exception = 1 时，Fatal error: Uncaught AssertionError: 验证不通过
```

很明显，第二段代码无法通过断言验证。这时，PHP 就会返回一个警告或者异常错误。为什么有可能是两种错误形式呢？当我们设置 php.ini 中的 assert.exception 为 off 或者 0 时，也就是关闭这个参数的能力时，程序就会以 PHP5 的形式依然返回一个警告，就像上面代码中的注释一样。同时，通过 try...catch 也无法进行异常的捕获了。这个参数其实就是控制是否以正被的异常对象进行抛出。如果保持这个参数为默认情况也就是设置为 on 或者 1 的话，就会直接抛出异常，程序中止。

从上述代码可以看出，断言的第一个参数是一个表达式，而且是需要一个返回 bool 类型对象的表达式。如果我们传递的是一个字符串或者一个数字呢？

```php
// 设置 assert.exception = 0 进行多条测试

assert(" ");
// Deprecated: assert(): Calling assert() with a string argument is deprecated
// Warning: assert(): Assertion " " failed

assert("1");
// Deprecated: assert(): Calling assert() with a string argument is deprecated

assert(0);
// Warning: assert(): assert(0) failed

assert(1);

assert("1==2");
// Deprecated: assert(): Calling assert() with a string argument is deprecated
// Warning: assert(): Assertion "1==2" failed 
```

很明显第一个参数的表达式会进行类型强制转换，但是字符串类型会多出一个过时提醒，表明给 assert() 函数传递字符串类型的表达式类型已经过时了。当前的测试版本是 7.3 ，在将来可能就会直接报中止运行的错误或异常了。主要问题在于，如果传递的字符串本身也是一个表达式的话，会以这个表达式的内容为基础进行判断，这样很容易产生歧义，就像最后一段代码一样。当然，已经过时的使用方式还是不推荐的，这里仅是做一个了解即可。

接下来我们看一下 assert() 函数的其他参数，它的第二个参数是两种类型，要么给一个字符串用来定义错误的信息，要么给一个 异常类 用于抛出异常。

```php
assert(1==1, "验证不通过");

assert(1==2, "验证不通过");
// Warning: assert(): 验证不通过 failed 
```

如果直接给的一个字符串，那么在警告的提示信息中，显示的就是我们定义的这个错误信息的内容。这个非常好理解。

```php
// 注意 assert.exception 设置不同的区别

assert(1==1,  new Exception("验证不通过"));

assert(1==2,  new Exception("验证不通过"));
// assert.exception = 1 时，Fatal error: Uncaught Exception: 验证不通过
// assert.exception = 0 时，Warning: assert(): Exception: 验证不通过
```

当然，我们也可以给一个 异常类 让断言抛出一个异常。在默认情况下，这个异常的抛出将中止程序的运行。也就是一个正常的异常抛出流程，我们可以使用 try...catch 进行异常的捕获。

```php
try{
    assert(1==2,  new Exception("验证不通过"));
}catch(Exception $e){
    echo "验证失败！:", $e->getMessage(), PHP_EOL;
}
// 验证失败！:验证不通过
```

另外还有一个参数会对断言的整体运行产生影响，那就是 php.ini 中的 zend.assertions 参数。它包含三个值：

- 1，生成并执行代码，一般在测试环境使用
- 0，生成代码但是在运行时会路过
- -1，不生成代码，一般在正式环境使用

这个参数大家可以自行配置测试，默认的 php.ini 中它的默认值是 1 ，也就是正常的执行 assert() 函数。

## assert_options() 及相对应的 php.ini 中的参数配置

PHP 中的断言功能还为我们提供了一个 assert_options() 函数，用于方便地设置和获取一些和断言能力有关的参数配置。它能够设置的断言标志包括：

标志 | INI设置 | 默认值 | 描述
- | :-: | :-: | -:
ASSERT_ACTIVE | assert.active | 1 | 启用 assert() 断言
ASSERT_WARNING | assert.warning | 1 | 为每个失败的断言产生一个 PHP 警告（warning）
ASSERT_BAIL | assert.bail | 0 | 在断言失败时中止执行
ASSERT_QUIET_EVAL | assert.quiet_eval | 0 | 在断言表达式求值时禁用 error_reporting
ASSERT_CALLBACK | assert.callback | (NULL) | 断言失败时调用回调函数

这些参数的含义都非常好理解，大家可以自己测试一下。我们就来看一下最后一个 ASSERT_CALLBACK 的作用。其实它的说明也非常清楚，就是断言失败的情况下就进入到这个选项定义的回调函数中。

```php
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_BAIL, 1);

assert_options(ASSERT_CALLBACK, function($params){
    echo "====faild====", PHP_EOL;
    var_dump($params);
    echo "====faild====", PHP_EOL;
});

assert(1!=1);
// ====faild====
// string(105) ".../source/一起学习PHP中断言函数的使用.php"
// ====faild====
```

当断言失败的时候，我们就进入了回调函数中，在回调函数直接简单的打印了传给回调函数的参数内容。可以看出，这个回调函数里面传递过来的是无法通过断言的文件信息。

## 总结 

学习掌握一下断言函数的使用及配置，可以为我们将来学习 PHPUnit 单元测试打下基础，当然，本身这个能力的东西就不是很多，大家记住就好啦！

测试代码：

参考文档：
[https://www.php.net/manual/zh/function.assert-options.php](https://www.php.net/manual/zh/function.assert-options.php)
[https://www.php.net/manual/zh/function.assert.php](https://www.php.net/manual/zh/function.assert.php)





