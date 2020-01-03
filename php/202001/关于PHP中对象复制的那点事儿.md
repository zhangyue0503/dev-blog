# 关于PHP中对象复制的那点事儿

我们已经在[PHP设计模式之原型模式](https://mp.weixin.qq.com/s/KO4TuT2t5Xh_3BG3UrfN1w)中讨论过关于PHP中对象复制的问题，这次就当做是一次复习。

原型模式可以看作是对象复制中的一个重要内容。在学习原型模式时，我们了解到对象中的引用变量，也就是变量也是一个对象时，直接复制这个对象会导致其中的引用变量还是指向同一个对象。是不是有点绕，我们还是用例子来说明：

```php
// clone方法
class testA{
    public $testValue;
}
class A
{
    public static $reference = 0;
    public $instanceReference = 0;
    public $t;

    public function __construct()
    {
        $this->instanceReference = ++self::$reference;
        $this->t = new testA();

    }

    public function __clone()
    {
        $this->instanceReference = ++self::$reference;
        $this->t = new testA();
    }
}

$a1 = new A();
$a2 = new A();
$a11 = clone $a1;
$a22 = $a2;

var_dump($a11); // $instanceReference, 3
var_dump($a22); // $instanceReference, 2

$a1->t->testValue = '现在是a1';
echo $a11->t->testValue, PHP_EOL; // ''


$a2->t->testValue = '现在是a2';
echo $a22->t->testValue, PHP_EOL; // 现在是a2
$a22->t->testValue = '现在是a22';
echo $a2->t->testValue, PHP_EOL; // 现在是a22

// 使用clone后
$a22 = clone $a2;
var_dump($a22); // $instanceReference, 4

$a2->t->testValue = '现在是a2';
echo $a22->t->testValue, PHP_EOL; // NULL
$a22->t->testValue = '现在是a22';
echo $a2->t->testValue, PHP_EOL; // 现在是a2
```

首先，通过变量的变化，我们可以看出使用clone关键字的对象复制会调用__clone()方法。这个魔术方法正在原型模式的核心所在。在这个方法中，我们可以重新实例化或者定义对象中的引用成员。通过clone，我们让$t变量重新实例化，从而让$t成为了新的对象，从而避免引用带来的问题。

在对象的复制中，我们需要特别注意的递归引用的问题。也就是对象内部引用了自身，将会导致来回的重复引用形成递归死循环。

```php
// 循环引用问题
class B
{
    public $that;

    function __clone()
    {
        // Segmentation fault: 11
        $this->that = clone $this->that;
        // $this->that = unserialize(serialize($this->that));
        // object(B)#6 (1) {
        //     ["that"]=>
        //     object(B)#7 (1) {
        //       ["that"]=>
        //       object(B)#8 (1) {
        //         ["that"]=>
        //         *RECURSION*  无限递归
        //       }
        //     }
        //   }
    }
}

$b1 = new B();
$b2 = new B();
$b1->that = $b2;
$b2->that = $b1;

$b3 = clone $b1;

var_dump($b3);
```

B类中的that指向自身的实例，两个对象相互指向后再进行复制，就会出现这种死循环的情况。使用序列化和反序列化输出后，我们会看到*RECURSION*的引用提示。这就是形成了递归的死循环。这种情况一定要极力避免。

上述例子中，我们使用了序列化和反序列化这一招来解决引用问题。对象复制的对象变量来说（对象变量里面还有更多层次的引用变量），这种方式能够一次性地在最顶层的对象__clone()方法中解决引用问题。

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/language.oop5.cloning.php](https://www.php.net/manual/zh/language.oop5.cloning.php)
