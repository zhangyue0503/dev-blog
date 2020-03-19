# 后期静态绑定在PHP中的使用

什么叫后期静态绑定呢？其实我们在之前的文章[PHP中的static](https://mp.weixin.qq.com/s/vJc2lXnIg7GCgPkrTh_xsw)中已经说过这个东西了。今天我们还是再次深入的理解一下这个概念。

首先，我们通过一段代码来引入后期静态绑定这一概念：

```php
class A
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        self::who();
    }
}

class B extends A
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

B::test(); // A
```

在这段代码中，我们使用了self关键字，当使用B类调用test()静态方法时，self指向的是A类的who()方法，因此，输出的是A。别激动，这是普通的静态绑定。self关键字调用的内容取决于它定义时所在的类。也就是说不管怎么继承，用哪个子类来调用test()方法，self关键字都会调用的是A类的who()方法。

而后期静态绑定呢？其实就有点像实例化的类对象，每个实例化的对象，调用的都是自身，而不是父类的属性方法。普通的静态调用可不是这样，但是现实中我们又有这样的需求，就像实例化对象的调用方式一样来调用静态属性方法，这时，我们就可以使用static关键字来实现后期静态绑定。

```php
class C
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        static::who();
    }
}

class D extends C
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

D::test(); // D
```

当使用static关键字后，这里D类调用的test()方法内部调用的who()就是D类自己了。

官方文档中的定义如下：

*当进行静态方法调用时，该类名即为明确指定的那个（通常在 :: 运算符左侧部分）；当进行非静态方法调用时，即为该对象所属的类。*

*该功能从语言内部角度考虑被命名为“后期静态绑定”。“后期绑定”的意思是说，static:: 不再被解析为定义当前方法所在的类，而是在实际运行时计算的。也可以称之为“静态绑定”，因为它可以用于（但不限于）静态方法的调用。*

除了self和static关键字外，我们还有一个parent关键字，这个关键字的意义就很明显了，调用父类的静态内容。我们同时用三个关键字一起来进行测试：

```php
class E
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        self::who();
        static::who();
    }
}

class F extends E
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

class G extends F
{
    public static function who()
    {
        parent::who();
        echo __CLASS__, PHP_EOL;
    }
}

G::test();

// E
// F
// G
```

最后，我们再来看两个PHP的方法，一个是get_called_class()方法，用来获取当前调用的是哪个类。在静态方法中可以根据调用方式判断当前类是哪个类来进行其他的业务逻辑操作。另一个是forward_static_call()方法，用于静态方法的调用。

```php
class H
{
    public static function who()
    {
        echo __CLASS__ . ':' . join(',', func_get_args()), PHP_EOL;
    }
    public static function test()
    {
        echo get_called_class(), PHP_EOL;
        forward_static_call('who', 'a', 'b'); // xxx:a,b
        forward_static_call(['I', 'who'], 'c', 'd'); // I:c,d
        forward_static_call_array(['H', 'who'], ['e', 'f']); // H:e,f
    }
}

class I extends H
{
    public static function who()
    {
        echo __CLASS__ . ':' . join(',', func_get_args()), PHP_EOL;
    }
}

function who()
{
    echo 'xxx:' . join(',', func_get_args()), PHP_EOL;
}

H::test(); // H
// xxx:a,b
// I:c,d
// H:e,f
I::test(); // I
// xxx:a,b
// I:c,d
// H:e,f
```

注意，如果forward_static_call()不指定类名的话，将调用全局的方法。forward_static_call_array()则是将参数使用数组进行传递。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/%E5%90%8E%E6%9C%9F%E9%9D%99%E6%80%81%E7%BB%91%E5%AE%9A%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/%E5%90%8E%E6%9C%9F%E9%9D%99%E6%80%81%E7%BB%91%E5%AE%9A%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.late-static-bindings.php](https://www.php.net/manual/zh/language.oop5.late-static-bindings.php)
[https://www.php.net/manual/zh/function.get-called-class.php](https://www.php.net/manual/zh/function.get-called-class.php)
[https://www.php.net/manual/zh/function.forward-static-call.php](https://www.php.net/manual/zh/function.forward-static-call.php)