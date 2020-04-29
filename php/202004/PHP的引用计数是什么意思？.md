# PHP的引用计数是什么意思？

## 什么是引用计数

在PHP的数据结构中，引用计数就是指每一个变量，除了保存了它们的类型和值之外，还额外保存了两个内容，一个是当前这个变量是否被引用，另一个是引用的次数。为什么要多保存这样两个内容呢？当然是为了垃圾回收（GC）。也就是说，当引用次数为0的时候，这个变量就没有再被使用了，就可以通过 GC 来进行回收，释放占用的内存资源。任何程序都不能无限制的一直占用着内存资源，过大的内存占用往往会带来一个严重的问题，那就是内存泄露，而 GC 就是PHP底层自动帮我们完成了内存的销毁，而不用像 C 一样必须去手动地 free 。

## 怎么查看引用计数？

我们需要安装 xdebug 扩展，然后使用 xdebug_debug_zval() 函数就可以看到指定内存的详细信息了，比如：

```php
$a = "I am a String";
xdebug_debug_zval('a');
// a: (refcount=1, is_ref=0)='I am a String'
```

从上述内容中可以看出，这个 $a 变量的内容是 I am a String 这样一个字符串。而括号中的 refcount 就是引用次数，is_ref 则是说明这个变量是否被引用。我们通过变量赋值来看看这个两个参数是如何变化的。

```php
$b = $a;
xdebug_debug_zval('a');
// a: (refcount=1, is_ref=0)='I am a String'

$b = &$a;
xdebug_debug_zval('a');
// a: (refcount=2, is_ref=1)='I am a String'
```

当我们进行普通赋值后，refcount 和 is_ref 没有任何变化，但当我们进行引用赋值后，可以看到 refcount 变成了2，is_ref 变成了1。这也就是说明当前的 $a 变量被引用赋值了，它的内存符号表服务于 $a 和 $b 两个变量。

```php
$c = &$a;
xdebug_debug_zval('a');
// a: (refcount=3, is_ref=1)='I am a String'

unset($c, $b);
xdebug_debug_zval('a');
// a: (refcount=1, is_ref=1)='I am a String'

$b = &$a;
$c = &$a;
$b = "I am a String new";
xdebug_debug_zval('a');
// a: (refcount=3, is_ref=1)='I am a String new'

unset($a);
xdebug_debug_zval('a');
// a: no such symbol
```

继续增加一个 $c 的引用赋值，可以看到 refcount 会继续增加。然后 unset 掉 $b 和 $c 之后，refcount 恢复到了1，不过这时需要注意的是，is_ref 依然还是1，也就是说，这个变量被引用过，这个 is_ref 就会变成1，即使引用的变量都已经 unset 掉了这个值依然不变。

最后我们 unset 掉 $a ，显示的就是 no such symbol 了。当前变量已经被销毁不是一个可以用的符号引用了。（注意，PHP中的变量对应的是内存的符号表，并不是真正的内存地址）

## 对象的引用计数

和普通类型的变量一样，对象变量也是使用同样的计数规则。

```php
// 对象引用计数
class A{

}
$objA = new A();
xdebug_debug_zval('objA');
// objA: (refcount=1, is_ref=0)=class A {  }

$objB = $objA;
xdebug_debug_zval('objA');
// objA: (refcount=2, is_ref=0)=class A {  }

$objC = $objA;
xdebug_debug_zval('objA');
// objA: (refcount=3, is_ref=0)=class A {  }

unset($objB);
class C{

}
$objC = new C;
xdebug_debug_zval('objA');
// objA: (refcount=1, is_ref=0)=class A {  }
```

不过这里需要注意的是，对象的符号表是建立的连接，也就是说，对 $objC 进行重新实例化或者修改为 NULL ，并不会影响 $objA 的内容，这方面的知识我们在之前的 [对象赋值在PHP中到底是不是引用？](https://mp.weixin.qq.com/s/wKIU83A7u1ENQF32jX5FSQ) 文章中已经有过说明。对象进行普通赋值操作也是引用类型的符号表赋值，所以我们不需要加 & 符号。

## 数组的引用计数

```php
// 数组引用计数
$arrA = [
    'a'=>1,
    'b'=>2,
];
xdebug_debug_zval('arrA');
// arrA: (refcount=2, is_ref=0)=array (
//     'a' => (refcount=0, is_ref=0)=1, 
//     'b' => (refcount=0, is_ref=0)=2
// )

$arrB = $arrA;
$arrC = $arrA;
xdebug_debug_zval('arrA');
// arrA: (refcount=4, is_ref=0)=array (
//     'a' => (refcount=0, is_ref=0)=1, 
//     'b' => (refcount=0, is_ref=0)=2
// )

unset($arrB);
$arrC = ['c'=>3];
xdebug_debug_zval('arrA');
// arrA: (refcount=2, is_ref=0)=array (
//     'a' => (refcount=0, is_ref=0)=1, 
//     'b' => (refcount=0, is_ref=0)=2
// )

// 添加一个已经存在的元素
$arrA['c'] = &$arrA['a'];
xdebug_debug_zval('arrA');
// arrA: (refcount=1, is_ref=0)=array (
//     'a' => (refcount=2, is_ref=1)=1, 
//     'b' => (refcount=0, is_ref=0)=2, 
//     'c' => (refcount=2, is_ref=1)=1
// )
```

调试数组的时候，我们会发现两个比较有意思的事情。

一是数组内部的每个元素又有单独的自己的引用计数。这也比较好理解，每一个数组元素都可以看做是一个单独的变量，但数组就是这堆变量的一个哈希集合。如果在对象中有成员变量的话，也是一样的效果。当数组中的某一个元素被 & 引用赋值给其他变量之后，这个元素的 refcount 会增加，不会影响整个数组的 refcount 。

二是数组默认上来的 refcount 是2。其实这是 PHP7 之后的一种新的特性，当数组定义并初始化后，会将这个数组转变成一个不可变数组（immutable array）。为了和普通数组区分开，这种数组的 refcount 是从2开始起步的。当我们修改一下这个数组中的任何元素后，这个数组就会变回普通数组，也就是 refcount 会变回1。这个大家可以自己尝试下，关于为什么要这样做的问题，官方的解释是为了效率，具体的原理可能还是需要深挖 PHP7 的源码才能知晓。

## 关于内存泄露需要注意的地方

其实 PHP 在底层已经帮我们做好了 GC 机制就不需要太关心变量的销毁释放问题，但是，千万要注意的是对象或数组中的元素是可以赋值为自身的，也就是说，给某个元素赋值一个自身的引用就变成了循环引用。那么这个对象就基本不太可能会被 GC 自动销毁了。

```php
// 对象循环引用
class D{
    public $d;
}
$d = new D;
$d->d = $d;
xdebug_debug_zval('d');
// d: (refcount=2, is_ref=0)=class D { 
//     public $d = (refcount=2, is_ref=0)=... 
// }

// 数组循环引用
$arrA['arrA'] = &$arrA;
xdebug_debug_zval('arrA');
// arrA: (refcount=2, is_ref=1)=array (
//     'a' => (refcount=0, is_ref=0)=1, 
//     'b' => (refcount=0, is_ref=0)=2, 
//     'arrA' => (refcount=2, is_ref=1)=...
// )
```

不管是对象还是数组，在打印调试时出现了 ... 这样的省略号，那么你的程序中就出现了循环引用。在之前的文章 [关于PHP中对象复制的那点事儿](https://mp.weixin.qq.com/s/OsxFg4llRLhey75DnNyl3A) 中我们也讲过这个循环引用的问题，所以这个问题应该是我们在日常开发中应该时刻关注的问题。

## 总结

引用计数是了解垃圾回收机制的前提条件，而且正是因为现代语言中都有一套类似的垃圾回收机制才让我们的编程变得更加容易且安全。那么有人说了，日常开发根本用不到这些呀？用不到不代表不应该去学习，就像循环引用这个问题一样，当代码中充斥着大量的类似代码时，系统崩溃只是迟早的事情，所以，这些知识是我们向更高级的程序进阶所不可或缺的内容。

测试代码：


参考文档：
[https://www.php.net/manual/zh/features.gc.refcounting-basics.php](https://www.php.net/manual/zh/features.gc.refcounting-basics.php)
[https://ask.csdn.net/questions/706390](https://ask.csdn.net/questions/706390)
[https://www.jianshu.com/p/52450a61354d](https://www.jianshu.com/p/52450a61354d)