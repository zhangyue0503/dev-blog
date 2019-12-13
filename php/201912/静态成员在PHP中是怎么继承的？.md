# 静态成员在PHP中是怎么继承的？

静态成员，也就是用static修饰的变量或者方法，如果搞不清楚它们实现的原理，就很容易会出现一些错误。这次我们来研究的是在继承中静态成员的调用情况。首先来看这样一段代码：

```php
class A
{
    static $a = 'This is A!';

    public function show()
    {
        echo self::$a, PHP_EOL;
        echo static::$a, PHP_EOL;
    }
}

class B extends A
{
    static $a = 'This is B!';

}

$b = new B;
$b->show();
```

之前的文章中，我们有说过self的问题。self仅仅只是指向当前这个类。注意，是类，不是实例化后的对象。所以上面的输出结果是：

```php
This is A!
This is B!
```

好了，有了这个基础之后，我们知道静态成员是和类有关的，和对象无关。那么以下的代码也就更容易理解了。

```php
class C
{
    static $c = 1;
    public $d = 1;
}
class D extends C
{
    public function add()
    {
        self::$c++;
        $this->d++;
    }
}

$d1 = new D();
$d2 = new D();

$d1->add();
echo 'c：' . D::$c . ',d：' . $d1->d . ';', PHP_EOL;

$d2->add();
echo 'c：' . D::$c . ',d：' . $d2->d . ';', PHP_EOL;
```

直接读代码能推导出输出的结果吗？其实只要掌握了上文中所说的原则，这段代码就很容易理解了。$c是静态变量，$d是普通变量。通过类实例的add()方法进行操作后，$c因为是和类有关，所以不管是哪个实例对象，操作它之后都会是共享的。而$d作为普通变量，它的作用域仅限制在当前这个实例对象中。因此，输出的结果是：

```php
c：2,d：2;
c：3,d：2;
```

最后，我们还是来复习一次self、parent和static关键字。

```php
class E {
    public static function test(){
        echo "This is E test!";
    }
}

class F extends E{
    public static function t(){
        self::test();
        parent::test();
        static::test();
    }

    public static function test(){
        echo "This is F test!";
    }
}

F::t();
```

t()输出的三个结果是什么呢？详情可以查看之前的文章[PHP中的Static](https://mp.weixin.qq.com/s/vJc2lXnIg7GCgPkrTh_xsw)

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E9%9D%99%E6%80%81%E6%88%90%E5%91%98%E5%9C%A8PHP%E4%B8%AD%E6%98%AF%E6%80%8E%E4%B9%88%E7%BB%A7%E6%89%BF%E7%9A%84%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E9%9D%99%E6%80%81%E6%88%90%E5%91%98%E5%9C%A8PHP%E4%B8%AD%E6%98%AF%E6%80%8E%E4%B9%88%E7%BB%A7%E6%89%BF%E7%9A%84%EF%BC%9F.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.static.php](https://www.php.net/manual/zh/language.oop5.static.php)