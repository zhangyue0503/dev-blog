#PHP匿名类的用法

在PHP7之后，PHP中加入了匿名类的特性。匿名类和匿名方法让PHP成为了更现代化的语言，也让我们的代码开发工作越来越方便。我们先来看看匿名类的简单使用。

```php
// 直接定义
$objA = new class

{
    public function getName()
    {
        echo "I'm objA";
    }
};
$objA->getName();

// 方法中返回
function testA()
{
    return new class

    {
        public function getName()
        {
            echo "I'm testA's obj";
        }
    };
}

$objB = testA();
$objB->getName();

// 作为参数
function testB($testBobj)
{
    echo $testBobj->getName();
}
testB(new class{
        public function getName()
    {
            echo "I'm testB's obj";
        }
    });
```

一次性给出了三种匿名类的使用方法。匿名类可以直接定义给变量，可以在方法中使用return返回，也可以当做参数传递给方法内部。其实，匿名类就像一个没有事先定义的类，而在定义的时候直接就进行了实例化。

```php
// 继承、接口、访问控制等
class A
{
    public $propA = 'A';
    public function getProp()
    {
        echo $this->propA;
    }
}
trait B
{
    public function getName()
    {
        echo 'trait B';
    }
}
interface C
{
    public function show();
}
$p4 = 'b4';
$objC = new class($p4) extends A implements C
{
    use B;
    private $prop1 = 'b1';
    protected $prop2 = 'b2';
    public $prop3 = 'b3';

    public function __construct($prop4)
    {
        echo $prop4;
    }

    public function getProp()
    {
        parent::getProp();
        echo $this->prop1, '===', $this->prop2, '===', $this->prop3, '===', $this->propA;
        $this->getName();
        $this->show();
    }
    public function show()
    {
        echo 'show';
    }
};

$objC->getProp();
```

匿名类和普通类一样，可以继承其他类，可以实现接口，当然也包括各种访问控制的能力。也就是说，匿名类在使用方面和普通类并没有什么不同。但如果用get_class()获取类名将是系统自动生成的类名。相同的匿名类返回的名称当然也是相同的。

```php
// 匿名类的名称是通过引擎赋予的
var_dump(get_class($objC));

// 声明的同一个匿名类，所创建的对象都是这个类的实例
var_dump(get_class(testA()) == get_class(testA()));
```

那么匿名类中的静态成员呢？当然也和普通类一样，静态成员是属于类而不是实例的。

```php
// 静态变量
function testD()
{
    return new class{
        public static $name;
    };
}
$objD1 = testD();
$objD1::$name = 'objD1';

$objD2 = testD();
$objD2::$name = 'objD2';

echo $objD1::$name;
```

当类中的静态变量修改时，所有类实例的这个静态变量都会跟着变化。这也是普通类静态成员的特性。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E5%8C%BF%E5%90%8D%E7%B1%BB%E7%9A%84%E7%94%A8%E6%B3%95.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E5%8C%BF%E5%90%8D%E7%B1%BB%E7%9A%84%E7%94%A8%E6%B3%95.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.anonymous.php](https://www.php.net/manual/zh/language.oop5.anonymous.php)