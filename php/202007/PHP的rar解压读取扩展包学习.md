# PHP的rar解压读取扩展包学习

作为压缩解压方面的扩展学习，两大王牌压缩格式 rar 和 zip 一直是计算机领域的压缩终结者。rar 格式的压缩包是 Windows 系统中有接近统治地位的存在，今天我们学习的 PHP 扩展就是针对于 rar 的压缩包操作，不过，PHP 的 rar 扩展仅能读取和解压 rar 格式的压缩包，并不能进行压缩操作。

php-rar 扩展在 pecl 的安装包已经过时了，无法在 PHP7 中使用，我们需要使用它在 github 上的源码进行编译安装才能够在 PHP7 的环境下安装成功。

[https://github.com/cataphract/php-rar](https://github.com/cataphract/php-rar)

直接 git clone 之后就可以按正常的 PHP 扩展的方式进行安装。

## 获取压缩包句柄 RarArchive

```php
$arch = RarArchive::open("test.rar");

$archNo = rar_open("test.rar");

echo $arch, PHP_EOL; // RAR Archive "/data/www/blog/test.rar"
echo $archNo, PHP_EOL; // RAR Archive "/data/www/blog/test.rar"

$arch->close();
rar_close($archNo);

echo $arch, PHP_EOL; // RAR Archive "/data/www/blog/test.rar" (closed)
echo $archNo, PHP_EOL; // RAR Archive "/data/www/blog/test.rar" (closed)
```

php-rar 扩展有两种形式的写法，一种是面向对象的，也就是使用 RarArchive 类来操作压缩包。另一种方式就是直接使用一个函数 rar_open 用来获取一个 rar 文件的句柄。它们都重写了 __toString 方法，所以我们可以直接打印句柄的内容看到当前句柄所操作的具体文件。

当我们关闭句柄时，句柄对象依然能够进行输出，但后面会显示一个 closed 。这时的句柄对象已经不能进行其它操作了。

```php
$arch = RarArchive::open("test.rar");
$archNo = rar_open("test.rar");

echo $arch->getComment(), PHP_EOL;
echo $arch->isBroken(), PHP_EOL;
echo $arch->isSolid(), PHP_EOL;

echo rar_comment_get($archNo), PHP_EOL;
echo rar_broken_is($archNo), PHP_EOL;
echo rar_solid_is($archNo), PHP_EOL;

echo $arch->setAllowBroken(true), PHP_EOL;
echo rar_allow_broken_set($archNo, true), PHP_EOL;
```

RarArchive 对象的一些方法可以帮我们获取当前压缩包的信息。比如 getComment() 获取压缩包的说明信息，isBroken() 获取当前压缩包是否有损坏，isSolid() 检查当前压缩包是否可用。而 setAllowBroken() 方法是让我们允许对损坏的压缩包进行操作。这里我们给出了面向对象和面向过程的写法。

## 压缩包内的每个实体文件或目录操作 RarEntry

获得压缩包的句柄之后，我们就需要更进一步地获取压缩包内部的内容。而句柄对象中就已经保存了压缩包内部的各个文件和目录的对象 RarEntry 。

```php
$gameEntry = $arch->getEntry('ldxlcs/ldxlcs/game.htm');
echo $gameEntry->getName(), PHP_EOL; // ldxlcs/ldxlcs/game.htm
echo $gameEntry->getUnpackedSize(), PHP_EOL; // 56063

$gameEntryNo = rar_entry_get($arch, "ldxlcs/ldxlcs/game.htm");
echo $gameEntry->getName(), PHP_EOL; // ldxlcs/ldxlcs/game.htm
echo $gameEntry->getUnpackedSize(), PHP_EOL; // 56063

$fp = $gameEntryNo->getStream();
while (!feof($fp)) {
    $buff = fread($fp, 8192);
    if ($buff !== false) {
        echo $buff;
    } else {
        break;
    }
    //fread error
}
// 输出文件的全部内容
echo PHP_EOL;

echo 'Entry extract: ', $gameEntry->extract("./"), PHP_EOL;

```

句柄对象的 getEntry() 方法就是用于获取指定的文件或者目录内容的。它获取的是单个文件或目录，所以必须明确地指定需要获取的文件内容。通过这个方法，我们可以拿到一个 RarEntry 对象。接下来，就是这个对象的一些操作。

RarEntry 对象的 getName() 方法用于获取文件名称，这个文件名称是带路径的，这个路径是压缩包内的绝对路径。getUnpackedSize() 方法用于获取文件的大小，getStream() 用于获取文件流，通过 getStream() 方法，我们就可以直接打印输出文件的内容。

当然，最最重要的是，我们可以通过 extract() 方法来直接解压一个文件到指定的目录。php-rar 扩展并没有提供一个能够完全地解压整个压缩包的方法，所以如果我们需要对整个压缩包进行解压的话，就需要通过循环遍历压缩包内部的全部内容来对这些文件一个一个地进行解压。

最后，我们就来看看如何遍历压缩包内的全部内容。

```php
$entries = $arch->getEntries();

foreach ($entries as $en) {
    echo $en, PHP_EOL;
    echo $en->getName(), PHP_EOL;
    echo $en->getUnpackedSize(), PHP_EOL;
    echo $en->getAttr(), PHP_EOL;
    echo $en->getCrc(), PHP_EOL;
    echo $en->getFileTime(), PHP_EOL;
    echo $en->getHostOs(), PHP_EOL;
    echo $en->getMethod(), PHP_EOL;
    echo $en->getPackedSize(), PHP_EOL;
    echo $en->getVersion(), PHP_EOL;
    echo $en->isDirectory(), PHP_EOL;
    echo $en->isEncrypted(), PHP_EOL;

}

// 压缩包中所有文件的内容
// RarEntry for file "ldxlcs/ldxlcs/game.htm" (3c19abf6)
// ldxlcs/ldxlcs/game.htm
// 56063
// 32
// 3c19abf6
// 2017-09-10 13:25:04
// 2
// 51
// 7049
// 200
// ……

$entriesNo = rar_list($archNo);
foreach ($entriesNo as $en) {
    echo $en->getName(), PHP_EOL;
}
```

直接使用的是 RarArchive 对象的 getEntries() 方法，我们通过这个方法可以获得一个 RarEntry 对象的数组，里面包含的就是这个 rar 压缩包里面的全部内容。在这段代码中，我们还打印了 RarEntry 对象的其它一些属性方法，根据名称也能大概了解这些方法都是获取关于文件的各种信息的，大家可以自行测试。

## 异常处理

最后，如果打开错了文件或者获取压缩包内部没有的文件时，php-rar 扩展会以 PHP 错误的形式报错。但既然提供了完整的面向对象写法，那么它也必然提供了一套面向对象的异常处理机制。

```php
// 不打开 UsingExceptions 全部错误会走 PHP 错误机制，打开后走 PHP 的异常机制
RarException::setUsingExceptions(true);
var_dump(RarException::isUsingExceptions()); // bool(true)
try {
    $arch = RarArchive::open("test1.rar");
    $arch->getEntry('ttt.txt');
} catch (RarException $e) {
    var_dump($e);
    // object(RarException)#35 (7) {
    //     ["message":protected]=>
    //     string(91) "unRAR internal error: Failed to open /data/www/blog/test1.rar: ERAR_EOPEN (file open error)"
    //     ["string":"Exception":private]=>
    //     string(0) ""
    //     ["code":protected]=>
    //     int(15)
    //     ["file":protected]=>
    //     string(22) "/data/www/blog/rar.php"
    //     ["line":protected]=>
    //     int(93)
    //     ["trace":"Exception":private]=>
    //     array(1) {
    //       [0]=>
    //       array(6) {
    //         ["file"]=>
    //         string(22) "/data/www/blog/rar.php"
    //         ["line"]=>
    //         int(93)
    //         ["function"]=>
    //         string(4) "open"
    //         ["class"]=>
    //         string(10) "RarArchive"
    //         ["type"]=>
    //         string(2) "::"
    //         ["args"]=>
    //         array(1) {
    //           [0]=>
    //           string(9) "test1.rar"
    //         }
    //       }
    //     }
    //     ["previous":"Exception":private]=>
    //     NULL
    //   }
}
```

只要将 RarException::setUsingExceptions() 设置为 true ，就能够开启 php-rar 扩展的异常处理机制，这时，我们打开一个错误的文件，或者去获取压缩包内的一个错误文件路径，那么，错误信息就会以异常的形式进行抛出。

## 总结

这套扩展是不是感觉很人性化？即提供了面向对象的方式，也提供了以函数操作为主的面向过程的方式。但是，这样做其实并没有太多的好处，因为又要兼顾老代码，又要兼顾新思想，本身扩展的内部实现相必也会复杂很多。我们自己写代码的时候就尽量不要这么写了，在重构的时候一步步的向最新的形式迁移即可。

关于 rar 的压缩操作并没有找到太多有用的资料。当然，我们在生产环境中如果要生成压缩包的话大部分情况下都会直接去生成 zip 格式的提供给用户，毕竟大部分的客户端软件都是能够同时支持 rar 和 zip 格式文件的解压的，如果一定要指定生成 rar 的话，也可以多多和产品经理或者客户商量。有的时候，技术的难点是可以通过业务的变通来解决的，最重要的其实还是在于沟通。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84rar%E8%A7%A3%E5%8E%8B%E8%AF%BB%E5%8F%96%E6%89%A9%E5%B1%95%E5%8C%85%E5%AD%A6%E4%B9%A0.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84rar%E8%A7%A3%E5%8E%8B%E8%AF%BB%E5%8F%96%E6%89%A9%E5%B1%95%E5%8C%85%E5%AD%A6%E4%B9%A0.php)

参考文档：
[https://www.php.net/manual/zh/book.rar.php](https://www.php.net/manual/zh/book.rar.php)