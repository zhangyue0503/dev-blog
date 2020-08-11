<?php

/* 创建压缩包 */
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

/* 读取解压 */
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

/* 其它操作 */
// 压缩目录
$zip = new ZipArchive();
$zip->open('./test_zip2.zip', ZIPARCHIVE::CREATE);
$zip->addFile('rar.php', 'newrar.php');
$zip->addGlob('./test_zip/*.{php,txt}', GLOB_BRACE, ['add_path'=> 'new_path/']);

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



