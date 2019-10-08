上文中介绍了非常常用并且也是面试时的热门魔术方法，而这篇文章中的所介绍的或许并不是那么常用，但绝对是加分项。当你能准确地说出这些方法及作用的时候，相信对方更能对你刮目相看。

> __sleep()与__wakeup()

字面上的意思很好玩，睡觉和起床。它们分别对应着serialize()和unserialize()方法，也就是序列化和反序列化时会触发这两个魔术方法。

这里需要注意的是，__sleep()需要返回一个数组，而这个数组对应着类中的属性名。通常来说，它们可以在序列化前进行数据清理工作，或者反序列化前进行数据的预处理工作。比如序列化前关闭数据库连接或者反序列化前打开数据库连接。

```php
public function __sleep()
{
    echo '===sleep===' . PHP_EOL;
    echo '调用serialize()时来找我，先睡一会的' . PHP_EOL;
    echo '===unset===' . PHP_EOL;
    return ['a'];
}

public function __wakeup()
{
    echo '===wakeup===' . PHP_EOL;
    echo '调用unserialize()时来找我，起床吧' . PHP_EOL;
    echo '===wakeup===' . PHP_EOL;
}
```

> __toString()

顾名思义，这个方法通过返回一个字符串，实现对象的打印。如果没有实现这个方法，我们直接使用echo是无法打印对象的，会报错。当实现了这个魔术方法后，直接使用echo或者print等方法就可以进入这个魔术方法中，并打印出该方法中返回的内容。

```php
public function __toString()
{
    echo '===toString===' . PHP_EOL;
    echo '调用echo、print时会使用我' . PHP_EOL;
    echo '===toString===' . PHP_EOL;
    return '打印出来看看吧';
}
```

当然，它也能实现对象转换到字符串，如在字符串拼接的时候，如：$obj = new Object(); $a = 'this is ' . $obj;这样使用。

> __invoke()

很有意思的一个魔术方法，它的作用是将对象当做方法使用时会调用这个魔术方法。什么意思呢？比如：$obj = new Object();，然后直接$obj();

这时，就会进入这个魔术方法。那么有什么用呢？对于***闭包***以及***反射***来说，这个魔术方法有不可替代的作用。将来我们会在别的文章中进行详细说明。

```php
public function __invoke()
{
    echo '===invoke===' . PHP_EOL;
    echo '把类当方法使用时就进这里了' . PHP_EOL;
    echo '===invoke===' . PHP_EOL;
}
```

> __clone()

使用clone关键字进行对象的复制时，就会调用这个魔术方法。其实就是***原型模式***的实现。在原型模式的相关文章中我们再来详细说明。

```php
public function __clone()
{
    echo '===clone===' . PHP_EOL;
    echo '复制类的时候我就发挥作用了' . PHP_EOL;
    echo '===clone===' . PHP_EOL;
}
```

> __set_state()与__debugInfo()

真的是神奇的PHP语法，最后这两个魔术方法一个是用的下划线命名，一个是用的小驼峰。实在无力吐槽~~

这两个方法对应的是var_export()和var_dump()方法在使用时的调用。一般是在调试时使用，其实非常类似于__toString()方法。

```php
public static function __set_state($an_array)
{
    echo '===set_state===' . PHP_EOL;
    echo '使用var_export()的时候使用调用我哦' . PHP_EOL;
    echo '===set_state===' . PHP_EOL;
    $m = new PHPMagic();
    $m->var1 = 111;
    $m->var2 = 222;
    return $m;
}

public function __debugInfo()
{
    echo '===debugInfo===' . PHP_EOL;
    echo '使用var_dump()的时候就是我来啦' . PHP_EOL;
    echo '===debugInfo===' . PHP_EOL;
    return [
        'var1' => $this->var1,
        'var2' => $this->var2,
    ];
}
```

通过两篇文章，我们熟悉了PHP所定义的这些魔术方法。在这里需要特别注意的是，PHP中将所有以__两个下划线开头的方法做为魔术方法的保留命名。所以在定义类方法的时候，不要使用两个下划线开头的方法名。

文档参考：[https://www.php.net/manual/zh/language.oop5.magic.php](https://www.php.net/manual/zh/language.oop5.magic.php)

完整代码：[https://github.com/zhangyue0503/php/blob/master/newblog/PHPMagic.php](https://github.com/zhangyue0503/php/blob/master/newblog/PHPMagic.php)