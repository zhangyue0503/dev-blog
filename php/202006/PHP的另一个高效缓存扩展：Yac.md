# PHP的另一个高效缓存扩展：Yac

之前的文章中我们已经学习过一个 PHP 自带的扩展缓存 Apc ，今天我们来学习另一个缓存扩展：Yac 。

## 什么是 Yac

从名字其实就能看出，这又是鸟哥大神的作品。作为我们中国程序员的骄傲，在 PHP 界有举足轻重的地位。毕竟是 PHP 的核心开发人员，他的作品每次都不会让我们失望。

Yac 是一个无锁共享缓存系统，因为无锁，所以它的效率非常高。据说 Apc 的效率是 Memcached 的一倍以上，而 Yac 比 Apc 更快。这就是它最大的特点。

相对于 Memcached 或者 Redis 来说，Yac 更加轻量级，我们也不需要在服务器中再安装别的什么软件，只需要安装这个扩展就可以使用。对于小型系统特别是就是简单的进行数据缓存的系统来说，我们不需要复杂的数据类型，只用这种程序语言的扩展就能让我们的开发更为方便快捷。

安装的方式也非常简单，一样的在 PECL 下载安装包后进行扩展安装即可。

## 基本操作

对于缓存相关的操作，无外乎就是添加、修改、删除缓存。不像外部缓存系统，在保存数组或对象时，PHP 扩展类的缓存都能直接保存这些数据类型，而不用序列化为字符串或者转化为 JSON 字符串，这是 Apc 和 Yac 的优势之一。

### 添加、获取缓存

```php
$yac = new Yac();
$yac->add('a', 'value a');
$yac->add('b', [1,2,3,4]);

$obj = new stdClass;
$obj->v = 'obj v';
$yac->add('obj', $obj);


echo $yac->get('a'), PHP_EOL; // value a
echo $yac->a, PHP_EOL; // value a


print_r($yac->get('b'));
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
// )

var_dump($yac->get('obj'));
// object(stdClass)#3 (1) {
//     ["v"]=>
//     string(5) "obj v"
// }
```

非常简单的操作，我们只需要实例化一个 Yac 类，就可以通过 add() 方法及 get() 方法添加和获取缓存内容。

Yac 扩展还重写了 __set() 和 __get() 魔术方法，所以我们可以直接通过操作变量的方式来操作缓存。

接下来，我们可以通过 info() 函数查看当前缓存的状态信息。

```php
print_r($yac->info());
// Array
// (
//     [memory_size] => 71303168
//     [slots_memory_size] => 4194304
//     [values_memory_size] => 67108864
//     [segment_size] => 4194304
//     [segment_num] => 16
//     [miss] => 0
//     [hits] => 4
//     [fails] => 0
//     [kicks] => 0
//     [recycles] => 0
//     [slots_size] => 32768
//     [slots_used] => 3
// )
```

### 设置缓存

```php
$yac->set('a', 'new value a!');
echo $yac->a, PHP_EOL; // new value a!

$yac->a = 'best new value a!';
echo $yac->a, PHP_EOL; // best new value a!
```

set() 函数的作用就是如果当前缓存 key 存在，就修改这个缓存的内容，如果不存在，就创建一个缓存。

### 删除缓存

```php
$yac->delete('a');
echo $yac->a, PHP_EOL; // 

$yac->flush();
print_r($yac->info());
// Array
// (
//     [memory_size] => 71303168
//     [slots_memory_size] => 4194304
//     [values_memory_size] => 67108864
//     [segment_size] => 4194304
//     [segment_num] => 16
//     [miss] => 1
//     [hits] => 6
//     [fails] => 0
//     [kicks] => 0
//     [recycles] => 0
//     [slots_size] => 32768
//     [slots_used] => 0
// )
```

对于单个缓存的删除，我们可以直接使用 delete() 函数来删除这个缓存的内容。如果要清空整个缓存空间，就可以直接使用 flush() 来清空整个缓存空间。

### 别名空间

上面我们提到了 缓存空间 这个东西。其实也就是在实例化 Yac 的时候可以给默认的 Yac 类构造函数传递一个别名配置。这样，不同的 Yac 实例就相当于放在了不同的命名空间中，相同的 Key 的缓存在不同的空间中就不会相互影响。

```php
$yacFirst = new Yac();
$yacFirst->a = 'first a!';;

$yacSecond = new Yac();
$yacSecond->a = 'second a!';

echo $yacFirst->a, PHP_EOL; // second a!
echo $yacSecond->a, PHP_EOL; // second a!
```

这段代码我们都是使用的默认的实例化 Yac 对象，虽说是分开实例化的，但它们保存的空间是一样的，所以相同的 a 变量会相互覆盖。

```php
$yacFirst = new Yac('first');
$yacFirst->a = 'first a!';;

$yacSecond = new Yac('second');
$yacSecond->a = 'second a!';

echo $yacFirst->a, PHP_EOL; // first a!
echo $yacSecond->a, PHP_EOL; // second a!
```

当我们使用不同的实例化参数之后，相同的 a 就不会相互影响，它们被存储在了不同的空间中。或者说，Yac 会自动给这些 Key 增加一个 prefix 。

### 缓存时效

最后，缓存系统都会针对缓存内容有时效限制，如果指定了过期时间，缓存内容就会在指定的时间之后过期。

```php
$yac->add('ttl', '10s', 10);
$yac->set('ttl2', '20s', 20);
echo $yac->get('ttl'), PHP_EOL; // 10s
echo $yac->ttl2, PHP_EOL; // 20s

sleep(10);

echo $yac->get('ttl'), PHP_EOL; // 
echo $yac->ttl2, PHP_EOL; // 2
```

上述代码中的 ttl 缓存只设置了 10 秒的过期时间，所以在 sleep() 10 秒后，输出 ttl 就没有任何内容了。

需要注意的是，对于时间的设置，如果不设置的话就是长久有效，而且不能用 __set() 方法设置过期时间，只能使用 set() 或者 add() 函数来设置过期时间。

## 总结

怎么样，Yac 扩展是不是和我们的 Apc 一样方便好用，当然，更主要的是它的性能以及适用场景。对于小系统，特别是机器配置不是那么强的操作环境中，这种扩展型的缓存系统能够让我们的开发更加的快捷方便。关于无锁共享的概念我们可以参考下方参考文档中第二个链接，也就是鸟哥的文章中有详细的说明。

测试代码：

[]()

参考文档：

[https://www.php.net/manual/zh/book.yac.php](https://www.php.net/manual/zh/book.yac.php)
[https://www.laruence.com/2013/03/18/2846.html](https://www.laruence.com/2013/03/18/2846.html)
[https://www.cnblogs.com/sunsky303/p/6554888.html](https://www.cnblogs.com/sunsky303/p/6554888.html)