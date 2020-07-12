<?php

$arch = RarArchive::open("test.rar");

$archNo = rar_open("test.rar");

echo $arch, PHP_EOL; // RAR Archive "/data/www/blog/test.rar"
echo $archNo, PHP_EOL; // RAR Archive "/data/www/blog/test.rar"

$arch->close();
rar_close($archNo);

echo $arch, PHP_EOL; // RAR Archive "/data/www/blog/test.rar" (closed)
echo $archNo, PHP_EOL; // RAR Archive "/data/www/blog/test.rar" (closed)

echo '==========================================', PHP_EOL;

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

echo '==========================================', PHP_EOL;

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
// 将文件解压到了当前目录下

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

$arch->close();
rar_close($archNo);

echo '==========================================', PHP_EOL;

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
