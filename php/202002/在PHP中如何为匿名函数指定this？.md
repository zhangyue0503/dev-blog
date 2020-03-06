# 在PHP中如何为匿名函数指定this？

在之前的文章中，我们已经学习过匿名函数的使用，没有看过的小伙伴可以进入传送门先去了解下闭包匿名函数的用法，传送：[还不知道PHP有闭包？那你真OUT了](https://mp.weixin.qq.com/s/R6vkVxidjsFf5YJ-kHN1Cw)。

关于闭包匿名函数，在JS中有个很典型的问题就是要给它绑定一个 this 作用域。其实这个问题在PHP中也是存在的，比如下面这段代码：

```php
$func = function($say){
    echo $this->name, '：', $say, PHP_EOL;
};
$func('good'); // Fatal error: Uncaught Error: Using $this when not in object context 
```

在这个匿名函数中，我们使用了 $this->name 来获取当前作用域下的 $name 属性，可是，这个 $this 是谁呢？我们并没有定义它，所以这里会直接报错。错误信息是：使用了 $this 但是没有对象上下文，也就是说没有指定 $this 引用的作用域。

## bindTo() 方法绑定 $this

好吧，那么我们就给它一个作用域，和 JS 一样，使用一个 bindTo() 方法即可。

```php
$func1 = $func->bindTo($lily, 'Lily');
// $func1 = $func->bindTo($lily, Lily::class);
// $func1 = $func->bindTo($lily, $lily);
$func1('cool');
```

这回就可以正常输出了。 bindTo() 方法是复制一个当前的闭包对象，然后给它绑定 $this 作用域和类作用域。其中， $lily 参数是一个 object $newthis 参数，也就是给这个复制出来的匿名函数指定 $this 。而第二个参数 'Lily' 则是绑定一个新的 类作用域 ，它代表一个类型、决定在这个匿名函数中能够调用哪些 私有 和 受保护 的方法，上例中给出的三种方式都可以用来定义这个参数。如果不给这个参数，那么我们就不能访问这个 private 的 $name 属性了：

```php
$func2 = $func->bindTo($lily);
$func2('cool2'); // Fatal error: Uncaught Error: Cannot access private property Lily::$name
```

## call() 方法绑定 $this

在PHP7以后，PHP新增加了 call() 方法来进行匿名函数的 $this 绑定，我们来看看它和 bindTo() 方法有哪些区别。

```php
$func->call($lily, 'well'); // Lily：well
```

额......

是不是感觉方便好多。首先，它直接执行了，不需要再赋值给一个变量，也就是说，它不是去复制那个闭包函数的而是直接执行了；其次，没有 类作用域 这个概念了，第一个参数还是指定新的 $this 的指向，而后面的参数就是原来闭包函数的参数。

虽然很方便，但是它也带来了另一个问题，因为没有 类作用域 的限制，所以会破坏封装。你好不容易做好的面向对象的设计，封装了一堆属性，然后使用这个 call() 就让对象的所有 私有 和 受保护 内容都暴露了出来。当然，这也是看我们自己的业务情况了，毕竟两种形式我们在写代码的时候都是可以自由选择的。

## 总结

其实包括闭包函数在内，这些特性都非常像JS。这也是语言融合的一种趋势，不管是学习了JS来看PHP的这些特性还是先学了PHP再去看JS，都会让我们更容易理解它们的作用与能力，这就是语言特性融合带来的好处。不管怎么样，学就是了，继续加油吧！！

测试代码：

参考文档：
[https://www.php.net/manual/zh/functions.anonymous.php](https://www.php.net/manual/zh/functions.anonymous.php)
[https://www.php.net/manual/zh/closure.bindto.php](https://www.php.net/manual/zh/closure.bindto.php)
[https://www.php.net/manual/en/closure.call.php](https://www.php.net/manual/en/closure.call.php)