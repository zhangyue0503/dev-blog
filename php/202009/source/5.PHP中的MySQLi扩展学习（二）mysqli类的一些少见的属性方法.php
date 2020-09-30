<?php


$mysqli = new mysqli("localhost", "root", "", "blog_test");

// 切换用户
$mysqli->change_user('root2', "123", 'blog_test');

// 错误信息
$res = $mysqli->query( "SELECT * FROM zyblog_test_user");
var_dump($res); // bool(false)

var_dump($mysqli->error_list);
// array(1) {
//     [0]=>
//     array(3) {
//       ["errno"]=>
//       int(1142)
//       ["sqlstate"]=>
//       string(5) "42000"
//       ["error"]=>
//       string(78) "SELECT command denied to user 'root2'@'localhost' for table 'zyblog_test_user'"
//     }
//   }

var_dump($mysqli->errno); // int(1142)
var_dump($mysqli->error); // string(78) "SELECT command denied to user 'root2'@'localhost' for table 'zyblog_test_user'"

// 连接错误信息
$mysqli2 = @new mysqli("xxx", "root", "", "blog_test");
var_dump($mysqli2->connect_errno); // int(2002)
var_dump($mysqli2->connect_error); // string(90) "php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known"

// 客户端连接的统计数据
var_dump($mysqli->get_connection_stats());
// array(163) {
//     ["bytes_sent"]=>
//     string(3) "306"
//     ["bytes_received"]=>
//     string(3) "287"
//     ["packets_sent"]=>
//     string(2) "10"
//     ["packets_received"]=>
//     string(1) "6"
//     ["protocol_overhead_in"]=>
//     string(2) "24"
//     ["protocol_overhead_out"]=>
//     string(2) "40"
//     ["bytes_received_ok_packet"]=>
//     string(1) "0"
//     ["bytes_received_eof_packet"]=>
//     string(1) "0"
//     ……
//     ……
//     ["bytes_received_real_data_normal"]=>
//     string(1) "0"
//     ["bytes_received_real_data_ps"]=>
//     string(1) "0"
//   }

// 获取数据库字符
var_dump($mysqli->character_set_name()); // string(4) "utf8"
// 字符集详细信息
var_dump($mysqli->get_charset());
// object(stdClass)#2 (8) {
//     ["charset"]=>
//     string(4) "utf8"
//     ["collation"]=>
//     string(15) "utf8_general_ci"
//     ["dir"]=>
//     string(0) ""
//     ["min_length"]=>
//     int(1)
//     ["max_length"]=>
//     int(3)
//     ["number"]=>
//     int(33)
//     ["state"]=>
//     int(1)
//     ["comment"]=>
//     string(13) "UTF-8 Unicode"
//   }

$mysqli->set_charset('gbk');
$mysqli->query("insert into zyblog_test_user(username, password, salt) values('GBK字符','dd','d')");
var_dump($mysqli->error); // string(65) "Incorrect string value: '\xAC\xA6' for column 'username' at row 1"

$mysqli->set_charset('utf8');
$mysqli->query("insert into zyblog_test_user(username, password, salt) values('UTF字符','dd','d')");
var_dump($mysqli->error);
echo $mysqli->insert_id, PHP_EOL;

// 特殊字符转义
$username = "aaa ' bbb";
$username = $mysqli->real_escape_string($username);
var_dump($username); // string(10) "aaa \' bbb"

// 线程操作

var_dump($mysqli->thread_safe); // NULL

var_dump($mysqli->thread_id); // int(600)


$thread_id = $mysqli->thread_id;
$mysqli->kill($thread_id);

if (!$mysqli->query("insert into zyblog_test_user(username, password, salt) values('kill线程了','dd','d')")) {
    var_dump($mysqli->error); // string(26) "MySQL server has gone away"
}

var_dump($mysqli);
// object(mysqli)#1 (19) {
//     ["affected_rows"]=>
//     int(1)
//     ["client_info"]=>
//     string(79) "mysqlnd 5.0.12-dev - 20150407 - $Id: 7cc7cc96e675f6d72e5cf0f267f48e167c2abb23 $"
//     ["client_version"]=>
//     int(50012)
//     ["connect_errno"]=>
//     int(2002)
//     ["connect_error"]=>
//     string(90) "php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known"
//     ["errno"]=>
//     int(0)
//     ["error"]=>
//     string(0) ""
//     ["error_list"]=>
//     array(0) {
//     }
//     ["field_count"]=>
//     int(0)
//     ["host_info"]=>
//     string(25) "Localhost via UNIX socket"
//     ["info"]=>
//     NULL
//     ["insert_id"]=>
//     int(59)
//     ["server_info"]=>
//     string(6) "8.0.17"
//     ["server_version"]=>
//     int(80017)
//     ["stat"]=>
//     string(139) "Uptime: 355128  Threads: 4  Questions: 35696  Slow queries: 0  Opens: 764  Flush tables: 3  Open tables: 636  Queries per second avg: 0.100"
//     ["sqlstate"]=>
//     string(5) "00000"
//     ["protocol_version"]=>
//     int(10)
//     ["thread_id"]=>
//     int(606)
//     ["warning_count"]=>
//     int(0)
//   }
