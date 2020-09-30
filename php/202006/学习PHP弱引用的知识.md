# 学习PHP弱引用的知识

之前的文章中，我们已经学习过引用和引用传值相关的知识。我们知道，PHP 中没有纯引用（指针），不管是对象，还是用引用符号 & 赋值的变量，都是对一个符号表的引用。而今天，我们要学习的是另一种引用形式：弱引用。

## 什么是弱引用

*弱引用允许程序员保留对对象的引用，而该对象不会阻止对象被销毁；它们对于实现类似缓存的结构非常有用。*

这是比较官方的解释。从这个说明中，我们可以看出，弱引用也是一种引用形式，但是，如果我们销毁了原来的对象，那么弱引用对象也会被销毁，就像普通的值对象赋值一样。如果没有看过之前的文章，或者对 PHP 中的引用不太熟悉的朋友可能需要再了解一下 PHP 中引用相关的知识。下面，我们直接通过示例来看一下。

## WeakReference

```php
$obj = new stdClass;
$weakref = $obj;

var_dump($weakref);
// object(stdClass)#1 (0) {
// }

unset($obj);
var_dump($weakref);
// object(stdClass)#1 (0) {
// }

$obj1 = new stdClass;
$weakref = WeakReference::create($obj1);

var_dump($weakref->get());
// object(stdClass)#2 (0) {
// }

unset($obj1);
var_dump($weakref->get());
// NULL

$weakref = WeakReference::create(new stdClass);
var_dump($weakref->get());
// NULL
```

第一个对象 \\$obj 我们进行直接的赋值引用，也就是 PHP 默认的对象赋值。这时候，$weakref 保存的是对象符号表的引用。当我们 unset() 掉 $obj 时，$weakref 依然能够正常使用。也就是说，$weakref 对 $obj 原始对象的内存引用依然保持着。不管我们怎么 unset() 原始的 $obj ，都只是切断了 $obj 的引用符号表，对真正的对象没有影响，垃圾回收器也不会彻底的回收最最原始的 $obj 对象内容。

第二个对象我们使用的是 WeakReference 的 create() 方法来创建的弱引用，当我们销毁 $obj1 后，$weakref 也会变成 NULL 。这就是弱引用的作用！

它可以让垃圾回收器正常的回收，它可以避免循环引用带来的内存泄漏问题，它能让引用表现为类似于 C 中的指针操作一样。

最后一段代码是我们通过 WeakReference::create() 中直接使用 new 来创建对象。这种形式是不行的，会一直返回 NULL 。因为弱引用是通过变量来创建的，它指向的是原始对象的符号表，而变量和对象之间的符号表连接才是弱引用关心的内容，它会根据符号表的状态来判断当前的状态。如果原始对象变量切断了与符号表的连接，那么弱引用的变量也会同步切断，这样，垃圾回收器就能正常的清理这个已经没有任何引用计数的对象了。

## 注意

这里需要注意的是，上面的测试代码必须在 PHP7.4 及以上版本才有用，WeakReference 类是 PHP7.4 新增加的内容。之前的版本需要安装 WeakRef 这个扩展才能实现弱引用的能力，具体的内容可以查阅下方链接中的相关的文档。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/%E5%AD%A6%E4%B9%A0PHP%E5%BC%B1%E5%BC%95%E7%94%A8%E7%9A%84%E7%9F%A5%E8%AF%86.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/%E5%AD%A6%E4%B9%A0PHP%E5%BC%B1%E5%BC%95%E7%94%A8%E7%9A%84%E7%9F%A5%E8%AF%86.php)

参考文档：

[https://www.php.net/manual/en/class.weakreference.php](https://www.php.net/manual/en/class.weakreference.php)

[https://www.php.net/manual/zh/book.weakref.php](https://www.php.net/manual/zh/book.weakref.php)