<?php

echo "1) ".basename("/etc/sudoers.d", ".d"), PHP_EOL;
echo "2) ".basename("/etc/passwd"), PHP_EOL;
echo "3) ".basename("/etc/"), PHP_EOL;
echo "4) ".basename("."), PHP_EOL;
echo "5) ".basename("/"), PHP_EOL;
echo "6) ".basename("/usr/local/Cellar/php/7.3.9_1/README.md"), PHP_EOL;
// 1) sudoers
// 2) passwd
// 3) etc
// 4) .
// 5) 
// 6) README.md

echo "1) " . dirname("/etc/passwd") , PHP_EOL;
echo "2) " . dirname("/etc/") , PHP_EOL;
echo "3) " . dirname("."), PHP_EOL;
// 1) /etc
// 2) /
// 3) .

print_r(pathinfo('/usr/local/Cellar/php/7.3.9_1/README.md'));
// Array
// (
//     [dirname] => /usr/local/Cellar/php/7.3.9_1
//     [basename] => README.md
//     [extension] => md
//     [filename] => README
// )

echo realpath('./../../..//../etc/passwd'), PHP_EOL;
// /private/etc/passwd

touch('test3.txt');

echo fileowner('test.txt'), PHP_EOL; // 501
chown('test.txt', 'www');
clearstatcache();
echo fileowner('test.txt'), PHP_EOL; // 70

echo filegroup('test.txt'), PHP_EOL; // 20
chgrp('test.txt', 'www');
clearstatcache();
echo filegroup('test.txt'), PHP_EOL; // 70

echo substr(sprintf('%o', fileperms('test.txt')), -4), PHP_EOL; // 0766
chmod('test.txt', 0777);
clearstatcache();
echo substr(sprintf('%o', fileperms('test.txt')), -4), PHP_EOL; // 0777

print_r(stat('test.txt'));
// Array
// (
//     [0] => 16777220
//     [1] => 8707958352
//     [2] => 33279
//     [3] => 2
//     [4] => 70
//     [5] => 70
//     [6] => 0
//     [7] => 0
//     [8] => 1603070453
//     [9] => 1603070453
//     [10] => 1603072836
//     [11] => 4096
//     [12] => 0
//     [dev] => 16777220
//     [ino] => 8707958352
//     [mode] => 33279
//     [nlink] => 2
//     [uid] => 70
//     [gid] => 70
//     [rdev] => 0
//     [size] => 0
//     [atime] => 1603070453
//     [mtime] => 1603070453
//     [ctime] => 1603072836
//     [blksize] => 4096
//     [blocks] => 0
// )



link('test.txt', 'ltest.txt');
echo linkinfo('ltest.txt'), PHP_EOL; // 16777220

symlink('test.txt', 'ltest2.txt');
echo linkinfo('ltest2.txt'), PHP_EOL; // 16777220

print_r(lstat('ltest2.txt'));
// Array
// (
//     [0] => 16777220
//     [1] => 8707962848
//     [2] => 41453
//     [3] => 1
//     [4] => 0
//     [5] => 20
//     [6] => 0
//     [7] => 8
//     [8] => 1603072717
//     [9] => 1603072717
//     [10] => 1603072717
//     [11] => 4096
//     [12] => 0
//     [dev] => 16777220
//     [ino] => 8707962848
//     [mode] => 41453
//     [nlink] => 1
//     [uid] => 0
//     [gid] => 20
//     [rdev] => 0
//     [size] => 8
//     [atime] => 1603072717
//     [mtime] => 1603072717
//     [ctime] => 1603072717
//     [blksize] => 4096
//     [blocks] => 0
// )

lchown('ltest2.txt', 'zhangyue');
lchgrp('ltest2.txt', 'staff');
// lrwxr-xr-x  1 zhangyue  staff      8 Oct 19 09:58 ltest2.txt -> test.txt