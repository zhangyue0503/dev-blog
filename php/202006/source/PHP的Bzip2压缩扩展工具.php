<?php

// yum install bzip2-devel
// ./configure xxxx --with-bz2

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


$bz = bzopen('/tmp/test.bz', 'r');

$v = bzread($bz, 10);
echo $v, PHP_EOL;
// This is Bz

$v = bzread($bz);
echo $v, PHP_EOL;
//  Compress

bzclose($bz);

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