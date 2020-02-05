# 构造函数以及析构函数在PHP中需要注意的地方

基本上所有的编程语言在类中都会有构造函数和析构函数的概念。构造函数是在函数实例创建时可以用来做一些初始化的工作，而析构函数则可以在实例销毁前做一些清理工作。相对来说，构造函数我们使用得非常多，而析构函数则一般会用在释放资源上，比如数据库链接、文件读写的句柄等。

### **构造函数与析构函数的使用**

我们先来看看正常的构造与析构函数的使用：

```php
class A
{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
        echo "A：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        echo "A：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

$a = new A('$a');
echo '-----', PHP_EOL;

class B extends A
{
    public function __construct($name)
    {
        $this->name = $name;
        parent::__construct($name);
        echo "B：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        parent::__destruct();
        echo "B：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

class C extends A
{
    public function __construct($name)
    {
        $this->name = $name;
        echo "C：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        echo "C：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

class D extends A
{

}
// unset($a); // $a的析构提前
// $a = null; // $a的析构提前
$b = new B('$b');

$c = new C('$c');

$d = new D('$d');

echo '-----', PHP_EOL;exit;

// A：构造函数被调用，$a
// -----
// A：构造函数被调用，$b
// B：构造函数被调用，$b
// C：构造函数被调用，$c
// A：构造函数被调用，$d
// -----
// A：析构函数被调用，$d
// C：析构函数被调用，$c
// A：析构函数被调用，$b
// B：析构函数被调用，$b
// A：析构函数被调用，$a
```

上面的代码是不是有一些内容和我们的预期不太一样？没事，我们一个一个来看：

- 子类如果重写了父类的构造或析构函数，如果不显式地使用parent::__constuct()调用父类的构造函数，那么父类的构造函数不会执行，如C类
- 子类如果没有重写构造或析构函数，则默认调用父类的
- 析构函数如果没显式地将变量置为NULL或者使用unset()的话，会在脚本执行完成后进行调用，调用顺序在测试代码中是类似于栈的形式先进后出（C->B->A，C先被析构），但在服务器环境中则不一定，也就是说顺序不一定固定

### **析构函数的引用问题**

当对象中包含自身相互的引用时，想要通过设置为NULL或者unset()来调用析构函数可能会出现问题。

```php
class E
{
    public $name;
    public $obj;
    public function __destruct()
    {
        echo "E：析构函数被调用，" . $this->name, PHP_EOL;
        echo '-----', PHP_EOL;
    }
}

$e1 = new E();
$e1->name = 'e1';
$e2 = new E();
$e2->name = 'e2';

$e1->obj = $e2;
$e2->obj = $e1;
```

类似于这样的代码，$e1和$e2都是E类的对象，他们又各自持有对方的引用。其实简单点来说的话，自己持有自己的引用都会出现类似的问题。

```php
$e1 = new E();
$e1->name = 'e1';
$e2 = new E();
$e2->name = 'e2';

$e1->obj = $e2;
$e2->obj = $e1;
$e1 = null;
$e2 = null;
// gc_collect_cycles();

$e3 = new E();
$e3->name = 'e3';
$e4 = new E();
$e4->name = 'e4';

$e3->obj = $e4;
$e4->obj = $e3;
$e3 = null;
$e4 = null;

echo 'E destory', PHP_EOL;
```

如果我们不打开gc_collect_cycles()那一行的注释，析构函数执行的顺序是这样的：

```php
// 不使用gc回收的结果
// E destory
// E：析构函数被调用，e1
// -----
// E：析构函数被调用，e2
// -----
// E：析构函数被调用，e3
// -----
// E：析构函数被调用，e4
// -----
```

如果我们打开了gc_collect_cycles()的注释，析构函数的执行顺序是：

```php
// 使用gc回收后结果
// E：析构函数被调用，e1
// -----
// E：析构函数被调用，e2
// -----
// E destory
// E：析构函数被调用，e3
// -----
// E：析构函数被调用，e4
// -----
```

可以看出，必须要让php使用gc回收一次，确定对象的引用都被释放了之后，类的析构函数才会被执行。引用如果没有释放，析构函数是不会执行的。

### **构造函数的低版本兼容问题**

在PHP5以前，PHP的构造函数是与类名同名的一个方法。也就是说如果我有一个F类，那么function F(){}方法就是它的构造函数。为了向低版本兼容，PHP依然保留了这个特性，在PHP7以后如果有与类名同名的方法，就会报过时警告，但不会影响程序执行。

```php
class F
{
    public function f() 
    {
        // Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP; F has a deprecated constructor 
        echo "F：这也是构造函数，与类同名，不区分大小写", PHP_EOL;
    }
    // function F(){
    //     // Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP; F has a deprecated constructor 
    //     echo "F：这也是构造函数，与类同名", PHP_EOL;
    // }
    // function __construct(){
    //     echo "F：这是构造函数，__construct()", PHP_EOL;
    // }
}
$f = new F();
```

如果__construc()和类同名方法同时存在的话，会优先走__construct()。另外需要注意的是，**函数名不区分大小写**，所以F()和f()方法是一样的都会成为构造函数。同理，因为不区分大小写，所以f()和F()是不能同时存在的。当然，我们都不建议使用类同名的函数来做为构造函数，毕竟已经是过时的特性了，说不定哪天就被取消了。

### **构造函数重载**

PHP是不运行方法的重载的，只支持重写，就是子类重写父类方法，但不能定义多个同名方法而参数不同。在Java等语言中，重载方法非常方便，特别是在类实例化时，可以方便地实现多态能力。

```php
$r1 = new R(); // 默认构造函数
$r2 = new R('arg1'); // 默认构造函数 一个参数的构造函数重载，arg1
$r3 = new R('arg1', 'arg2'); // 默认构造函数 两个参数的构造函数重载，arg1，arg2
```

就像上述代码一样，如果你尝试定义多个__construct()，PHP会很直接地告诉你运行不了。那么有没有别的方法实现上述代码的功能呢？当然有，否则咱也不会写了。

```php
class R
{
    private $a;
    private $b;
    public function __construct()
    {
        echo '默认构造函数', PHP_EOL;
        $argNums = func_num_args();
        $args = func_get_args();
        if ($argNums == 1) {
            $this->constructA(...$args);
        } elseif ($argNums == 2) {
            $this->constructB(...$args);
        }
    }
    public function constructA($a)
    {
        echo '一个参数的构造函数重载，' . $a, PHP_EOL;
        $this->a = $a;
    }
    public function constructB($a, $b)
    {
        echo '两个参数的构造函数重载，' . $a . '，' . $b, PHP_EOL;
        $this->a = $a;
        $this->b = $b;
    }
}
$r1 = new R(); // 默认构造函数
$r2 = new R('arg1'); // 默认构造函数 一个参数的构造函数重载，arg1
$r3 = new R('arg1', 'arg2'); // 默认构造函数 两个参数的构造函数重载，arg1，arg2
```

相对来说比Java之类的语言要麻烦一些，但是也确实是实现了相同的功能哦。

### **构造函数和析构函数的访问限制**

构造函数和析构函数默认都是public的，和类中的其他方法默认值一样。当然它们也可以设置成private和protected。如果将构造函数设置成非公共的，那么你将无法实例化这个类。这一点在单例模式被广泛应用，下面我们直接通过一个单例模式的代码看来。

```php
class Singleton
{
    private static $instance;
    public static function getInstance()
    {
        return self::$instance == null ? self::$instance = new Singleton() : self::$instance;
    }

    private function __construct()
    {

    }
}

$s1 = Singleton::getInstance();
$s2 = Singleton::getInstance();
echo $s1 === $s2 ? 's1 === s2' : 's1 !== s2', PHP_EOL;

// $s3 = new Singleton(); // Fatal error: Uncaught Error: Call to private Singleton::__construct() from invalid context
```

当$s3想要实例化时，直接就报错了。关于单例模式为什么要让外部无法实例化的问题，我们可以看看之前的设计模式系统文章中的[单例模式](https://mp.weixin.qq.com/s/xJPF0dJYorbjhDQJMxogpQ)。

### **总结**

没想到我们天天用到的构造函数还能玩出这么多花样来吧，日常在开发中比较需要注意的就是子类继承时对构造函数重写时父类构造函数的调用问题以及引用时的析构问题。

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E6%9E%84%E9%80%A0%E5%87%BD%E6%95%B0%E4%BB%A5%E5%8F%8A%E6%9E%90%E6%9E%84%E5%87%BD%E6%95%B0%E5%9C%A8PHP%E4%B8%AD%E9%9C%80%E8%A6%81%E6%B3%A8%E6%84%8F%E7%9A%84%E5%9C%B0%E6%96%B9.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E6%9E%84%E9%80%A0%E5%87%BD%E6%95%B0%E4%BB%A5%E5%8F%8A%E6%9E%90%E6%9E%84%E5%87%BD%E6%95%B0%E5%9C%A8PHP%E4%B8%AD%E9%9C%80%E8%A6%81%E6%B3%A8%E6%84%8F%E7%9A%84%E5%9C%B0%E6%96%B9.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.decon.php#105368](https://www.php.net/manual/zh/language.oop5.decon.php#105368)
[https://www.php.net/manual/zh/language.oop5.decon.php#76446](https://www.php.net/manual/zh/language.oop5.decon.php#76446)
[https://www.php.net/manual/zh/language.oop5.decon.php#81458](https://www.php.net/manual/zh/language.oop5.decon.php#81458)
[https://www.php.net/manual/zh/language.oop5.decon.php](https://www.php.net/manual/zh/language.oop5.decon.php)