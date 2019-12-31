# final关键字在PHP中的使用

final关键字的使用非常简单，在PHP中的最主要作用是定义不可重写的方法。什么叫不可重写的方法呢？就是子类继承后也不能重新再定义这个同名的方法。

```php
class A {
    final function testA(){
        echo 'This is class A!', PHP_EOL;
    }
}

class childA extends A {
    //  Fatal error: Cannot override final method A::testA()
    function testA(){
        echo 'This is class childA', PHP_EOL;
    }
}
```

而如果在类定义前加上这个关键字的话，则类也是不可继承的。

```php
final class B {
    function testB(){
        echo 'This is class B!', PHP_EOL;
    }
}

// Fatal error: Class childB may not inherit from final class (B)
class childB extends B{

}
```

由此可见，final关键字就和他本身的意义一样，这个类或者方法是不可改变的。那么接口能不能用这个关键字呢？答案当然是否定的，接口的意义本身就是定义一个契约让实现类来实现，如果定义了final关键字，那么接口的意义就不存在了，所以从语言层面来说接口以及接口中的方法就不能使用final关键字。

```php
interface C {
    // Fatal error: Access type for interface method C::testC() must be omitted 
    final function testC();
}
```

在Java中，final还可以用来定义常量，但在PHP中，类常量是通过const来定义的。所以final定义不了变量。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/final%E5%85%B3%E9%94%AE%E5%AD%97%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/final%E5%85%B3%E9%94%AE%E5%AD%97%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.final.php](https://www.php.net/manual/zh/language.oop5.final.php)