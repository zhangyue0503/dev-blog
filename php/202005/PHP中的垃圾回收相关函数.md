# PHP中的垃圾回收相关函数

之前我们已经学习过 PHP 中的引用计数以及垃圾回收机制的概念。这些内容非常偏理论，也是非常常见的面试内容。而今天介绍的则是具体的关于垃圾回收的一些功能函数。关于之前的两篇介绍文章，大家可以到文章底部查看。

## 再谈循环引用以及强制清理循环引用

我们为什么要强调 “循环引用” 呢？其实，在默认情况下，我们直接 unset() 掉一个没有被其他变量引用的变量时，就会让这个变量的引用计数变为0。这时，PHP 默认的垃圾回收机制就会直接清除掉这个变量。比如：

```php
$a = new stdClass;
$b = new stdClass;
$c = new stdClass;
echo memory_get_usage(), PHP_EOL; // 706528

unset($a);
echo memory_get_usage(), PHP_EOL; // 706488

gc_collect_cycles();
echo memory_get_usage(), PHP_EOL; // 706488
```

从上面的代码中可以看出，我们 unset() 掉 $a 之后，内存直接就减少了。但是，如果是产生了循环引用的情况，那么简单的进行 unset() 就没有效果了。

```php
class D{
    public $d;
}
$d = new D;
$d->d = $d;
echo memory_get_usage(), PHP_EOL; // 706544

unset($d);
echo memory_get_usage(), PHP_EOL; // 706544

gc_collect_cycles();
echo memory_get_usage(), PHP_EOL; // 706488
```

在这段代码中，我们对 $d 进行了一个简单的循环引用赋值。使用 unset() 后，内存没有发生变化，这时，只能使用 gc_collect_cycles() 函数来进行强制的循环引用清理，才能将 $d 里面的无效循环引用清除掉。

没错，这一段的重点正是 gc_collect_cycles() 这个函数。它在正常情况下对普通的变量引用是不会产生什么清理效果的，当然，对于普通的变量我们直接 unset() 掉就可以了。它最主要的作用就是针对循环引用的清理。之前我们学习过，循环引用计数会存在一个 根缓冲区 ，一般默认情况下它能容纳 10000 个待清理的 可能根 。而 gc_collect_cycles() 的作用就是不用等这个 根缓冲区 满就直接进行清理（个人理解）。关于这个垃圾回收算法的内容请移步：[PHP垃圾回收机制的一些浅薄理解]()

其实，大部分情况下我们是不太需要关注 PHP 的垃圾回收问题的，也就是说，我们不是很需要手动地去调用这个 gc_collect_cycles() 函数。PHP-FPM 在每次调用完成后会直接整体的释放，简单的一次 CLI 脚本执行完也会全部释放。没错，正常情况下，PHP 一次执行完成之后就会销毁所有的内容，内存垃圾自然也就不存在了。但是，在执行长时间的守护脚本时，或者使用常驻进程的框架（Swoole）时，还是需要注意有没有循环引用的问题。因为这种程序一直运行，如果存在大量循环引用对象时，就有可能导致内存泄露。

## 开启、关闭及查看循环引用垃圾回收状态

```php
gc_disable();
echo gc_enabled(), PHP_EOL; //
gc_enable();
echo gc_enabled(), PHP_EOL; // 1
```

很简单的三个函数，gc_disable() 是 “停用循环引用收集器”，gc_enable() 是“开启循环引用收集器”，而 gc_enabled() 就是查看当前的循环引用收集器是否开启。

## 强制回收Zend引擎内存管理器使用的内存

```php
gc_mem_caches()
```

官网及网络上并没有什么详细的介绍，不过从定义来看，它主要的作用就是回收 PHP 底层的 Zend 引擎内存管理器所使用过的内存。这个大家了解下就好，平常也从来没用过。

## 获取垃圾收集器的信息

```php
$e = new stdClass;
for($i = 100;$i>0;$i--){
    $e->list[] = $e;
}

unset($e);
gc_collect_cycles();

var_dump(gc_status());
// array(4) {
//     ["runs"]=>int(1)
//     ["collected"]=>int(2)
//     ["threshold"]=>int(10001)
//     ["roots"]=>int(0)
// }
```

我们还是做了一个循环引用的对象，然后使用 gc_status() 来查看当前垃圾回收器中关于循环引用的状态。从返回的内容可以看出， runs 运行了 1 个，collected 收集了 2 个， threshold 阈值是 10001，roots 可能根没有了（已经被回收了）。

这个函数可以在测试环境中对代码的运行情况进行检查，查看我们代码中有没有不正常的循环引用情况，当然，上面的解释也只是个人的推测，因为关于这方面的资料确实非常少。所以也希望深入研究过这方面内容的大神能够留言指点迷津！！

测试代码：


参考文档：
[PHP的引用计数是什么意思？]()
[PHP垃圾回收机制的一些浅薄理解]()
[https://www.php.net/manual/zh/function.gc-collect-cycles.php](https://www.php.net/manual/zh/function.gc-collect-cycles.php)
[https://www.php.net/manual/zh/function.gc-disable.php](https://www.php.net/manual/zh/function.gc-disable.php)
[https://www.php.net/manual/zh/function.gc-enable.php](https://www.php.net/manual/zh/function.gc-enable.php)
[https://www.php.net/manual/zh/function.gc-enabled.php](https://www.php.net/manual/zh/function.gc-enabled.php)
[https://www.php.net/manual/zh/function.gc-mem-caches.php](https://www.php.net/manual/zh/function.gc-mem-caches.php)
[https://www.php.net/manual/zh/function.gc-status.php](https://www.php.net/manual/zh/function.gc-status.php)



