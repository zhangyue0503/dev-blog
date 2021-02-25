<?php

$conn = ftp_connect("192.168.56.102");

ftp_login($conn, 'testftp', '123456');

$pwdInfo = ftp_pwd($conn);
$dirInfo = ftp_nlist($conn, $pwdInfo);

print_r($pwdInfo); // /home/testftp
print_r($dirInfo);
// Array
// (
// )

ftp_close($conn);


$conn = ftp_connect("192.168.56.102");

ftp_login($conn, 'testftp', '123456');

ftp_mkdir($conn, 'www');
ftp_mkdir($conn, 'www1');
ftp_mkdir($conn, 'www2');

ftp_rename($conn, 'www1', 'www11');

ftp_rmdir($conn, 'www2');

print_r(ftp_nlist($conn, $pwdInfo));
// Array
// (
//     [0] => /home/testftp/www
//     [1] => /home/testftp/www11
// )

ftp_put($conn, '1.php', './1.学习一个PHP中用于检测危险函数的扩展Taint.php');

ftp_chdir($conn, 'www');
ftp_put($conn, '2.php', './2.一起学习PHP中的DS数据结构扩展（一）.php');
ftp_cdup($conn);

ftp_put($conn, 'www11/3.php', './3.一起学习PHP中的DS数据结构扩展（二）.php');

ftp_rename($conn, 'www/2.php', 'www/22.php');

print_r(ftp_rawlist($conn, '.'));
// Array
// (
//     [0] => -rw-r--r--    1 1003     1003         1785 Feb 24 01:09 1.php
//     [1] => drwxr-xr-x    2 1003     1003           20 Feb 24 01:09 www
//     [2] => drwxr-xr-x    2 1003     1003            6 Feb 24 00:51 www1
//     [3] => drwxr-xr-x    2 1003     1003           19 Feb 24 00:50 www11
// )
print_r(ftp_rawlist($conn, 'www'));
// Array
// (
//     [0] => -rw-r--r--    1 1003     1003        10538 Feb 24 01:09 22.php
// )
print_r(ftp_rawlist($conn, 'www11'));
// Array
// (
//     [0] => -rw-r--r--    1 1003     1003         1534 Feb 24 01:09 3.php
// )

echo ftp_mdtm($conn, 'www11/3.php'), PHP_EOL; // 1614128689

echo ftp_size($conn, 'www/22.php'), PHP_EOL; // 10538

echo ftp_systype($conn), PHP_EOL; // UNIX

ftp_get($conn, '222.php', 'www/22.php');
// ./222.php

ftp_delete($conn, 'www11/3.php');
print_r(ftp_rawlist($conn, 'www11'));
// Array
// (
// )


ftp_close($conn);