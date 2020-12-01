# PDO操作大数据对象

一般在数据库中，我们保存的都只是 int 、 varchar 类型的数据，一是因为现代的关系型数据库对于这些内容会有很多的优化，二是大部分的索引也无法施加在内容过多的字段上，比如说 text 类型的字段就很不适合创建索引。所以，我们在使用数据库时，很少会向数据库中存储很大的内容字段。但是，MySQL 其实也为我们准备了这种类型的存储，只是我们平常用得不多而已。今天我们就来学习了解一下使用 PDO 如何操作 MySQL 中的大数据对象。

## 什么是大数据对象

*“大”通常意味着“大约 4kb 或以上”，尽管某些数据库在数据达到“大”之前可以轻松地处理多达 32kb 的数据。大对象本质上可能是文本或二进制形式的，我们在 PDOStatement::bindParam() 或 PDOStatement::bindColumn() 调用中使用 PDO::PARAM_LOB 类型码可以让 PDO 使用大数据类型。PDO::PARAM_LOB 告诉 PDO 作为流来映射数据，以便能使用 PHP Streams API 来操作。*

对于 MySQL 来说，将字段类型设置为 blob 即是大对象格式的字段。而在 bindParam() 或 bindColumn() 时，指定字段的参数为 PDO::PARAM_LOB 类型，就可以直接以句柄形式获得这个对象里面的内容，就像 fopen() 一样地继续对它进行操作。

```SQL
CREATE TABLE `zy_blob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attach` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
```

这是我们测试用的一个数据表，将 attach 字段设置为了 longblob 类型，也就是比较大的 blob 类型，这样我们就可以存储更多地信息。毕竟现在的图片或文件随随便便就是轻松地几m或几十m起步的，我们直接使用最大的 blob 类型来进行简单地测试。tinyblob 的大小为 255 字节，blob 类型的大小为 65k ，mediumblob 为 16M ，longblob 为 4G 。

## 直接操作大数据对象会怎么样？

我们先来简单地直接操作大数据对象，看看是什么样的结果。

```php
$stmt = $pdo->prepare("insert into zy_blob (attach) values (?)");
$fp = fopen('4960364865db53dcb33bcf.rar', 'rb');
$stmt->execute([$fp]);

$stmt = $pdo->query("select attach from zy_blob where id=1");
$file = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($file); 
// Array
// (
//     [attach] => Resource id #6
// )
```

在这段代码中，我们没有绑定字段，然后直接将 fopen() 打开的文件存储到 blob 字段中。可以看出，在数据库中，blob 相关的字段只是存储了 Resource id #6 这样的字符串。也就是说，在不做任何处理的情况下，$fp 句柄被强制转换成了字符串类型，而句柄类型被强转的结果就是只会输出一个资源ID，而 blob 也只是和字符类型的字段一样记录了这个字符串而已。

## 正确的姿势

接下来我们来看看正确的姿势，也就是通过 bindParam() 来插入数据，通过 bindColumn() 来读取数据。

```php
$stmt = $pdo->prepare("insert into zy_blob (attach) values (?)");

$fp = fopen('4960364865db53dcb33bcf.rar', 'rb');

$stmt->bindParam(1, $fp, PDO::PARAM_LOB); // 绑定参数类型为 PDO::PARAM_LOB
$stmt->execute();

$stmt = $pdo->prepare("select attach from zy_blob where id=2");
// // $file = $stmt->fetch(PDO::FETCH_ASSOC);
// // print_r($file); // 空的
$stmt->execute();
$stmt->bindColumn(1, $file, PDO::PARAM_LOB); // 绑定一列到一个 PHP 变量
$stmt->fetch(PDO::FETCH_BOUND); // 指定获取方式，返回 TRUE 且将结果集中的列值分配给通过 PDOStatement::bindParam() 或 PDOStatement::bindColumn() 方法绑定的 PHP 变量
print_r($file); // 二进制乱码内容
$fp = fopen('a.rar', 'wb');
fwrite($fp, $file);
```

首先，我们通过 bindParam() 绑定数据，并指定 PDO::PARAM_LOB 类型之后，就正常地向数据库里插入了文件的句柄二进制内容。接着，我们使用 bindColumn() 并且也指定 PDO::PARAM_LOB 类型来获得查询出来的数据。直接打印查询出来的字段信息，就可以看到它是二进制的类型内容。最后，我们将这个二进制内容保存成另一个名称的文件。

大家可以替换上面的文件内容，然后执行代码来看看最后生成的文件是不是和原来的文件一样的。我这里使用的是一个压缩包文件，最后生成的 a.rar 文件和原始文件大小以及解压后的内容都是完全一致的。

## 总结

大数据对象操作的究竟是什么呢？其实就是我们平常要保存的大文件。我们将这些文件以二进制流的方式读取到程序后，再将它们保存在数据库的字段中。想想我们平常开发用到的最多的图片保存就可以用这个来做。但是，此处可以划重点了，我们更加推荐的还是将文件直接保存在文件目录中，而数据库中只保存它们的路径就可以了。数据库资源是宝贵的，表越大越不利于优化，而且数据库本身还有缓存机制，浪费它的资源来保存这种大型的文件其实是得不偿失的。当然，如果有某些特殊的需要，比如一些私密文件不想直接在硬盘文件目录中保存，或者做为临时的跨服务器存储方案都是可以的。

在现代开发中，相信你的公司也不会吝啬到不去买一个云存储（七牛、upyun、阿里云OSS）。它们不仅仅是能够做为一个存储器、网盘，而是有更多的功能，比如图片的裁剪、水印，赠送的 CDN 、带宽 、 流量之类的，总之，现代的存储大家还是尽量上云吧，即使是个人开发，也有不少厂商会提供小流量小数据量情况下的免费使用，这个都比我们自己来要方便很多。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/PDO%E6%93%8D%E4%BD%9C%E5%A4%A7%E6%95%B0%E6%8D%AE%E5%AF%B9%E8%B1%A1.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/PDO%E6%93%8D%E4%BD%9C%E5%A4%A7%E6%95%B0%E6%8D%AE%E5%AF%B9%E8%B1%A1.php)

参考文档：

[https://www.php.net/manual/zh/pdo.lobs.php](https://www.php.net/manual/zh/pdo.lobs.php)