# PHP方法的返回值

不仅是PHP，大部分编程语言的函数或者叫方法，都可以用return来定义方法的返回值。从函数这个叫法来看，本身它就是一个计算操作，因此，计算总会有个结果，如果你在方法体中处理了结果，比如进行了持久化保存，那么这个函数就不用返回任何内容。而计算的结果是要给外部使用的，这时候就要将计算结果进行返回了。

&nbsp;
> return关键字

```php

function testA($a, $b)
{
    echo $a + $b;
}

var_dump(testA(1, 2)); // NULL

function testB($a, $b)
{
    return $a + $b;
}

var_dump(testB(1, 2)); // 3

function testC($a, $b)
{
    return;
    echo $a + $b; // 后面不会执行了
}

var_dump(testC(1, 2)); // NULL

```

不用return或者直接return;都会返回NULL，return会阻断方法体中后续代码的执行。如果要返回多个值，只能使用数组组装数据。

```php

function testD($a, $b)
{
    return [
        $a + $b,
        $a * $b,
    ];
}

var_dump(testD(1, 2)); // [3, 2]

```

&nbsp;
> 返回值类型声明

关于返回值这一块还是比较好理解的。下面才是重头戏，在PHP7的新特性中，返回值声明是非常亮眼的一道风景。

```php

function testE($a, $b) : bool
{
    if($a+$b == 3){
        return TRUE;
    }else{
        return NULL;
    }
}

var_dump(testE(1, 2)); // true
var_dump(testE(1.1, 2.2)); //TypeError: Return value of testE() must be of the type bool, null returned

```

如上例所示，如果返回值不是bool类型，那么将直接报TypeError的错误。

那么定义了返回值类型声明有什么好处呢？我们在[PHP方法参数的那点事儿](https://mp.weixin.qq.com/s/G2N8-BXAQvnac5emez6BPA)有介绍过类型声明的好处，这里就不过多赘述了，不管是参数类型声明还是返回值类型声明，都是一样的。

```php

function testF($a, $b): array
{
    return [
        $a + $b,
        $a * $b,
    ];
}
var_dump(testF(1, 2)); // [3, 2]

interface iA{

}
class A implements iA
{}
class B extends A
{
    public $b = 'call me B!';
}

function testG(): A
{
    return new B();
}

function testH(): B
{
    return new B();
}

function testI(): iA
{
    return new B();
}

var_dump(testG()); // B的实例
var_dump(testH()); // B的实例
var_dump(testI()); // B的实例

```

同样，数组和类类型都是可以声明定义的。不过除此之外，返回值声明还可以定义void。它的作用其实就是声明返回值为NULL，不能直接写:NULL，而只能用:void来进行声明。

```php

function testJ(): void
{
    echo "testJ";
    // return 1;
}
var_dump(testJ());

```

这时，如果尝试进行任何的return返回，都会直接报错：Fatal error: A void function must not return a value。

&nbsp;
> 总结

我们可以看到，PHP在不断的发展中一直在吸取其他语言中的优秀特性。很明显，添加这些类型声明的目的就是为了将来的编译器做准备的。这也是PHP8的一个重要特性，让我们拭目以待吧！

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E6%96%B9%E6%B3%95%E7%9A%84%E8%BF%94%E5%9B%9E%E5%80%BC.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E6%96%B9%E6%B3%95%E7%9A%84%E8%BF%94%E5%9B%9E%E5%80%BC.php)

参考文档：
[https://www.php.net/manual/zh/functions.returning-values.php][https://www.php.net/manual/zh/functions.returning-values.php]
