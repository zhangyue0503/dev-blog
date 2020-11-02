# PHP的bz2压缩扩展工具

在日常的开发和电脑使用中，我们经常会接触到压缩和解压的一些工具，PHP 也为我们准备了很多相关的操作扩展包，都有直接可用的函数能够方便的操作一些压缩解压功能。今天，我们先学习一个比较简单但不太常用的压缩格式：Bzip2。

## 安装扩展

这个扩展的安装需要系统有 bzip2-devel 。所以我们需要先给系统装上这个软件包的支持，然后这个扩展是随 PHP 安装包一起发布的，所以只需要编译一下 PHP ，并在 ./configure 中添加对应的编译命令即可。

```shell
# yum install bzip2-devel
# ./configure xxxx --with-bz2
# make && make install
```

## 基本操作

Bzip2 提供的函数不多，而且非常简单，我们首先来看的是将字符串保存到一个文件中。

```php
$bz = bzopen('/tmp/test.bz', 'w');
// -rw-r--r-- 1 root root 14 Jun 28 09:51 test.bz

$text = "This is Bz Compress";
bzwrite($bz, $text);
// -rw-r--r-- 1 root root 59 Jun 28 09:53 test.bz

bzclose($bz);

$bz = bzopen('/tmp/test.bz', 'r');

$v = bzread($bz);
echo $v, PHP_EOL;
// This is Bz Compress

bzclose($bz);
```

就和文件操作函数一样，我们需要先通过 bzopen() 打开文件获得句柄。然后使用 bzwrite() 来写入文件，并使用 bzread() 来读取文件。最后使用 bzclose() 来关闭文件。

这里需要注意的是 bzopen() 的第二个参数，也就是文件打开的形式，只能写 "w" 或者 "r" 。它没有其它类型，并且不能同时读写，也就是不能写成 "wr" 这种形式。所以我们在写完文件后又要再使用 "r" 打开文件才能进行读取。

### 读取长度设置

```php
$bz = bzopen('/tmp/test.bz', 'r');

$v = bzread($bz, 10);
echo $v, PHP_EOL;
// This is Bz

$v = bzread($bz);
echo $v, PHP_EOL;
//  Compress

bzclose($bz);
```

bzread() 的第二个参数是可选的字节长度，默认是 1024 ，一次最大可读入 8192 个未压缩字节。

## 字符串编码

Bzip2 扩展还为我们提供了直接对字符串编码的函数。不用每次都存入文件中，如果是相同的字符串，使用字符串编码的函数和输出到文件中的内容是一样的乱码的二进制内容。

```php
$str = "Test compress String";

$bzstr = bzcompress($str, 9);
echo $bzstr, PHP_EOL;
// BZh91AY&SY��J���@
//
// �� 1
// df����2�h>.�p�!��//

$newStr = bzdecompress($bzstr);
echo $newStr, PHP_EOL;

$chineseStr = "测试";
$bzstr = bzcompress($chineseStr, 9);
echo bzdecompress($bzstr), PHP_EOL;
```

bzcompress() 用于将字符串进行编码压缩，第二个参数是压缩的比率，9 为最高等级。编码后的内容是非人类的二进制乱码内容。bzdecompress() 用于对已编码的内容进行解码。相信不少小伙伴已经发现了，这个可以用来做一些保密内容的加密传输。同时，在测试代码中，我们可以看到，它对中文也是正常支持的。

## 错误信息

最后，我们来看一下 Bzip2 的错误处理函数。

```php
$bz = bzopen('/tmp/test.bz', 'r');
bzwrite($bz, 'aaa');
print_r(bzerror($bz));
// Array
// (
//     [errno] => -1
//     [errstr] => SEQUENCE_ERROR
// )

echo bzerrno($bz), PHP_EOL; // -1
echo bzerrstr($bz), PHP_EOL; // SEQUENCE_ERROR

bzclose($bz);
```

我们首先构造了一个错误环境。使用 "r" 打开文件获得句柄后，对这个文件进行写入操作。bzerror() 会返回一个错误信息的数组，里面包含了错误号和错误信息内容。而 bzerrno() 和 bzerrstr() 则是单独地分别返回错误号和错误内容。三个非常简单并且好理解的函数。

## 总结

这个扩展还是非常简单的，最主要的是 Bzip2 这种压缩文件类型也并不是非常常用的类型，所以可能知道的人并不多。但是我们还是从中发现了一丝丝的惊喜，就是它提供了字符串的编解码函数，这两个函数确实是可以在某些场景下作为信息加密的手段来使用。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/PHP%E7%9A%84Bzip2%E5%8E%8B%E7%BC%A9%E6%89%A9%E5%B1%95%E5%B7%A5%E5%85%B7.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/PHP%E7%9A%84Bzip2%E5%8E%8B%E7%BC%A9%E6%89%A9%E5%B1%95%E5%B7%A5%E5%85%B7.php)

参考文档：

[https://www.php.net/manual/zh/book.bzip2.php](https://www.php.net/manual/zh/book.bzip2.php)