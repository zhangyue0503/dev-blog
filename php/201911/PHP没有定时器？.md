# PHP没有定时器？

确实，PHP没有类似于JS中的setInterval或者setTimeout这样的原生定时器相关的函数。但是我们可以通过其他方式来实现，比如使用declare。

先来看看是如何实现的，然后我们再好好学习一下declare表达式到底是个什么东西。

```php

function do_tick($str = '')
{
    list($sec, $usec) = explode(' ', microtime());
    printf("[%.4f] Tick.%s\n", $sec + $usec, $str);
}
register_tick_function('do_tick');

do_tick('--start--');
declare (ticks = 1) {
    while (1) {
        sleep(1); // 这里，每执行一次就去调用一次do_tick()
    }
}

```

很简单的代码，运行起来以后将每秒输出当前的时间。declare语法的定义如下：

```php
declare (directive)
    statemaent;
```

- declare 结构用来设定一段代码的执行指令
- directive 部分允许设定 declare 代码段的行为。目前只认识两个指令：ticks以及 encoding
- Tick（时钟周期）是一个在 declare 代码段中解释器每执行 N 条可计时的低级语句就会发生的事件。N 的值是在 declare 中的 directive 部分用 ticks=N 来指定的
- 在每个 tick 中出现的事件是由 register_tick_function() 来指定的

这里，我们只研究ticks的使用。

上述代码中，我们使用register_tick_function()注册了do_tick()方法给ticks，declare指定了ticks=1，也就是每执行一次可计时的低级语句，就会去执行一次register_tick_function()中注册的方法。当declare代码块中的while每次循环时，都有一个sleep()停顿了一秒，而这个sleep()就是那个可计时的低级语句。

那么，while()不是可计时的低级语句嘛？当然不是，where、if等条件判断都不是这种可计时的低级语句。

> 不是所有语句都可计时。通常条件表达式和参数表达式都不可计时。

我们通过下面这个例子再来看看具体到一步步declare是怎样执行的：

```php

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

// declare使用花括号后面所有代码无效果，作用域限定在花括号以内
echo "bbb"; // 
echo "ccc"; // 
echo "ddd"; // 

```

注释很详细了，我们就不用一一说明了。下面我们来看将ticks定为2，并且declare下面的statemaent不用花括号的结果：

```php 

function test_tick1() 
{
    static $i = 0;
    echo 'test_tick1:' . $i++, PHP_EOL;
}
register_tick_function('test_tick1');

$j = 0; // 此处不计时
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
echo "ccc";
echo "ddd"; // test_tick1:4

```

可以看出，我们declare对其定义后续的代码都产生了作用，但需要注意的是如果有页面嵌套，对父页面的后续代码是没有效果的。而定义了ticks=2之后，将在两个低级可计时代码后执行一次register_tick_function()注册的函数代码。

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E6%B2%A1%E6%9C%89%E5%AE%9A%E6%97%B6%E5%99%A8%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E6%B2%A1%E6%9C%89%E5%AE%9A%E6%97%B6%E5%99%A8%EF%BC%9F.php)

参考文档：[https://www.php.net/manual/zh/control-structures.declare.php](https://www.php.net/manual/zh/control-structures.declare.php)
