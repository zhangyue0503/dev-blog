# 还不知道PHP有闭包？那你真OUT了

做过一段时间的Web开发，我们都知道或者了解JavaScript中有个非常强大的语法，那就是闭包。其实，在PHP中也早就有了闭包函数的功能。早在5.3版本的PHP中，闭包函数就已经出现了。到了7以及后来的现代框架中，闭包函数的使用更是无处不在。在这里，我们就先从基础来了解PHP中闭包的使用吧！

闭包函数（closures）在PHP中都会转换为 Closure 类的实例。在定义时如果是赋值给变量，在结尾的花括号需要添加;分号。闭包函数从父作用域中继承变量，任何此类变量都应该用 use 语言结构传递进去。 PHP 7.1 起，不能传入此类变量：superglobals、 $this 或者和参数重名。

> 基础语法

闭包的使用非常简单，和JavaScript也非常相似。因为他们都有另外一个别名，叫做匿名函数。

```php

$a = function () {
    echo "this is testA";
};
$a(); // this is testA

$b = function ($name) {
    echo 'this is ' . $name;
};

$b('Bob'); // this is Bob

```

我们将$a和$b两个变量直接赋值为两个函数。这样我们就可以使用变量()的形式调用这两个函数了。

```php

$age = 16;
$c = function ($name) {
    echo 'this is ' . $name . ', Age is ' . $age;
};

$c('Charles'); // this is Charles, Age is

$c = function ($name) use ($age) {
    echo 'this is ' . $name . ', Age is ' . $age;
};

$c('Charles'); // this is Charles, Age is 16

```

如果我们需要调用外部的变量，需要使用use关键字来引用外部的变量。这一点和普通函数不一样，因为闭包有着严格的作用域问题。对于全局变量来说，我们可以使用use，也可以使用global。但是对于局部变量（函数中的变量）时，只能使用use。这一点我们后面再说。

```php

function testD(){
    global $testOutVar;
    echo $testOutVar;
}
$d = function () use ($testOutVar) {
    echo $testOutVar;
};
$dd = function () {
    global $testOutVar;
    echo $testOutVar;
};
$testOutVar = 'this is d';
$d(); // NULL
testD(); // this is d
$dd(); // this is d

$testOutVar = 'this is e';
$e = function () use ($testOutVar) {
    echo $testOutVar;
};
$e(); // this is e

$testOutVar = 'this is ee';
$e(); // this is e

$testOutVar = 'this is f';
$f = function () use (&$testOutVar) {
    echo $testOutVar;
};
$f(); // this is f

$testOutVar = 'this is ff';
$f(); // this is ff

```

在作用域中，use传递的变量必须是在函数定义前定义好的，从上述例子中可以看出。如果闭包（$d）是在变量（$testOutVar）之前定义的，那么$d中use传递进来的变量是空的。同样，我们使用global来测试，不管是普通函数（testD()）或者是闭包函数（$dd），都是可以正常使用$testOutVar的。

在$e函数中的变量，在函数定义之后进行修改也不会对$e闭包内的变量产生影响。这时候，必须要使用引用传递（$f）进行修改才可以让闭包里面的变量产生变化。这里和普通函数的引用传递与值传递的概念是相同的。

除了变量的use问题，其他方面闭包函数和普通函数基本没什么区别，比如进行类的实例化：

```php

class G
{}
$g = function () {
    global $age;
    echo $age; // 16
    $gClass = new G();
    var_dump($gClass); // G info
};
$g();

```

> 作用域

关于全局作用域，闭包函数和普通函数的区别不大，主要的区别体现在use作为桥梁进行变量传递时的状态。在类方法中，有没有什么不一样的地方呢？

```php

$age = 18;
class A
{
    private $name = 'A Class';
    public function testA()
    {
        $insName = 'test A function';
        $instrinsic = function () {
            var_dump($this); // this info
            echo $this->name; // A Class
            echo $age; // NULL
            echo $insName; // null
        };
        $instrinsic();

        $instrinsic1 = function () {
            global $age, $insName;
            echo $age; // 18
            echo $insName; // NULL
        };
        $instrinsic1();

        global $age;
        $instrinsic2 = function () use ($age, $insName) {
            echo $age; // 18
            echo $insName; // test A function
        };
        $instrinsic2();

    }
}

$aClass = new A();
$aClass->testA();

```

- A::testA()方法中的$insName变量，我们只能通过use来拿到。
- 闭包函数中的$this是调用它的环境的上下文，在这里就是A类本身。闭包的父作用域是定义该闭包的函数（不一定是调用它的函数）。静态闭包函数无法获得$this。
- 全局变量依然可以使用global获得。

> 小技巧

了解了闭包的这些特性后，我们可以来看几个小技巧：

```php

$arr1 = [
    ['name' => 'Asia'],
    ['name' => 'Europe'],
    ['name' => 'America'],
];

$arr1Params = ' is good!';
// foreach($arr1 as $k=>$a){
//     $arr1[$k] = $a . $arr1Params;
// }
// print_r($arr1);

array_walk($arr1, function (&$v) use ($arr1Params) {
    $v .= ' is good!';
});
print_r($arr1);

```

干掉foreach：很多数组类函数，比如array_map、array_walk等，都需要使用闭包函数来处理。上例中我们就是使用array_walk来对数组中的内容进行处理。是不是很有函数式编程的感觉，而且非常清晰明了。

```php

function testH()
{
    return function ($name) {
        echo "this is " . $name;
    };
}
testH()("testH's closure!"); // this is testH's closure!

```

看到这样的代码也不要懵圈了。PHP7支持立即执行语法，也就是JavaScript中的IIFE(Immediately-invoked function expression)。

我们再来一个计算斐波那契数列的：

```php

$fib = function ($n) use (&$fib) {
    if ($n == 0 || $n == 1) {
        return 1;
    }

    return $fib($n - 1) + $fib($n - 2);
};

echo $fib(10);

```

同样的还是使用递归来实现。这里直接换成了闭包递归来实现。最后有一点要注意的是，use中传递的变量名不能是带下标的数组项：

```php

$fruits = ['apples', 'oranges'];
$example = function () use ($fruits[0]) { // Parse error: syntax error, unexpected '[', expecting ',' or ')'
    echo $fruits[0]; 
};
$example();

```

这样写直接就是语法错误，无法成功运行的。

> 彩蛋

Laravel中的IoC服务容器中，大量使用了闭包能力，我们模拟一个便于大家理解。当然，更好的方案是自己去翻翻Laravel的源码。

```php
class B
{}
class C
{}
class D
{}
class Ioc
{
    public $objs = [];
    public $containers = [];

    public function __construct()
    {
        $this->objs['b'] = function () {
            return new B();
        };
        $this->objs['c'] = function () {
            return new C();
        };
        $this->objs['d'] = function () {
            return new D();
        };
    }
    public function bind($name)
    {
        if (!isset($this->containers[$name])) {
            if (isset($this->objs[$name])) {
                $this->containers[$name] = $this->objs[$name]();
            } else {
                return null;
            }
        }
        return $this->containers[$name];
    }
}

$ioc = new Ioc();
$bClass = $ioc->bind('b');
$cClass = $ioc->bind('c');
$dClass = $ioc->bind('d');
$eClass = $ioc->bind('e');

var_dump($bClass); // B
var_dump($cClass); // C
var_dump($dClass); // D
var_dump($eClass); // NULL
```

> 总结

闭包特性经常出现的地方是事件回调类的功能中，另外就是像彩蛋中的IoC的实现。因为闭包有一个很强大的能力就是可以延迟加载。IoC的例子便是我们的闭包中返回的是新new出来的对象。当我们的程序运行的时候，如果没有调用$ioc->bind('b')，那么这个B对象是不会创建的，也就是说这时它还不会占用资源占用内存。而当我们需要的时候，从服务容器中拿出来的时候才利用闭包真正的去创建对象。同理，事件的回调也是一样的概念。事件发生时在我们需要处理的时候才去执行回调里面的代码。如果没有闭包的概念，那么$objs容器就这么写了：

```php

$this->objs['b'] = new B();
$this->objs['c'] = new C();
$this->objs['d'] = new D();

```

容器在实例化的时候就把所有的类都必须实例化了。这样对于程序来说很多用不上的对象就都被创建了，带来非常大的资源浪费。

基于闭包的这种强大能力，现在闭包函数已经在Laravel、TP6等框架中无处不在了。学习无止尽，掌握原理再去学习框架往往更能事半功倍。

测试代码：

参考文档：
[https://www.php.net/manual/zh/functions.anonymous.php](https://www.php.net/manual/zh/functions.anonymous.php)
[https://www.php.net/manual/zh/functions.anonymous.php#100545](https://www.php.net/manual/zh/functions.anonymous.php#100545)
[https://www.php.net/manual/zh/functions.anonymous.php#119388](https://www.php.net/manual/zh/functions.anonymous.php#119388)