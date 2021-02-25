<?php

// 上传文件
$file = "./1.学习一个PHP中用于检测危险函数的扩展Taint.php";

$ch = curl_init("http://localhost:9001");
$cfile = new CURLFile($file, 'text/plain', 'phpfile.php');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POST => 1,
    // CURLOPT_POSTFIELDS => ['a' =>' post测试', 'files' => curl_file_create($file, 'text/plain', 'phpfile.php')],
    CURLOPT_POSTFIELDS => ['a' => 'post测试', 'files' => $cfile],
]);

$res = curl_exec($ch);

curl_close($ch);

var_dump($res);
// string(244) "测试数据
// post测试
// Array
// (
//     [files] => Array
//         (
//             [name] => phpfile.php
//             [type] => text/plain
//             [tmp_name] => /private/tmp/phpvKyesy
//             [error] => 0
//             [size] => 1785
//         )

// )
// "

// 批量 CURL
$ch1 = curl_init();
$ch2 = curl_init();

curl_setopt($ch1, CURLOPT_URL, "https://www.baidu.com/");

curl_setopt($ch2, CURLOPT_URL, "http://localhost:9001");
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, ['a' => 'post测试']);

$mh = curl_multi_init();
curl_multi_add_handle($mh, $ch1);
curl_multi_add_handle($mh, $ch2);

$running=null;
do {
    sleep(2);
    curl_multi_exec($mh,$running);
    echo "============= ", $running, " =============", PHP_EOL;
} while ($running > 0);

curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_close($mh);

// ============= 2 =============
// ============= 2 =============
// ============= 2 =============
// 测试数据
// post测试
// ============= 2 =============
// ============= 1 =============
// <!DOCTYPE html><!--STATUS OK-->
// <html>
// <head>
// 	<meta http-equiv="content-type" content="text/html;charset=utf-8">
// 	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
// 	<link rel="dns-prefetch" href="//s1.bdstatic.com"/>
// 	<link rel="dns-prefetch" href="//t1.baidu.com"/>
// 	<link rel="dns-prefetch" href="//t2.baidu.com"/>
// 	<link rel="dns-prefetch" href="//t3.baidu.com"/>
// 	<link rel="dns-prefetch" href="//t10.baidu.com"/>
// 	<link rel="dns-prefetch" href="//t11.baidu.com"/>
// 	<link rel="dns-prefetch" href="//t12.baidu.com"/>
// 	<link rel="dns-prefetch" href="//b1.bdstatic.com"/>
// 	<title>百度一下，你就知道</title>
// ………………………………
// ………………………………
// ………………………………
// </body></html>
// ============= 0 =============


