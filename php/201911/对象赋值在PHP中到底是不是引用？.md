# 对象赋值在PHP中到底是不是引用？

之前的文章中，我们说过变量赋值的问题，其中有一个问题是对象在进行变量赋值的时候，直接就是引用赋值。那么到底真实情况是怎样呢？

> 之前变量赋值的文章

[PHP的变量赋值](https://mp.weixin.qq.com/s/EYGx3YQuQXgARRgpovuK-Q)

> 对象引用测试

在继续深入的学习PHP手册后，发现原来对象还真不是直接的引用复制。通过下面手册中的例子来进行分析：

```php
class SimpleClass
{}

$instance = new SimpleClass();

$assigned = $instance;
$reference = &$instance;

$instance->var = '$assigned will have this value';

$instance = null; // $instance and $reference become null

var_dump($instance);
var_dump($reference);
var_dump($assigned);
```

- $instance是实例化后的SimpleClass对象
- $assigned直接赋值
- $reference引用赋值
- 首先，我们给$instance对象定义了一个变量var
- 然后将$instance赋值为null
- 对于引用来说，$reference变量自然也为成了null
- 但是$assigned并没有变成null，它依然是SimpleClass的实例对象，并且，划重点哦：它有了var属性

是不是很神奇，照理说，普通赋值是拷贝，两个变量不会相互影响。而引用赋值是复制指针（相同的内存地址），修改任意一个变量其他的变量也会改变。但是对象的普通赋值貌似并不属于它们中的任何一个。

$reference很好理解，本身使用&符号进行了赋值，表明了这个变量是一个引用赋值。它成为了$instance的快捷方式，$instance的一切变化它都都会跟着改变。这是变量层面的。

$assigned从代码字面上看是一个普通赋值。不过对象是一种特殊的形态，它用普通赋值赋过来的值其实是对象的一个句柄。在PHP手册中有一个Note是如此描述的：

*首先，将PHP中的变量看成是一个一个的数据槽。这个数据槽可以保存一个基本类型（int、string、bool等）。创建引用时，这个槽里保存的是内存地址，或者说是指向引用对象的一个指针，引用没有拷贝操作，仅仅是将指针指向了原变量（参考数据结构）。创建普通赋值时，则是拷贝的基本类型。*

*而对象则与基本类型不同，它不能直接保存在数据槽中，而是将对象的“句柄”保存在了数据槽。这个句柄是指向对象特定实例的标识符。虽然句柄不是我们所能直观操作的类型，但它也属于基本类型。*

*当你获取一个包含对象句柄的变量，并将其分配给另一个变量时，另一个变量获取的是这个对象的句柄。（注意，不是引用！不是引用！不是引用！！）。通过句柄，两个变量都可以修改同一个对象。但是，这两个变量并没有直接关系，它们是两个独立的变量，其中一个变量修改为其他值时，并不会对另一个变量产生影响。只有该变量在修改对象内部的内容时，另一个变量因为持有相同的句柄，所以它的对象内容也会相应地发生改变。*

Note原文：
[https://www.php.net/manual/zh/language.oop5.basic.php#79856](https://www.php.net/manual/zh/language.oop5.basic.php#79856)

> 总结

通过本文的分析，我们可以看出，变量赋值说白了就是变量层面的操作。它保存的永远只是一个值而已。当普通赋值时，这个值就是一个基本类型。当引用赋值时，这个保存的基本类型就是一个指针。不管怎么样，它也不会因为保存的是对象而将普通赋值直接转变为引用赋值，真正的引用赋值是必须要加&符的。

这个内容有点绕，不过这样的内容才能更体现自己的核心能力。读书百遍其义自现，对于手册中的很多知识本人也是来回不断学习才能理解。上面的Note作者写得非常好，英文好的朋友可以直接去看英文原版。

测试代码：


参考文档：
[https://www.php.net/manual/zh/language.oop5.basic.php](https://www.php.net/manual/zh/language.oop5.basic.php)