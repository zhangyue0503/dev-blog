


https://www.php.net/manual/zh/language.oop5.traits.php#116907

# trait能力在PHP中的使用

相信大家对trait已经不陌生了，早在5.4时，trait就已经出现在了PHP的新特性中。当然，本身trait也是特性的意思，但这个特性的主要能力就是为了代码的复用。

我们都知道，PHP是现代化的面向对象语言。为了解决C++多重继承的混乱问题，大部分语言都是单继承多接口的形式，但这也会让一些可以复用的代码必须通过组合的方式来实现，如果要用到组合，不可避免的就要实例化类或者使用静态方法，无形中增加了内存的占用。而PHP为了解决这个问题，就正式推出了trait能力。你可以把它看做是组合能力的一种变体。

```php
trait A
{
    public $a = 'A';
    public function testA()
    {
        echo 'This is ' . $this->a;
    }
}

class classA
{
    use A;
}
class classB
{
    use A;
    public function __construct()
    {
        $this->a = 'B';
    }
}

$a = new classA();
$b = new classB();

$a->testA();
$b->testA();
```

从上述代码中，我们可以看出，trait可以给应用于任意一个类中，而且可以定义变量，非常方便。trait最需要注意的是关于同名方法的重载优先级问题。

```php
trait B {
    function test(){
        echo 'This is trait B!';
    }
}
trait C {
    function test(){
        echo 'This is trait C!';
    }
}

class testB{
    use B, C;
    function test(){
        echo 'This is class testB!';
    }
}

$b = new testB();
$b->test(); // This is class testB!
// class testC{
//     use B, C;
// }

// $c = new testC();
// $c->test(); // Fatal error: Trait method test has not been applied, because there are collisions with other trait methods on testC
```

在这里，我们的类中重载了test()方法，这里输出的就是类中的方法了。如果注释掉testB类中的test()方法，则会报错。因为程序无法区分出你要使用的是哪一个trait中的test()方法。我们可以使用insteadof来指定要使用的方法调用哪一个trait。

```php
class testE{
    use B, C {
        B::test insteadOf C;
        C::test as testC;
    }
}
$e = new testE();
$e->test(); // This is trait B!
$e->testC(); // This is trait C!
```

当然，现实开发中还是尽量规范方法名，不要出现这种重复情况。另外，如果子类引用了trait，而父类又定义了同样的方法呢？当然还是调用父类所继承来的方法。trait的优先级是低于普通的类继承的。

```php
trait D{
    function test(){
        echo 'This is trait D!';
    }
}

class parentD{
    function test(){
        echo 'This is class parentD';
    }
}

class testD extends parentD{
    use D;
}

$d = new testD();
$d->test(); // This is trait D!
```

最后，trait中也是可以定义抽象方法的。这个抽象方法是引用这个trait的类所必须实现的方法，和抽象类中的抽象方法效果一致。

```php
trait F{
    function test(){
        echo 'This is trait F!';
    }
    abstract function show();
}

class testF{
    use F;
    function show(){
        echo 'This is class testF!';
    }
}
$f = new testF();
$f->test();
$f->show();
```

trait真的是PHP是非常灵活的一个功能。当然，越是灵活的东西越需要我们去弄明白它的一些使用规则，这样才能避免一些不可预见的错误。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/trait%E8%83%BD%E5%8A%9B%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/trait%E8%83%BD%E5%8A%9B%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.traits.php](https://www.php.net/manual/zh/language.oop5.traits.php)