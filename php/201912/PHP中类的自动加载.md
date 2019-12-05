
# PHP中类的自动加载

在之前，我们已经学习过Composer自动加载的原理，其实就是利用了PHP中的类自动加载的特性。在文末有该系列文章的链接。

PHP中类的自动加载主要依靠的是__autoload()和spl_autoload_register()这两个方法。今天我们就来简单的看一下这两个方法的使用。

### **__autoload()**

做为一个已经快要被淘汰的魔术方法，我们只需要了解即可。如果在PHP7中使用这个方法的话，会报出过时的警告，系统会建议我们使用spl_autoload_register()方法。

```php
function __autoload($name){
    include __DIR__ . '/autoload/' . $name . '.class.php';
}

$autoA = new AutoA();
var_dump($autoA);
```

当我们实例化AutoA类时，当前的文件并没有这个类，也没有从其他文件中include或者require，这时，就会自动进入魔术方法__autoload()中。我们在__autoload()方法中只需要去include这个类所在的文件即可。

### **spl_autoload_register()**

这个方法目前已经替代了上述魔术方法自动加载类的功能。它是spl扩展库中的一个方法，spl扩展库现在已经默认集成在了PHP中，大家可以放心地直接使用。

spl_autoload_register()相对于__autoload()的好处是它可以去注册一个__autoload()，并且实现并维护了一个__autoload()队列。原来在一个文件中只能有一个__autoload()方法，但现在，你拥有的是一个队列。

这样，你就不需要将所有加载代码都写在一个__autoload()方法中，而是可以使用多个spl_autoload_register()去单独进行每个类的加载处理。

```php
spl_autoload_register(function($name){
    include __DIR__ . '/autoload/' . $name . '.class.php';
});

$autoA = new AutoA();
var_dump($autoA);
```

参考：[深入学习Composer原理（二）](https://mp.weixin.qq.com/s/KzRSF12WzFvHqpdHFSk_3w)

### **使用include还是include_once**

在自动加载中，我们只需要使用include就可以了，类并不会重复加载。

```php
spl_autoload_register(function($name){
    include __DIR__ . '/autoload/' . $name . '.class.php';
    echo $name, PHP_EOL;
});

$autoA = new AutoA();
var_dump($autoA);

$autoA = new AutoA();
var_dump($autoA);

$autoA = new AutoA();
var_dump($autoA);

$autoB = new AutoB();
var_dump($autoB);
```

从代码中，我们可以看出\$name在多次实例化类的情况下只被输出了一次。所以并不需要关心会有类文件重复加载的问题。而且在大弄框架和使用composer的时候会加载非常多的类，_once方法也会带来效率的问题。

### **总结**

这次的文章只是对类自动加载进行了简单的介绍，想深入了解这方面知识的可以移之前写过的Composer系列文章：

- [深入学习Composer原理（一）](https://mp.weixin.qq.com/s/fHWBqDu4xrixMhxh3eftkA)

- [深入学习Composer原理（二）](https://mp.weixin.qq.com/s/KzRSF12WzFvHqpdHFSk_3w)

- [深入学习Composer原理（三）](https://mp.weixin.qq.com/s/jkNf8_HU3swnMH4pFMyADA)

- [深入学习Composer原理（四）](https://mp.weixin.qq.com/s/EEDjqzLcKaAJhQ-VWDBX8w)

参考文档：
[https://www.php.net/manual/zh/language.oop5.autoload.php](https://www.php.net/manual/zh/language.oop5.autoload.php)