<?php

var_dump(checkdnsrr("www.baidu.com", "A")); // bool(true)

var_dump(checkdnsrr("max.baidu.com", "A")); // bool(false)

var_dump(checkdnsrr("mail.baidu.com")); // bool(true)

$mxhosts = [];
getmxrr("baidu.com", $mxhosts);
var_dump($mxhosts);
// array(5) {
//     [0]=>
//     string(15) "mx.n.shifen.com"
//     [1]=>
//     string(14) "mx50.baidu.com"
//     [2]=>
//     string(13) "mx1.baidu.com"
//     [3]=>
//     string(14) "jpmx.baidu.com"
//     [4]=>
//     string(19) "mx.maillb.baidu.com"
//   }

var_dump(dns_get_record("baidu.com"));
// array(5) {
//     [0]=>
//     array(6) {
//       ["host"]=>
//       string(9) "baidu.com"
//       ["class"]=>
//       string(2) "IN"
//       ["ttl"]=>
//       int(4502)
//       ["type"]=>
//       string(2) "MX"
// …………………………
// …………………………
// …………………………
// …………………………


var_dump(gethostbyname("www.baidu.com")); // string(15) "183.232.231.174"
var_dump(gethostbyaddr("183.232.231.174")); // string(9) "localhost"

var_dump(gethostbynamel("www.baidu.com"));
// array(2) {
//     [0]=>
//     string(15) "183.232.231.174"
//     [1]=>
//     string(15) "183.232.231.172"
//   }

var_dump(gethostname()); // string(27) "zhangyuedeMacBook-Pro.local"

var_dump(ip2long('127.0.0.1')); // int(2130706433)
var_dump(long2ip(2130706433)); // string(9) "127.0.0.1"

var_dump(getprotobyname("tcp")); // int(6)
var_dump(getprotobynumber(6)); // string(3) "tcp"

$services = array('http', 'ftp', 'ssh', 'telnet', 'imap',
'smtp', 'nicname', 'gopher', 'finger', 'pop3', 'www');

foreach ($services as $service) {
    $port = getservbyname($service, 'tcp');
    echo $service . ": " . $port, PHP_EOL;
}
// http: 80
// ftp: 21
// ssh: 22
// telnet: 23
// imap: 143
// smtp: 25
// nicname: 43
// gopher: 70
// finger: 79
// pop3: 110
// www: 80

var_dump(getservbyport(80, 'tcp')); // string(4) "http"




// php -S localhost:8081 2.PHP中的网络组件相关函数.php

// 获取当前状态码，并设置新的状态码
// var_dump(http_response_code(404)); //  int(200)

// //获取新的状态码
// var_dump(http_response_code()); //  int(404)

// header("Test1: Info1");
// header("Test2: Info2");
// header("Test3: Info3");

// header_remove("Test2");

// var_dump(headers_list());
// // array(3) {
// //     [0]=>
// //     string(23) "X-Powered-By: PHP/7.3.9"
// //     [1]=>
// //     string(12) "Test1: Info1"
// //     [2]=>
// //     string(12) "Test3: Info3"
// //   }

setcookie("CK_TEST1", "Cookie1=?---&&f");
setrawcookie("CK_TEST2", "Cookie2=?---&&f");