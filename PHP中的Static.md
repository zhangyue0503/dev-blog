# PHP中的static

关于静态变量和方法的问题也是面试中经常会出现的问题，这种问题多看手册搞明白原委就能解决，只是确实关于静态变量的问题还是比较绕的，这里我们就结合手册用实际的代码来看！

```php

class Test
{
    static $v = 'a';

    static function showV()
    {
        echo self::$v;
    }

    function showVV()
    {
        echo self::$v;
    }

    static function showVVV()
    {
        // $this->showVV(); // 会直接报错
    }
}

```

先准备一个类，这里面有静态变量、静态方法，其中showV()方法是静态方法调用静态变量，showVV()方法是普通方法调用静态变量，showVVV()方法是普通方法调用静态方法。

从注释中可以看出第一个问题，普通方法使用$this调用静态方法会报错，也就是说，$this这个东东对于一切静态的东西都是不友好的，不信您打开注释试试，也可以去调用静态的$v变量，直接就是语法错误的提示。

接下来，我们实例化类，并开始一些测试

```php
$t = new Test();
$t->showV();
//echo $t->v; // 报异常
echo Test::$v;
//Test::showVV(); // 报异常
$t->showVV();
```

- 1行：实例化的类直接调用showV()，这是没问题的，静态方法可以通过普通的方式调用，当然我们正规的应该是使用Test::showV()来进行调用，注意这里面试的时候会是坑
- 2行：正常调用
- 2行：直接->v是不行的，方法可以进行普通调用，但属性不行
- 3行：用静态调用的方式是没问题的
- 4行：正常获取静态变量
- 5行： 使用::当然不能调用非静态方法啦
- 6行：正常方法中可以使用静态变量

那么问题来了，静态方法中不能使用$this，如何获得变量内容呢？请参考单例模式，将来我们会在设计模式的系列文章中讲到，这里先卖个关子，大家也可以自己研究下。

上面是正常来说一些比较简单的静态属性和方法的演示，接下来好玩的东西就来了。

> 初始化特性

```php 
class Calculate
{
    function cacl()
    {
        static $a = 1;
        echo $a;
        $a++;
    }

    static function cacl2()
    {
        static $a = 1;
        echo $a;
        $a++;
    }

    static $b = 1;

    static function cacl3()
    {
        echo self::$b;
        self::$b++;
    }
}

$calculate = new Calculate();
$calculate->cacl(); // 1
$calculate->cacl(); // 2

Calculate::cacl2(); // 1
Calculate::cacl2(); // 2

Calculate::cacl3(); // 1
Calculate::cacl3(); // 2
```

看着代码很多，其实都是在讲一件事儿，如果是普通的$a和$b，那么每次都在重新赋值，echo出来的都是0，但是静态属性可不一样。**静态属性是运行时计算的，只在第一次赋值的时候是真正的赋值操作，而后并不会进行赋值，可以相当于这一行代码不存在。**

**静态变量只在局部的作用域中存在，离开这个作用域也不会丢失，当然也不能再次初始化。**学过前端的同学一定会拍案而起，这不是闭包的作用域嘛？？确实很像，而且用处也非常像，比如我们做一个递归：

```php
function test1()
{
    static $count = 0;

    $count++;
    echo $count;
    if ($count < 10) {
        test();
    }
    $count--;
}

test1();
```

在不了解static之前，结束递归我们可能需要给方法传递一个数字进来，但现在似乎是不需要了，使用内部的静态变量就可以解决了。

> 引用对象问题

```php

class Foo
{
    public $a = 1;
}

function getRefObj($o)
{
    static $obj;
    var_dump($obj);
    if (!isset($obj)) {
        $obj = &$o;
    }
    $obj->a++;
    return $obj;
}

function getNoRefObj($o)
{
    static $obj;
    var_dump($obj);
    if (!isset($obj)) {
        $obj = $o;
    }
    $obj->a++;
    return $obj;
}

$o    = new Foo;
$obj1 = getRefObj($o); // NULL
$obj2 = getRefObj($o); // NULL

$obj3 = getNoRefObj($o); // NULL
$obj4 = getNoRefObj($o); // Foo

```

又是一大串代码，啥也不说，先复制下来运行一下看看结果是不是一样。在使用引用对象时，我们赋值的是内存引用地址。但是同样的原因，静态属性是运行时产生的，而引用地址不是静态地存储，于是，赋不上值了呗，永远会是NULL。不信你接着用getRefObj()再生成几个试试。**实际应用中反正要记住，这种情况下千万不要把引用值赋给静态变量就行了，而上面原因的理解确实还是比较绕的，能讲明白最好，讲不明白就记住这个事儿。**

> 后期静态绑定

```php

class A
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }

    static function test()
    {
        self::who();
    }
}

class B extends A
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }
}

B::test(); // A

```

先看这一段，使用self输出的结果会是A，但如果使用普通的类实例化，并且使用普通方法的话，输出的会是B，大家可以尝试下。原因呢，就是self是**取决于当前定义方法所在的类**。这就是静态属性方法的另一大特点，不实例化，跟随着类而不是实例。

class A{...}，这个东西叫做类，是对现实的抽象，我们可以理解为一个模板，这里面的东西是假的，没有生命的。$a = new A了之后，这个$a才是对象，相当于是复制一了个模板做了一个真的东西出来，是有生命的。就好像我们做一个锤子，需要一个模具，这玩意就是类，然后浇铸金属后成型拿出来，这玩意就是对象。一个对象有真正的内存地址空间的。

非静态的属性和方法是在对象中的，是我们浇进去的金属。也就是new了之后才有的东西，而静态属性和方法是依附于class A的，是运行时进行编译读取的。

现在我们回过头来看最早的例子，普通方法中调用静态方法或变量，实际上就是在这个实例化对象中调用了Test::showV()，只是我们使用了self关键字而已。依然是走的静态过程而不是这个对象中真的包含了showV()这个方法，因此，$this当然取不到啦！

那么，如何让父类A中test()方法去调用到子类的who()方法呢？

```php

class AA
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }

    static function test()
    {
        static::who();
    }
}

class BB extends AA
{
    static function who()
    {
        echo __CLASS__ . "\n";
    }
}

BB::test(); // BB

```

没错，使用static::关键字这种形式调用，static表示**运行最初时的类，不是方法定义时的类**。这样就完成了后期静态绑定。另外，parent::和self::是会转发这个链条的。

```php

class AAA
{
    public static function foo()
    {
        static::who();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

class BBB extends AAA
{
    public static function test()
    {
        AAA::foo();
        parent::foo();
        self::foo();
    }

    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

class CCC extends BBB
{
    public static function who()
    {
        echo __CLASS__ . "\n";
    }
}

CCC::test(); // AAA、CCC、CCC

```

- CCC继承了BBB，BBB继承了AAA
- 在AAA中的foo()方法使用了static::who()来调用who()方法
- BBB中的test()执行了三种调用
- 结果是parent::foo()和self::foo()都将CCC传递了过去，最后使用的是CCC的who()方法

这个例子看着很绕，但其实结论就一个，如果父类使用了static关键字来调用父子类都有的内容，那么就是以哪个子类在外面进行调用了为准，就像普通类的方法调用 一样。反过来，self就是以这个self关键字所在的类为准。

说了这么多，也算是把static静态的特性讲解的差不多了。在实际应用中还是要综合考虑，不能因为静态属性方便就全都使用静态属性和方法或者完全不使用，还是要结合各路业务需求进行取舍。

具体代码：
[https://github.com/zhangyue0503/php/blob/master/newblog/php-static.php](https://github.com/zhangyue0503/php/blob/master/newblog/php-static.php)