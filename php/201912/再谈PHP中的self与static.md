# 再谈PHP中的self与static

之前的文章中有介绍过self、static和parent的传递问题。今天，通过一个小实验，我们来看看self和static操作变量的问题。

```php
class A
{
    public static $name = "I'm A!";

    public function selfName()
    {
        echo self::$name;
    }

    public function staticName()
    {
        echo static::$name;
    }
}

class B extends A{
    public static $name = "I'm B!";
}

$b = new B();
$b->selfName(); // I'm A!
$b->staticName(); // I'm B!

class C extends A{
    public static $name = "I'm C!";

    public function selfName()
    {
        echo self::$name;
    }
}

$c = new C();
$c->selfName(); // I'm C!
$c->staticName(); // I'm C!
```

通过这个简单的例子，我们可以看出两点：

1. self写在哪个类里面，它固定指向的就是当前的这个类
2. static就是哪个对象调用它，它指向的就是这个调用者

从代码中我们可以看出，B类没有重写selfName()方法，所以B类调用selfName()时调用的是父类A的selfName()方法，self在这个方法中指向的是A类。而C类重写了父类的selfName()方法，在调用C类的selfName()时，这里面的self指向的便是C类自己了。

static就比较简单了，例子中都是由B类和C类来调用的A类的staticName()方法，根据谁调用就指向谁来看，输出的结果符合我们的预期，B类对象指向的是B类，C类对象指向的是C类。

我们也可以转而理解为self是个常量，写在哪里就不会变了，它就是指明当前这个类。而static是个变量，哪个类用到它了它就被赋值成调用它的这个类。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E5%86%8D%E8%B0%88PHP%E4%B8%AD%E7%9A%84self%E4%B8%8Estatic.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/%E5%86%8D%E8%B0%88PHP%E4%B8%AD%E7%9A%84self%E4%B8%8Estatic.php)

参考文档：
[https://www.cnblogs.com/mr-amazing/p/5953227.html](https://www.cnblogs.com/mr-amazing/p/5953227.html)
[https://www.php.net/manual/zh/language.oop5.constants.php](https://www.php.net/manual/zh/language.oop5.constants.php)
