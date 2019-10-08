在PHP中，有一堆魔术方法，服务于类和对象。PHP虽然也是纯种的面向对象语言，但是之前的PHP还真不是，所以有一些面向对象的标准实现并不完善，比如***重载***。但是，我们可以通过一些魔术方法来弥补，例如__call()方法就可以用来实现***重载***。

话不多说，我们一个一个的来看。

> __construct()和__destruct()

这两个是非常出名并且也是非常常用的魔术方法。\_\_construct()是构造函数。在Java中，构造函数是与类名相同的方法名，而PHP在早期的版本中也是这样的，但从5以后改成了\_\_construct()方法来实现，原因是当类名进行修改的时候，可以不用再去修改这个方法名了。当然，我们用与类名相同的方法名也是可以向下兼容的，不过最好不要这样用。

\_\_destruct()方法是析构函数，不需要显式的调用，系统会自动调用这个方法。而且析构函数不需要参数，因为它不需要去调用嘛，系统自动调用的时候也是不会去带参数的。

```php
public function __construct()
{
    echo '构造函数' . PHP_EOL;
}

public function __destruct()
{
    echo '析构函数' . PHP_EOL;
}
```

> __call()与__callStatic()

非常重要而且也是面试时经常会问到的魔术方法。它们俩的作用其实差不多，都是用于未定义的方法，当使用这些未定义的方法时就会进入这两个函数中。比如说我们调用$a->b();这个方法，但其实在$a的类模板中并没有b()方法，这时就会进入\_\_call()方法进行处理。\_\_callStatic()则是通过静态调用时如果没有定义对应的方法，就进入到\_\_callStatic()方法中，如A::b()，并没有定义b()方法，这时就进入了\_\_callStatic()中进行处理。

开头说道，\_\_call()可以实现类似于Java中的函数重载的能力。函数重载其实就是同名的函数，但参数或返回值不同，在Java等强类型语言中可以方便的实现，但PHP是弱类型语言，无法准确的定位方法的重载，使用\_\_call()方法其实也需要很多的判断，并不是非常的推荐一定要和Java一样的去实现函数重载。我们还是需要根据语言的特性来对业务功能进行深入的分析后再进行对应的实现。

在Laravel框架中，使用的Facade模式，也就是门面模式，核心代码就是使用了\_\_callStatic()方法。有兴趣的小伙伴可以自行查看下Laravel的源码。

```php
public function __call($name, $arguments)
{
    echo '===call===' . PHP_EOL;
    echo '未定义的方法找我' . PHP_EOL;
    echo '您需要的是' . $name . '，参数是：';
    print_r($arguments);
    echo '===call===' . PHP_EOL;
}

public static function __callStatic($name, $arguments)
{
    echo '===callStatic===' . PHP_EOL;
    echo '未定义的静态方法找我' . PHP_EOL;
    echo '您需要的是' . $name . '，参数是：';
    print_r($arguments);
    echo '===callStatic===' . PHP_EOL;
}
```

$name参数是方法的名称，如$a->b()，$name的值就是"b"。$arguments是参数数组，如$a->b("1",2);则$arguments=["1", 2];

> __set()和__get()

上面的\_\_call()方法针对的是未定义的方法。而\_\_set()和\_\_get()则是操作不可访问的属性。注意，这里并不是指没有定义的属性，如果定义为private的属性也可以通过这两个魔术方法来进行定义，当然，也包括未定义的属性。这两个属性其实可以对应Java中对于Java Bean的属性封装。

例如$a->p=1;，两种情况：
- 我们没有定义$p这个属性
- 我们定义了$p，但是是private $p;

以上两种情况都适用于\_\_set()和\_\_get()魔术方法。

```php
public function __set($name, $value)
{
    echo '===set===' . PHP_EOL;
    echo '给不可访问的属性赋值时找我' . PHP_EOL;
    echo '您需要的是' . $name . '，值是：' . $value . PHP_EOL;
    echo '===set===' . PHP_EOL;
    if ($name == 'a') {
        $this->$name = $value;
    }
}

public function __get($name)
{
    echo '===get===' . PHP_EOL;
    echo '获取不可访问的属性赋值时找我' . PHP_EOL;
    echo '您需要的是' . $name . PHP_EOL;
    echo '===get===' . PHP_EOL;
    return $this->$name;
}
```

> __isset()与__unset()

这两个就很好理解了，从字面意思也可以看出，一个是在使用isset()时会触发，而另一个则是在使用unset()时会触发。

需要注意的是，\_\_isset()是在isset()和empty()时都会进行触发。都是在判断属性是否存在或者是否为空时可以进行一些操作，也是属性封装相关的操作函数。

```php
public function __isset($name)
{
    echo '===isset===' . PHP_EOL;
    echo '调用isset()或empty()时来找我了' . PHP_EOL;
    echo '您要找的是' . $name . PHP_EOL;
    echo '===isset===' . PHP_EOL;
    return property_exists($this, $name);
}

public function __unset($name)
{
    echo '===unset===' . PHP_EOL;
    echo '调用unset()时来找我' . PHP_EOL;
    echo '您要找的是' . $name . PHP_EOL;
    echo '===unset===' . PHP_EOL;
}
```

这篇文章主要介绍的是几个非常常用的，而且在面试时出现频率也是非常高的魔术方法。在下一篇中将会介绍其它一些出现频率较低但更有意思的魔术方法。

完整代码：[https://github.com/zhangyue0503/php/blob/master/newblog/PHPMagic.php](https://github.com/zhangyue0503/php/blob/master/newblog/PHPMagic.php)