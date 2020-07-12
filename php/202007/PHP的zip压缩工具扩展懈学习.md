# PHP的zip压缩工具扩展懈学习

总算到了 PHP 的拿手好戏上场了，前面我们学习过 Bzip2 、 LZF 、 Phar 和 rar 这些压缩相关扩展在 PHP 中的使用，不过它们要么是太冷门，要么就是很多功能不支持。而 Zip 则是在 PHP 中得到最大幅度功能支持的热门压缩格式，或者说是通用常见的一种压缩格式。当然，也主要得益于 Zip 也是事实上的 Linux 环境中的通用压缩格式。

## 安装

对于 PHP 来说，Zip 扩展已经集成在了 PHP 的安装包中，在 Configure 的时候可以直接加上 --with-zip ，如果在安装的时候没有加上这个参数，我们也可以在源码包的 ext/zip 下找到源码，然后通过扩展安装的方式进行安装。

## 创建一个压缩包

```php
$zip = new ZipArchive();
$filename = './test_zip.zip';

if($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE){
        exit('cannot open ' . $filename .'\n');
}

// 加入文字类型的文件
$zip->addFromString('testfile1.txt' . time(), "#1");
$zip->addFromString('testfile2.txt' . time(), "#2");

// 加入已存在的文件
$zip->addFile('rar.php', 'newrar.php');

echo $zip->numFiles, PHP_EOL; // 文件数量
echo $zip->status, PHP_EOL; // 压缩包状态
$zip->close();

// 使用操作系统的 unzip 查看
// # unzip -l test_zip.zip
// Archive:  test_zip.zip
//   Length      Date    Time    Name
// ---------  ---------- -----   ----
//         2  07-08-2020 08:57   testfile1.txt1594169845
//         2  07-08-2020 08:57   testfile2.txt1594169845
//      2178  07-07-2020 08:55   newrar2.php
// ---------                     -------
//      2182                     3 files
```

之前学习过的 rar 扩展是无法打包文件或者创建新的压缩包的，而 Zip 一上来我们就学习的是创建一个新的压缩包。通过实例化一个 ZipArchive 对象后，我们就可以使用 open() 函数打开或创建一个压缩包文件。接着，我们使用了两种添加内容的方式。addFromString() 是加入文字类型的文件，也就是将一段文字转换成文本文件保存在这个压缩包中。另外，我们通过 addFIle() 来将外部的文件加入到这个压缩包中。

numFiles 和 status 属性可以分别查看到压缩包文件里面的文件数量及当前这个压缩包的状态信息。最后直接使用 close() 关闭句柄即可。这样，一个简单的 Zip 压缩包文件就创建完成了。我们直接使用操作系统的 unzip 命令来查看压缩包的内容。

## 读取压缩包内容及信息

```php
$zip = new ZipArchive();
$zip->open('./test_zip.zip');
print_r($zip); // 压缩包信息
// ZipArchive Object
// (
//     [status] => 0
//     [statusSys] => 0
//     [numFiles] => 40
//     [filename] => /data/www/blog/test_zip.zip
//     [comment] =>
// )
var_dump($zip);
// object(ZipArchive)#2 (5) {
//     ["status"]=>
//     int(0)
//     ["statusSys"]=>
//     int(0)
//     ["numFiles"]=>
//     int(40)
//     ["filename"]=>
//     string(27) "/data/www/blog/test_zip.zip"
//     ["comment"]=>
//     string(0) ""
//   }

echo $zip->numFiles, PHP_EOL;
echo $zip->status, PHP_EOL;
echo $zip->statusSys, PHP_EOL;
echo $zip->filename, PHP_EOL;
echo $zip->comment, PHP_EOL;
echo $zip->count(), PHP_EOL;

for ($i=0; $i<$zip->numFiles;$i++) {
    echo "index: $i\n";
    // 打印每个文件实体信息
    print_r($zip->statIndex($i));
    // index: 0
    // Array
    // (
    //     [name] => testfile1.txt1594169845
    //     [index] => 0
    //     [crc] => 2930664868
    //     [size] => 2
    //     [mtime] => 1594169844
    //     [comp_size] => 2
    //     [comp_method] => 0
    //     [encryption_method] => 0
    // )
    // ……

    $entry = $zip->statIndex($i);
    if($entry['name'] == 'newrar.php'){
        // 仅解压 newrar.php 文件到指定目录
        $zip->extractTo('./test_zip_single', $entry['name']);
    }
}

// 修改压缩包内的文件名
$zip->renameName('newrar.php', 'newrar2.php');
print_r($zip->getFromIndex(2)); // 获取第二个文件的内容
print_r($zip->getFromName('newrar2.php')); // 获取指定文件名的文件内容

$zip->extractTo('./test_zip'); // 解压整个压缩包到指定目录

$zip->close();
```

其实读取也是同样的步骤，实例化一个 ZipArchive 类，然后 open() 打开一个压缩包文件句柄。接着就可以直接输出一些压缩包的属性信息。我们可以通过循环并通过 statIndex() 方法获取每个文件实体的信息。这里需要注意的是 statIndex() 获取的是文件的信息，而不是这个文件的内容。

当然，我们也可以通过 getFromIndex() 或 getFromName() 直接获取指定的文件。通过 renameName() 直接给压缩包内部的文件改名，通过 extractTo() 将指定的文件或者整个压缩包解压到指定的目录中。extractTo() 方法的第二个参数如果指定了内容，则只会解压指定的这个文件。

## 压缩目录，设置说明以及流、伪协议方式读取文件

既然是压缩包工具，那么我们最常用的也就是直接将多个文件或者目录进行打包。同时，也有很多压缩包可以设置一些说明、密码什么的。另外，我们还可以通过专属的 zip:// 伪协议来直接获取压缩包内某个文件的内容。这些功能，在 PHP 的 Zip 扩展中都能够非常简单方便地使用。

### 压缩目录

```php
// 压缩目录
$zip = new ZipArchive();
$zip->open('./test_zip2.zip', ZIPARCHIVE::CREATE);
$zip->addFile('rar.php', 'newrar.php');
$zip->addGlob('./test_zip/*.{php,txt}', GLOB_BRACE, ['add_path'=> 'new_path/']);
```

直接使用 addGlob 就可以帮助我们完成对某个文件目录下的所有文件的内容打包。同时，它的第三个参数也可以指定这些文件在压缩包内部的路径地址。

### 设置说明及密码

```php
// 设置注释、密码
$zip->setArchiveComment('This is rar Comment!');
$zip->setPassword('123');
$zip->close();

// 使用操作系统 unzip 查看
// # unzip -l test_zip2.zip
// Archive:  test_zip2.zip
// This is rar Comment!
//   Length      Date    Time    Name
// ---------  ---------- -----   ----
//      2178  07-07-2020 08:55   newrar.php
//      2178  07-08-2020 10:36   new_path/./test_zip/newrar.php
//      2178  07-08-2020 10:36   new_path/./test_zip/newrar2.php
// ---------                     -------
//      6534                     3 files
```

设置压缩包的说明注释以及密码都是有现成的函数方法直接使用的。我们再次通过操作系统的 unzip 命令，就可以查看到这个压缩包的注释信息以及打包的目录内容。本来测试的 test_zip/ 目录下的内容被放在了 new_path/ 目录下，这就是我们自定的一个压缩包内部的路径地址。

### 流、伪协议方式读取文件

```php
// 流、伪协议方法读取压缩包内容
$zip = new ZipArchive();
$zip->open('./test_zip2.zip');

// 获取文件流
$fp = $zip->getStream('newrar.php');
while(!feof($fp)){
   echo fread($fp, 2);
}
fclose($fp);

// 使用伪协议
$fp = fopen('zip://' . dirname(__FILE__) . '/test_zip2.zip#newrar.php', 'r');
while(!feof($fp)){
   echo fread($fp, 2);
}
fclose($fp);

// file_get_contents 使用伪协议
echo file_get_contents('zip://' . dirname(__FILE__) . '/test_zip2.zip#newrar.php');

// 直接使用伪协议将文件拷贝出来
copy('zip://' . dirname(__FILE__) . '/test_zip2.zip#newrar.php', './newrar2.php');
```

首先，我们通过 getStream() 方法直接获取压缩包中某个文件的流，这种方式几乎是所有压缩类扩展都会提供的一种读取文件的方式。而下面的方式则是通过 zip:// 伪协议直接使用 fopen() 、 file_get_contents() 函数来读取压缩包内部的某个文件。既然有了这么方便的一个伪协议，那么我们要简单的获取并解压某个文件也就变得十分容易了，直接使用 copy() 函数将这个文件拷贝出来就可以了。

## 总结

是不是感觉比 rar 的操作强大了许多。都说了这是 PHP 主力支持的一种通用压缩格式，所以当然功能会丰富许多，而且还有很多的函数方法我们并没有全部列出来，如果全列出来的话还不如大家自己去看手册呢。这里就是以一些简单的例子让大家看到这类扩展功能的操作，方便大家在业务选型的时候能够快速的联想到我们 PHP 就已经提供了这些现成的扩展。需要了解 Zip 其它内容的同学可以移步最下方的链接直接进入手册中查阅。

测试代码：


参考文档：
[https://www.php.net/manual/zh/book.zip.php](https://www.php.net/manual/zh/book.zip.php)