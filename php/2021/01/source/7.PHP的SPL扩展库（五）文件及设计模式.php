<?php

$file = new SplFileInfo('./6.PHP的SPL扩展库（四）函数.php');

// 文件路径信息

var_dump($file->getBasename());
// string(39) "6.PHP的SPL扩展库（四）函数.php"

var_dump($file->getPathname());
// string(41) "./6.PHP的SPL扩展库（四）函数.php"

var_dump($file->getFilename());
// string(39) "6.PHP的SPL扩展库（四）函数.php"

var_dump($file->getRealPath());
// string(102) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/01/source/6.PHP的SPL扩展库（四）函数.php"

var_dump($file->getPathInfo());
// object(SplFileInfo)#2 (2) {
//     ["pathName":"SplFileInfo":private]=>
//     string(1) "."
//     ["fileName":"SplFileInfo":private]=>
//     string(1) "."
//   }

var_dump($file->getFileInfo());
// object(SplFileInfo)#2 (2) {
//     ["pathName":"SplFileInfo":private]=>
//     string(41) "./6.PHP的SPL扩展库（四）函数.php"
//     ["fileName":"SplFileInfo":private]=>
//     string(39) "6.PHP的SPL扩展库（四）函数.php"
//   }

// 文件属性信息

var_dump($file->getExtension());
// string(3) "php"

var_dump($file->getType());
// string(4) "file"

var_dump($file->getCTime());
// int(1611017967)

var_dump($file->getOwner());
// int(501)

var_dump($file->getGroup());
// int(20)

var_dump($file->getSize());
// int(3543)

// 文件判断

var_dump($file->isReadable());
// bool(true)

var_dump($file->isWritable());
// bool(true)

var_dump($file->isDir());
// bool(false)

var_dump($file->isFile());
// bool(true)

var_dump($file->isLink());
// bool(false)

// 文件操作

$txt1 = new SplFileObject('7.1.txt', 'a+');
$txt1->fwrite(date('Y-m-d H:i:s' . PHP_EOL));
// 71.txt
// 2021-01-20 09:03:15
// ……
// ……

// 读取
$txt1->seek(0);
var_dump($txt1->fread($txt1->getSize()));
// string(80) "2021-01-20 09:03:15
// "

$txt1->seek(0);
while(!$txt1->eof()){
    var_dump($txt1->fgets());
}
// string(20) "2021-01-20 09:03:15
// "
// string(20) "2021-01-20 09:03:16
// "
// ……
// ……

foreach($txt1 as $t){
    var_dump($t);
}
// string(20) "2021-01-20 09:03:15
// "
// string(20) "2021-01-20 09:03:16
// "
// ……
// ……

// 操作临时文件
$tmp = new SplTempFileObject(0);

$tmp->fwrite("tmp:" . date('Y-m-d H:i:s'));

$tmp->rewind();
foreach ($tmp as $line) {
    var_dump($line);
}
// string(23) "tmp:2021-01-20 09:14:34"

sleep(10);
// vim /tmp/phpRhgsVZ
// tmp:2021-01-20 09:14:34

// 目录迭代器

foreach (new DirectoryIterator('./') as $fileInfo) {
    if($fileInfo->isDot()) continue;
    if($fileInfo->isDir()){
        echo "dir: " . $fileInfo->getFilename() , PHP_EOL;
    }else{
        echo "file: " . $fileInfo->getFilename() , PHP_EOL;
    }
}

// file: 2.学习了解PHP中的SeasLog日志扩展.php
// dir: autoloadA
// file: 7.1.txt
// file: 6.PHP的SPL扩展库（四）函数.php
// file: 1.PHP中的一些杂项函数学习.php
// file: browscap.ini
// file: 7.PHP的SPL扩展库（四）文件及设计模式.php
// file: 3.PHP的SPL扩展库（一）数据结构.php
// file: 4.PHP的SPL扩展库（二）对象数组与数组迭代器.php
// file: 1.txt
// dir: autoloadB
// file: 5.PHP的SPL扩展库（三）迭代器.php



