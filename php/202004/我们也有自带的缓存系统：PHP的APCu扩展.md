# 我们也有自带的缓存系统：PHP的APCu扩展

想必大家都使用过 memcached 或者 redis 这类的缓存系统来做日常的缓存，或者用来抗流量，或者用来保存一些常用的热点数据，其实在小项目中，PHP 也已经为我们准备好了一套简单的缓存系统，完全能够应付我们日常普通规模站点的开发。这一套扩展就是 APCu 扩展。

## APCu 扩展 

APCu 扩展是 APC 扩展的升级，APC 扩展已经不维护了。这两套扩展其实都是基于 opcode caching 。也就是 PHP 自身的 opcode 来实现的缓存能力。

APCu 的安装就和普通的 PHP 扩展一样，非常简单，最主要的是这个扩展还非常的小。不管下载还是安装都是秒级可以完成的。所以说能够非常方便的应用于小规模的项目，而且是 PHP 原生支持的，不需要额外的端口之类的配置。

## 方法说明

缓存系统一般都会有的增加、删除、查询、自增等功能都在 APCu 扩展中有对应的实现。

- apcu_add — 创建一个新的缓存
- apcu_cache_info — 查看 APCu 的全部缓存信息
- apcu_cas — 更新一个缓存的值为新值
- apcu_clear_cache — 清除全部的缓存
- apcu_dec — 自减缓存值
- apcu_delete — 删除一个缓存的内容
- apcu_enabled — 当前环境下是否启用 APCu 缓存
- apcu_entry — 原子地生成一个缓存实体
- apcu_exists — 检查缓存是否存在
- apcu_fetch — 查询缓存
- apcu_inc — 自增缓存值
- apcu_sma_info — 查询缓存的共享内存信息
- apcu_store — 保存一个缓存

## 使用演示

```php
apcu_add("int", 1);
apcu_add("string", "I'm String");
apcu_add("arr", [1,2,3]);

class A{
    private $apc = 1;
    function test(){
        echo "s";
    }
}

apcu_add("obj", new A);

var_dump(apcu_fetch("int"));
var_dump(apcu_fetch("string"));
var_dump(apcu_fetch("arr"));
var_dump(apcu_fetch("obj"));
```

正常的使用都是比较简单的，我们添加各种类型的数据都可以正常存入缓存。不过需要注意的是，我们可以直接保存对象进入 APCu 缓存中，不需要将它序列化或者JSON成字符串，系统会自动帮我们序列化。

apcu_add(string \\$key , mixed $var [, int $ttl = 0 ]) 方法就是普通的添加一个缓存，$ttl 可以设置过期时间，也是以秒为单位，如果不设置就是长期有效的。注意，APCu 的缓存时限在一次 CLI 中有效，再调用一次 CLI 取不到上次 CLI 中设置的缓存内容。而在 PHP-FPM 中，重启 PHP-FPM 或 FastCGI 之后缓存会失效。

接下来我们重点测试一下几个不太常见的方法。

```php
apcu_cas("int", 1, 2);
var_dump(apcu_fetch("int"));

// Warning  apcu_cas() expects parameter 2 to be int
apcu_cas("string", "I'm String", "I'm  New String");
```

apcu_cas(string $key , int $old , int $new) 是将一个 $old 值修改为 $new 值，它只能修改数字类型的内容，如果是字符串的修改会报错。这个函数有什么优势呢？它最大的优势是原子性的，也就是不受高并发的影响。与之类似的是 apcu_store(string $key , mixed $var [, int $ttl = 0 ]) 方法，不过这个方法只是简单的修改一个缓存的内容，如果这个缓存的键不存在的话，就新建一个，它不受类型的限制，当然也不具有原子性。

```php
apcu_entry("entry", function($key){
    return "This is " . $key;
});
var_dump(apcu_fetch("entry"));
```

apcu_entry(string $key , callable $generator [, int $ttl = 0 ]) 这个函数的作用是如果 $key 这个缓存不存在，则执行 $generator 这个匿名函数，并将 $key 做为键值传递进去，然后生成也就是 return 一个内容做为这个缓存的值。

```php
var_dump(apcu_cache_info());
```

最后，如果我们想查看当前系统中的所有 APCu 缓存信息的时候，直接用这个 apcu_cache_info() 函数即可。

## 总结

当缓存中的数据非常多时，它还提供了一个 APCUIterator 迭代器方便我们进行缓存信息的循环查询及相关统计。总之，这一套系统是非常方便的一套小规模的缓存系统，在日常开发中完全可以尝试用到一些小功能上。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/%E6%88%91%E4%BB%AC%E4%B9%9F%E6%9C%89%E8%87%AA%E5%B8%A6%E7%9A%84%E7%BC%93%E5%AD%98%E7%B3%BB%E7%BB%9F%EF%BC%9APHP%E7%9A%84APCu%E6%89%A9%E5%B1%95.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/%E6%88%91%E4%BB%AC%E4%B9%9F%E6%9C%89%E8%87%AA%E5%B8%A6%E7%9A%84%E7%BC%93%E5%AD%98%E7%B3%BB%E7%BB%9F%EF%BC%9APHP%E7%9A%84APCu%E6%89%A9%E5%B1%95.php)

参考文档：

[https://www.php.net/manual/zh/function.apcu-entry.php](https://www.php.net/manual/zh/function.apcu-entry.php)