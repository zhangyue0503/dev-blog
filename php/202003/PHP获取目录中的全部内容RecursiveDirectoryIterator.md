# PHP获取目录中的全部内容RecursiveDirectoryIterator

这次我们来介绍一个SPL库中的目录迭代器，它的作用其实非常简单，从名字就可以看出来，就是获取指定目录下的所有内容。之前我们要遍历目录获取目录及目录下的所有文件一般是需要进行递归遍历的，自己写这个代码说实话还是挺麻烦的，所以PHP为我们准备好了这一套内置API，当输入指定的目录后，直接返回该目录下所有子目录及文件内容。当然，并不是树型的，顺序并不一定，想要组织成树型还需要我们自己再进行处理。

话不多说，直接看代码：

```php
$path = $argv[1];

// 获取目录下所有内容
$dirs = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);

foreach($dirs as $k=>$d){
    echo 'key:'. $k, PHP_EOL;
    if($d->isDir()){
        echo $d->getPathname(), PHP_EOL;
    }else{
        echo $d->getFilename(), PHP_EOL;
    }
}

//执行 php PHP获取目录中的全部内容RecursiveDirectoryIterator.php ../

// key:../.
// ../.
// key:../..
// ../..
// key:../source
// ../source
// key:../source/.
// ../source/.
// key:../source/..
// ../source/..
// key:../source/PHP获取目录中的全部内容RecursiveDirectoryIterator.php
// PHP获取目录中的全部内容RecursiveDirectoryIterator.php
// key:../source/PHP大文件读取操作.php
// PHP大文件读取操作.php
// key:../PHP大文件读取操作.md
// PHP大文件读取操作.md
// key:../PHP获取目录中的全部内容RecursiveDirectoryIterator.md
// PHP获取目录中的全部内容RecursiveDirectoryIterator.md

```

其实就一行代码，然后直接循环输出这个迭代器。从结果中我们可以看出，先进入 source 目录遍历完成后再遍历外部的文件内容，按照目录、文件名的顺序依次获取了目录下的所有内容。是不是比我们自己写递归函数要方便很多。

如果我们想获取目录下的所有PHP文件，并且计算他们的文件总大小呢？使用这一套迭代器操作也可以非常简单的完成，我们只需要增加一个正则迭代器对前面的迭代器内容进行一下过滤就好了：

```php
// 获取所有php文件
$regIts = new RegexIterator($dirs, '/^.+\.php$/i');
$fileSize = 0;
foreach($regIts as $k=>$p){
    echo $p->getSize() . ' ' .  $k, PHP_EOL;
    $fileSize += $p->getSize();
}
echo 'Total ', $fileSize, PHP_EOL;

// 622 ../source/PHP获取目录中的全部内容RecursiveDirectoryIterator.php
// 869 ../source/PHP大文件读取操作.php
// Total 1491
```

感觉就和 ls -l 一样，可以方便的让我们能够进行目录下的相关操作。这个类的使用就简单的介绍到这里，关于SPL库中还有许多值得我们探索的能力，慢慢学习慢慢实践，不断提升我们面向优雅编程的能力。

测试代码：

参考文档：
《PHP7编程实战》
[https://www.php.net/manual/en/class.recursivedirectoryiterator.php](https://www.php.net/manual/en/class.recursivedirectoryiterator.php)
[https://www.php.net/manual/en/class.splfileinfo.php](https://www.php.net/manual/en/class.splfileinfo.php)
