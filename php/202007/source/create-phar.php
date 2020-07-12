<?php

$srcRoot = "./myphar/src";
$buildRoot = "./myphar/build";
 
$phar = new Phar($buildRoot . "/myphar.phar", 
  FilesystemIterator::CURRENT_AS_FILEINFO |       FilesystemIterator::KEY_AS_FILENAME, "myphar.phar");
$phar["index.php"] = file_get_contents($srcRoot . "/index.php");
$phar["common.php"] = file_get_contents($srcRoot . "/common.php");
$phar->setStub($phar->createDefaultStub("index.php"));

copy($srcRoot . "/config.ini", $buildRoot . "/config.ini");


// 还是一个压缩工具
unlink('./my.phar');
unlink('./my.phar.bz2');
unlink('./my.phar.gz');
$p = new Phar('./my.phar', 0 ,'my.phar');
$p['myfile1.txt'] = 'hi1';
$p['myfile2.txt'] = 'hi2';
$p1 = $p->compress(Phar::GZ);
$p2 = $p->compress(Phar::BZ2);
unset($p);

$decompressPhar  = new Phar('./my.phar', 0 ,'my.phar');
foreach($decompressPhar as $file){
    // $file 是返回的 PharFileInfo 对象
    var_dump($file->getFileName());
    var_dump($file->isCompressed());
    var_dump($file->isCompressed(Phar::BZ2));
    var_dump($file->isCompressed(Phar::GZ));
    var_dump($file->getContent());
}
echo '==================', PHP_EOL;
// string(11) "myfile1.txt"
// bool(false)
// bool(false)
// bool(false)
// string(3) "hi1"
// string(11) "myfile2.txt"
// bool(false)
// bool(false)
// bool(false)
// string(3) "hi2"

unset($decompressPhar);

$p = new Phar('./my.phar', 0 ,'my.phar');
$p->compressFiles(Phar::GZ);
unset($p);

$decompressPhar  = new Phar('./my.phar.gz', 0 ,'my.phar');
foreach($decompressPhar as $file){
    // $file 是返回的 PharFileInfo 对象
    var_dump($file->getFileName());
    var_dump($file->isCompressed());
    var_dump($file->isCompressed(Phar::BZ2));
    var_dump($file->isCompressed(Phar::GZ));
    var_dump($file->getContent());
}
echo '==================', PHP_EOL;

// string(11) "myfile1.txt"
// bool(true)
// bool(false)
// bool(true)
// string(3) "hi1"
// string(11) "myfile2.txt"
// bool(true)
// bool(false)
// bool(true)
// string(3) "hi2"


$p = new PharData('./myData.tar');
$p['myfile1.txt'] = 'hi1';
$p['myfile2.txt'] = 'hi2';

foreach($p as $file){
    var_dump($file->getFileName());
    var_dump($file->isCompressed());
    var_dump($file->isCompressed(Phar::BZ2));
    var_dump($file->isCompressed(Phar::GZ));
    var_dump($file->getContent());
}
echo '==================', PHP_EOL;
// string(11) "myfile1.txt"
// bool(false)
// bool(false)
// bool(false)
// string(3) "hi1"
// string(11) "myfile2.txt"
// bool(false)
// bool(false)
// bool(false)
// string(3) "hi2"