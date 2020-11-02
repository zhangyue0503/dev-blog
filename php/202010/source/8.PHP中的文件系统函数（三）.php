<?php

$f = fopen('./test.txt', 'r+');

while (!feof($f)) {
    $contents = fread($f, 4);
    echo $contents, PHP_EOL;
}
// Rain
//  is
// fall
// ing
// all
// arou
// nd,

// It f
// alls
//  on
// ……
// ……

while (!feof($f)) {
    $contents = fread($f, 1024);
    echo $contents, PHP_EOL;
}
//

rewind($f);
while (!feof($f)) {
    $contents = fread($f, 1024);
    echo $contents, PHP_EOL;
}
// Rain is falling all around,
// It falls on field and tree,
// It rains on the umbrella here,
// And on the ships at sea.

rewind($f);
while (($c = fgetc($f)) !== false) {
    echo $c, PHP_EOL;
}
// R
// a
// i
// n

// i
// s

// f
// a
// ……
// ……

rewind($f);
while (($c = fgets($f)) !== false) {
    echo $c, PHP_EOL;
}
// Rain is falling all around,

// It falls on field and tree,

// It rains on the umbrella here,

// And on the ships at sea.

fclose($f);

// 中文测试
$f = fopen('./cn_test.txt', 'r+');

while (!feof($f)) {
    $contents = fread($f, 6);
    echo $contents, PHP_EOL;
}
// 我本
// 无为
// 野客
// ，飘
// 飘浪
// 迹人
// 间。

// 一�
// �被�
// ……
// ……

while (!feof($f)) {
    $contents = fread($f, 1024);
    echo $contents, PHP_EOL;
}
//

rewind($f);
while (!feof($f)) {
    $contents = fread($f, 1024);
    echo $contents, PHP_EOL;
}
// 我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。
// 流霞细酌咏诗篇。且与白云为伴。

rewind($f);
while (($c = fgetc($f)) !== false) {
    echo $c, PHP_EOL;
}
// �
// �
// �
// ……
// ……

rewind($f);
while (($c = fgets($f)) !== false) {
    echo $c, PHP_EOL;
}
// 我本无为野客，飘飘浪迹人间。

// 一时被命住名山。未免随机应变。

// 识破尘劳扰扰，何如乐取清闲。

// 流霞细酌咏诗篇。且与白云为伴。

fclose($f);

// fgetss
$f = fopen('./html_test.txt', 'r');
while (($c = fgetss($f)) !== false) {
    echo $c, PHP_EOL;
}
// PHP Deprecated:  Function fgetss() is deprecated
fclose($f);

// fgetcsv
$f = fopen('./csv_test.csv', 'r');
while (($c = fgetcsv($f)) !== false) {
    print_r($c);
}
// Array
// (
//     [0] => 49
//     [1] => 20
//     [2] => 0
//     [3] => 42
//     [4] => 5/10/2020 12:32:18
// )
// Array
// (
//     [0] => 50
//     [1] => 21
//     [2] => 0
//     [3] => 74
//     [4] => 5/10/2020 12:32:29
// )
// Array
// (
//     [0] => 51
//     [1] => 22
//     [2] => 0
//     [3] => 35.8
//     [4] => 5/10/2020 12:32:38
// )
// ……
// ……
fclose($f);

$f = fopen('./cn_test.txt', 'r+');

echo fgets($f), PHP_EOL;
// 我本无为野客，飘飘浪迹人间。

echo fpassthru($f), PHP_EOL;
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。
// 流霞细酌咏诗篇。且与白云为伴。

rewind($f);

fseek($f, 3 * 14 + 1);
echo fgets($f), PHP_EOL;
// 一时被命住名山。未免随机应变。

print_r(fstat($f));
// Array
// (
//     [0] => 16777220
//     [1] => 8708492112
//     [2] => 33188
//     [3] => 1
//     [4] => 501
//     [5] => 20
//     [6] => 0
//     [7] => 177
//     [8] => 1603414680
//     [9] => 1603414679
//     [10] => 1603414679
//     [11] => 4096
//     [12] => 8
//     [dev] => 16777220
//     [ino] => 8708492112
//     [mode] => 33188
//     [nlink] => 1
//     [uid] => 501
//     [gid] => 20
//     [rdev] => 0
//     [size] => 177
//     [atime] => 1603414680
//     [mtime] => 1603414679
//     [ctime] => 1603414679
//     [blksize] => 4096
//     [blocks] => 8
// )

rewind($f);
fseek($f, 14 * 2 * 3 + 1);
echo ftell($f), PHP_EOL; // 85

rewind($f);
// 文件会变
// ftruncate($f, 14*2*3+4);
echo fread($f, 8094), PHP_EOL;
// 我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
fclose($f);

$f = fopen("users_test.txt", "r");
while ($userinfo = fscanf($f, "%s\t%s\t%s\n")) {
    print_r($userinfo);
}
// Array
// (
//     [0] => javier
//     [1] => argonaut
//     [2] => pe
// )
// Array
// (
//     [0] => hiroshi
//     [1] => sculptor
//     [2] => jp
// )
// Array
// (
//     [0] => robert
//     [1] => slacker
//     [2] => us
// )
// Array
// (
//     [0] => luigi
//     [1] => florist
//     [2] => it
// )
fclose($f);

$handle = popen("/bin/ls", "r");
while(!feof($handle)){
    echo fgets($handle);
}
pclose($handle);
// 1.PHP中的日期相关函数（三）.php
// 2.学习PHP中的目录操作.php
// 3.学习PHP中的高精度计时器HRTime扩展.php
// 4.PHP中DirectIO直操作文件扩展的使用.php
// 5.学习PHP中Fileinfo扩展的使用.php
// 6.PHP中的文件系统函数（一）.php
// 7.PHP中的文件系统函数（二）.php
// 8.PHP中的文件系统函数（三）.php
// cn_test.txt
// csv_test.csv
// html_test.txt
// test.txt
// timg.jpeg
// users_test.txt
// write.txt

// 写入
$f = fopen('write.txt', 'w');
fwrite($f, "This is Test!\n");
fputs($f, "This is Test2!!\n");
$csv = [['id', 'name'],[1, 'Zyblog'], [2, '硬核项目经理']];
foreach($csv as $v){
    fputcsv($f, $v);
}
fclose($f);
// This is Test!
// This is Test2!!
// id,name
// 1,Zyblog
// 2,硬核项目经理





var_dump(fnmatch('*fall[ing]*', file_get_contents('./test.txt'))); // bool(true)

$fp = fopen("/tmp/lock.txt", "w+");

if (flock($fp, LOCK_EX)) { // 进行排它型锁定
    fwrite($fp, "写入数据：" . date('H:i:s') . "\n");
    if(!$argv[1]){
        sleep(50);
    }
    fflush($fp); // 释放锁之前刷新缓冲区
    flock($fp, LOCK_UN); // 释放锁定
} else {
    echo "无法获得锁，不能写入！";
}

fclose($fp);




