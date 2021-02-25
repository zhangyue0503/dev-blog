<?php


// GET 请求
$ch = curl_init("https://www.baidu.com");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 信任任何证书

$res = curl_exec($ch);
$info = curl_getinfo($ch);
if(curl_error($ch)) {
    var_dump(curl_error($ch));
}

var_dump($res);
// string(14722) "<!DOCTYPE html><!--STATUS OK-->
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
//  ……………………
//  ……………………
//  ……………………
// </body></html>
// "

var_dump($info);
// array(37) {
//     ["url"]=>
//     string(21) "https://www.baidu.com"
//     ["content_type"]=>
//     string(9) "text/html"
//     ["http_code"]=>
//     int(200)
//     ["header_size"]=>
//     int(960)
//     ["request_size"]=>
//     int(52)
//     ["filetime"]=>
//     int(-1)
//     ["ssl_verify_result"]=>
//     int(0)
//     ["redirect_count"]=>
//     int(0)
//     ["total_time"]=>
//     float(0.127654)
//     ["namelookup_time"]=>
//     float(0.004669)
//     ["connect_time"]=>
//     float(0.030823)
//     ["pretransfer_time"]=>
//     float(0.100782)
//     ["size_upload"]=>
//     float(0)
//     ["size_download"]=>
//     float(14722)
//     ["speed_download"]=>
//     float(115921)
//     ["speed_upload"]=>
//     float(0)
//     ["download_content_length"]=>
//     float(14722)
//     ["upload_content_length"]=>
//     float(-1)
//     ["starttransfer_time"]=>
//     float(0.127519)
//     ["redirect_time"]=>
//     float(0)
//     ["redirect_url"]=>
//     string(0) ""
//     ["primary_ip"]=>
//     string(15) "183.232.231.172"
//     ["certinfo"]=>
//     array(0) {
//     }
//     ["primary_port"]=>
//     int(443)
//     ["local_ip"]=>
//     string(13) "192.168.51.11"
//     ["local_port"]=>
//     int(52795)
//     ["http_version"]=>
//     int(2)
//     ["protocol"]=>
//     int(2)
//     ["ssl_verifyresult"]=>
//     int(0)
//     ["scheme"]=>
//     string(5) "HTTPS"
//     ["appconnect_time_us"]=>
//     int(100710)
//     ["connect_time_us"]=>
//     int(30823)
//     ["namelookup_time_us"]=>
//     int(4669)
//     ["pretransfer_time_us"]=>
//     int(100782)
//     ["redirect_time_us"]=>
//     int(0)
//     ["starttransfer_time_us"]=>
//     int(127519)
//     ["total_time_us"]=>
//     int(127654)
//   }

curl_close($ch);


// POST 请求
$ch = curl_init("http://localhost:9001");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt_array($ch, [
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => ['a'=>'post测试'],
]);

$res = curl_exec($ch);
$info = curl_getinfo($ch);
if(curl_error($ch)) {
    var_dump(curl_error($ch));
}

var_dump($res);
// string(22) "测试数据post测试"

curl_close($ch);

$ch = curl_init("http://localhost:9001");
$str = "测试编码";
$escapeStr = curl_escape($ch, $str);
var_dump($escapeStr); // string(36) "%E6%B5%8B%E8%AF%95%E7%BC%96%E7%A0%81"
var_dump(curl_unescape($ch, $escapeStr)); // string(12) "测试编码"
curl_close($ch);

var_dump(curl_version());
// array(16) {
//     ["version_number"]=>
//     int(475648)
//     ["age"]=>
//     int(5)
//     ["features"]=>
//     int(11519901)
//     ["ssl_version_number"]=>
//     int(0)
//     ["version"]=>
//     string(6) "7.66.0"
//     ["host"]=>
//     string(25) "x86_64-apple-darwin19.5.0"
//     ["ssl_version"]=>
//     string(14) "OpenSSL/1.1.1d"
//     ["libz_version"]=>
//     string(6) "1.2.11"
//     ["protocols"]=>
//     array(23) {
//       [0]=>
//       string(4) "dict"
//       [1]=>
//       string(4) "file"
//       [2]=>
//       string(3) "ftp"
//       [3]=>
//       string(4) "ftps"
//       [4]=>
//       string(6) "gopher"
//       [5]=>
//       string(4) "http"
//       [6]=>
//       string(5) "https"
//       [7]=>
//       string(4) "imap"
//       [8]=>
//       string(5) "imaps"
//       [9]=>
//       string(4) "ldap"
//       [10]=>
//       string(5) "ldaps"
//       [11]=>
//       string(4) "pop3"
//       [12]=>
//       string(5) "pop3s"
//       [13]=>
//       string(4) "rtmp"
//       [14]=>
//       string(4) "rtsp"
//       [15]=>
//       string(3) "scp"
//       [16]=>
//       string(4) "sftp"
//       [17]=>
//       string(3) "smb"
//       [18]=>
//       string(4) "smbs"
//       [19]=>
//       string(4) "smtp"
//       [20]=>
//       string(5) "smtps"
//       [21]=>
//       string(6) "telnet"
//       [22]=>
//       string(4) "tftp"
//     }
//     ["ares"]=>
//     string(6) "1.15.0"
//     ["ares_num"]=>
//     int(69376)
//     ["libidn"]=>
//     string(5) "2.2.0"
//     ["iconv_ver_num"]=>
//     int(0)
//     ["libssh_version"]=>
//     string(13) "libssh2/1.9.0"
//     ["brotli_ver_num"]=>
//     int(16777223)
//     ["brotli_version"]=>
//     string(5) "1.0.7"
//   }




