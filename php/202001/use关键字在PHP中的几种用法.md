# use关键字在PHP中的几种用法

在学习了和使用了这么多年的PHP之后，您知道use这个关键字在PHP中都有哪些用法吗？今天我们就来看一下它的三种常见用法。

## 1. 用于命名空间的别名引用

```php
// 命名空间
include 'namespace/file1.php';

use FILE1\objectA;
use FILE1\objectA as objectB;

echo FILE1\CONST_A, PHP_EOL; // 2

$oA = new objectA();
$oA->test(); // FILE1\ObjectA

$oB = new objectB();
$oB->test(); // FILE1\ObjectA
```

这个想必在日常的工程化开发中会非常常见。毕竟现在的框架都是使用了命名空间的，不管做什么都离不开各种类依赖的调用，在各种控制器文件的上方都会有大量的use xxx\xxx\xxx;语句。

## 2. 用于trait特性能力的引入

```php
// trait
trait A{
    function testTrait(){
        echo 'This is Trait A!', PHP_EOL;
    }
}

class B {
    use A;
}

$b = new B();
$b->testTrait();
```

即使在最近这两年，依然还是见过完全没有用过trait的PHP程序员，不要惊讶，这是真实存在的。想想还有那么多项目都还在用TP3也就不奇怪了。trait特性还是非常方便的一种类功能扩展模式，其实我们可以看作是将这个use放在了类中就成为了trait的引用定义了。

## 3. 匿名函数传参

```php
// 匿名函数传参

$a = 1;
$b = 2;
// function test($fn) use ($a) // arse error: syntax error, unexpected 'use' (T_USE), expecting '{' 
function test($fn)
{
    global $b;
    echo 'test:', $a, '---', $b, PHP_EOL; // test:---2
    $fn(3);
}

test(function ($c) use ($a) {
    echo $a, '---', $b, '---', $c, PHP_EOL;
});
// 1------3
```

这个就有点意思了吧，方法中要调用外部的变量是需要global的，在这里我们直接通过use()也是可以将变量传递过去的。而且这个仅限于在匿名函数中使用。

测试代码：
