# PHP的DBA扩展学习

今天我们讲的 DBA 并不是传统的数据库管理员那个 DBA ，而是一个 PHP 中的巴克利风格数据库的扩展。巴克利风格数据库其实就是我们常说的键值对形式的 K/V 数据库。就像我们平常用得非常多的 memcached 或者 redis 那样，只是一个键和一个值对应，不过 memcached 它们主要是存储在内存中，而 DBA 扩展则是将数据存储在文件中，就像一个简单的键值对形式的 SQLite 一样。

DBA 扩展所使用的数据库类型基本都是开源的，部署发布都很简单，就是一个 db 文件，所以说它和 SQLite 很相似。不过缺点就是，它会一次性将这个数据库文件加载到内存中，我们不能让这个数据库太大，否则就会撑爆内存。DBA 数据库都是和程序在一起的，所以它并没有网络相关的接口，我们一般也只会在代码本地使用这种数据库。

在安装的时候，我们需要在编译时增加 --enable-dba=shared 配置，然后还要增加一个 --enable-XXXX 配置，XXXX 指的就是我们要使用的巴克利风格数据库的类型，比较常见的有 dbm 、 ndbm 、 gdbm 、 db2 等等。同样的，操作系统也需要安装相关的这些软件，比如我们系统安装的就是 gdbm ，需要使用 yum install 

## 一个简单的例子

首先还是通过代码来看一下，我们的 DBA 数据库是如何使用的.

```php
// 打开一个数据库文件
$id = dba_open("/tmp/test.db", "n", "gdbm");
//$id = dba_popen("/tmp/test1.db", "c", "gdbm");

// 添加或替换一个内容
dba_replace("key1", "This is an example!", $id);

// 如果内容存在
if(dba_exists("key1", $id)){
    // 读取内容
    echo dba_fetch("key1", $id), PHP_EOL;
    // This is an example!
}

dba_close($id);
```

首先是使用 dba_open() 来打开一个数据库文件，第一个参数是数据库文件的路径，第二个参数是打开方式，包括 r 、 w 、 c 、 n ，r 表示只读，w 表示读写，c 表示创建加读写，n 表示如果没有就创建并可以读写。第三个参数就是指定的数据库类型，我们的系统中只安装了 gdbm 库，所以我们使用的就是 gdbm 作为参数。和 mysql 一样，我们也可以使用 dba_popen() 来打开一个数据文件的持久链接。

dba_replace() 函数则是添加或替换一条数据，如果数据不存在就新增加一条，如果存在了就替换对应 key 的值。第一个参数就是 key ，第二个参数就是数据的值 value 。

dba_exists() 就是判断指定的键是否存在，如果存在的话，我们在这个 if 里面就通过 dba_fetch() 获取键指定的数据。

dba_close() 就和其它数据操作句柄一样了，关闭数据库的连接句柄的。

## 添加、遍历、删除数据

在上面的例子中，我们使用的是 dba_replace() 来添加数据，其实正规的数据添加是有专门的函数的。

```php
// 添加数据
dba_insert("key2","This is key2!", $id);
dba_insert("key3","This is key3!", $id);
dba_insert("key4","This is key4!", $id);
dba_insert("key5","This is key5!", $id);
dba_insert("key6","This is key6!", $id);

// 获取第一个 key
$key = dba_firstkey($id);

$handle_later = [];
while ($key !== false) {
    if (true) {
        // 将 key 保存到数组中
        $handle_later[] = $key;
    }
    // 获取下一个 key
    $key = dba_nextkey($id);
}

// 遍历 key 数组，打印数据库中的全部内容
foreach ($handle_later as $val) {
    echo dba_fetch($val, $id), PHP_EOL;
    dba_delete($val, $id); // 删除key对应的内容
}
// This is key4!
// This is key2!
// This is key3!
// This is an example!
// This is key5!
// This is key6!
```

dba_insert() 就是插入数据，它不会去替换已经存在的键数据，如果是插入已经存在的键信息，就会返回 false 。

dba_firstkey() 用于获取第一个键，dba_nextkey() 用于获取下一个键，通过这两个函数，我们就可以获得整个数据库中的所有键信息，继而也就可以通过这些键来遍历整个数据库中的所有内容。

dba_delete() 就是根据键来删除一条数据了。

## 优化、同步数据库

即使是 mysql ，在长时间使用后，我们也需要进行一些整理优化的工作，比如让 mysql 自动整理文件碎片，整理索引等，它使用的 SQL 语句是：optimize 表名 。同理，DBA 扩展也为我们提供了这样一个函数。

```php
// 优化数据库
var_dump(dba_optimize($id)); // bool(true)
```

另外，就像 mysql 的缓存一样，DBA 在操作数据的时候也会进行缓存，这时我们可以使用一个函数将缓存中的数据强制刷入硬盘文件中。

```php
// 同步数据库
var_dump(dba_sync($id)); // bool(true)
```

## 当前打开的数据库列表

我们可能通过一个函数来查看当前打开的数据连接有哪些，因为 DBA 是基于文件的简单数据库，所以我们可以在一段代码中打开多个数据连接。

```php
// 获取当前打开的数据库列表
var_dump(dba_list());
// array(1) {
//     [4]=>
//     string(12) "/tmp/test.db"
//   }
```

## 系统所支持的数据库类型

最后，我们就来一个支持函数，它可以返回当前我们数据库所支持的数据库类型有哪些。

```php
// 当前支持的数据库类型
var_dump(dba_handlers(true));
// array(5) {
//     ["gdbm"]=>
//     string(58) "GDBM version 1.18. 21/08/2018 (built May 11 2019 01:10:11)"
//     ["cdb"]=>
//     string(53) "0.75, $Id: 841505a20a8c9c8e35cac5b5dc3d5cf2fe917478 $"
//     ["cdb_make"]=>
//     string(53) "0.75, $Id: 95b1c2518144e0151afa6b2b8c7bf31bf1f037ed $"
//     ["inifile"]=>
//     string(52) "1.0, $Id: 42cb3bb7617b5744add2ab117b45b3a1e37e7175 $"
//     ["flatfile"]=>
//     string(52) "1.0, $Id: 410f3405266f41bafffc8993929b8830b761436b $"
//   }

var_dump(dba_handlers(false));
// array(5) {
//     [0]=>
//     string(4) "gdbm"
//     [1]=>
//     string(3) "cdb"
//     [2]=>
//     string(8) "cdb_make"
//     [3]=>
//     string(7) "inifile"
//     [4]=>
//     string(8) "flatfile"
//   }
```

dba_handlers() 有一个布尔类型的参数，通过代码我们可以看出这个参数的作用就是返回信息的详细程度。

## 总结

今天介绍的是非常简单的一套数据库扩展组件，它的功能就是这些，在日常的生产环境中，实际的应用场景其实并不多。简单的键值对我们可以用 PHP 文件序列化来保存，而缓存则更多的会采用 memcached 之类的工具，所以大家了解一下即可。

测试代码：



参考文档：

[https://www.php.net/manual/zh/book.dba.php](https://www.php.net/manual/zh/book.dba.php)

[https://blog.csdn.net/weixin_40235225/article/details/84994384](https://blog.csdn.net/weixin_40235225/article/details/84994384)