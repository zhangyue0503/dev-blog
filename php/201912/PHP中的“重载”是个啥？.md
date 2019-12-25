# PHP中的“重载”是个啥？

很多面试官在面试的时候都会问一些面向对象的问题，面向对象的三大特性中，多态最主要的实现方式就是方法的重载和重写。但是在PHP中，只有重写，并没有完全的重载能力的实现。

重写，子类重写父类方法。

```php
// 重写
class A
{
    public function test($a)
    {
        echo 'This is A：' . $a, PHP_EOL;
    }
}

class childA extends A
{
    public function test($a)
    {
        echo 'This is A child：' . $a, PHP_EOL;
    }
}

$ca = new childA();
$ca->test(1);
```

这个在PHP中是没有任何问题的，子类可以重写父类的方法。当实例化子类的时候，调用的就是子类实现的重写的方法。

重载，相同方法名但参数数量或者类型不同。

```php
class A{
    function foo($a){
        echo $a;
    }
    // Fatal error: Cannot redeclare A::foo()
    function foo($a, $b){
        echo $a+$b;
    }
}
```

抱歉，这样写的结果将会是直接的报错。PHP并不支持这样的重载能力。而在PHP的官方手册上，重载的定义是使用__set()、__get()、__call()、__callStatic()等魔术方法来对无法访问的变量或方法进行重载。这与我们所学习的面向对象中的重载完全不同，在手册中的note里也有很多人对此提出了疑问。当然，我们今天并不会再去讲这些魔术方法的使用。关于它们的使用可以参考我们之前写过的文章：[PHP中的那些魔术方法（一）](https://mp.weixin.qq.com/s/QXCH0ZttxhuEBLQWrjB2_A)、[PHP的那些魔术方法（二）](https://mp.weixin.qq.com/s/8WgQ3eVYKjGaEd2CwnB0Ww)

那么，在PHP中可以实现重载吗？当然可以，只不过会麻烦一些：

```php
// 重载
class B
{
    public function foo(...$args)
    {
        if (count($args) == 2) {
            $this->fooAdd(...$args);
        } else if (count($args) == 1) {
            echo $args[0], PHP_EOL;
        } else {
            echo 'other';
        }
    }

    private function fooAdd($a, $b)
    {
        echo $a + $b, PHP_EOL;
    }
}

$b = new B();
$b->foo(1);
$b->foo(1, 2);
```

使用一个方法来调用其他方法，根据参数数量来进行判断，就可以实现参数数量不同的方法重载。

```php
// 使用__call()进行重载
class C
{
    public function __call($name, $args)
    {
        if ($name == 'foo') {
            $funcIndex = count($args);
            if (method_exists($this, 'foo' . $funcIndex)) {
                return $this->{'foo' . $funcIndex}(...$args);
            }
        }
    }

    private function foo1($a)
    {
        echo $a, PHP_EOL;
    }

    private function foo2($a, $b)
    {
        echo $a + $b, PHP_EOL;
    }

    private function foo3($a, $b, $c)
    {
        echo $a + $b + $c, PHP_EOL;
    }

}

$c = new C();
$c->foo(1);
$c->foo(1, 2);
$c->foo(1, 2, 3);
```

使用__call()魔术方法或许会更简单，但也会让一些新手在接手项目的时候蒙圈。毕竟魔术方法对IDE是不友好的，这样的开发让__call()成为了一个模板方法，由它来定义操作的算法骨架。我们也可以根据参数类型来模拟重载能力。

```php
// 参数类型不同的重载
class D {
    function __call($name, $args){
        if($name == 'foo'){
            if(is_string($args[0])){
                $this->fooString($args[0]);
            }else {
                $this->fooInt($args[0]);
            }
        }
    }
    private function fooInt(int $a){
        echo $a . ' is Int', PHP_EOL;
    }

    private function fooString(string $a){
        echo $a . ' is String', PHP_EOL;
    }
}

$d = new D();
$d->foo(1);
$d->foo('1');
```

不管怎么说，用上述方法实现的方法重载都非常麻烦，因为会让某一个方法或者魔术方法非常重，它需要成为一个控制器来根据参数对内部的方法进行调度。更多的情况下，我们应该还是使用不同的方法名然后抽象公共的部分提取成独立的私有内部方法来实现不同方法名的“重载”。毕竟不同的语言还是要掌握它们不同的个性，并且根据这些个性灵活地运用在我们的项目中。

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/language.oop5.overloading.php#77843](https://www.php.net/manual/zh/language.oop5.overloading.php#77843)
