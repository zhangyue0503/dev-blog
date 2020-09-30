<?php

$mysqli = new mysqli('localhost', 'root', '', 'blog_test');


$stmt = $mysqli->prepare("insert into zyblog_test_user(username, password, salt) values(?, ?, ?)");

$username='mysqli_username';
$password='mysqli_password';
$salt = 'mysqli_salt';
$stmt->bind_param('sss', $username, $password, $salt);
$stmt->execute();

var_dump($stmt->insert_id); // int(232)
var_dump($stmt->affected_rows); // int(1)

$stmt->close();

$stmt = $mysqli->prepare("insert into zyblog_test_user(id, username, password, salt) values(?, ?, ?, ?)");

$id = 's';
$username='mysqli_username';
$password='mysqli_password';
$salt = 'mysqli_salt';
$stmt->bind_param('isss', $username, $password, $salt);
$stmt->execute();


var_dump($stmt->errno); // int(2031)
var_dump($stmt->error); // string(53) "No data supplied for parameters in prepared statement"
var_dump($stmt->error_list);
// array(1) {
//     [0]=>
//     array(3) {
//       ["errno"]=>
//       int(2031)
//       ["sqlstate"]=>
//       string(5) "HY000"
//       ["error"]=>
//       string(53) "No data supplied for parameters in prepared statement"
//     }
//   }

$stmt->close();


$stmt = $mysqli->prepare("select * from zyblog_test_user where username = ?");

$username = 'kkk';
$stmt->bind_param("s", $username); // 绑定参数
$stmt->bind_result($col1, $col2, $col3, $col4);
$stmt->execute(); // 执行语句

var_dump($stmt);
// object(mysqli_stmt)#2 (10) {
//     ["affected_rows"]=>
//     int(-1)
//     ["insert_id"]=>
//     int(0)
//     ["num_rows"]=>
//     int(0)
//     ["param_count"]=>
//     int(1)
//     ["field_count"]=>
//     int(4)
//     ["errno"]=>
//     int(0)
//     ["error"]=>
//     string(0) ""
//     ["error_list"]=>
//     array(0) {
//     }
//     ["sqlstate"]=>
//     string(5) "00000"
//     ["id"]=>
//     int(3)
//   }

while($stmt->fetch()){
    printf("%s %s %s %s", $col1, $col2, $col3, $col4);
    echo PHP_EOL;
}
// 42 kkk 666 k6
// 43 kkk 666 k6
// ……

var_dump($stmt->num_rows); // int(7)

$stmt->close();


$stmt = $mysqli->prepare("select * from zyblog_test_user where username = 'kkk'");

$stmt->execute(); // 执行语句
$result = $stmt->get_result();


while($row = $result->fetch_assoc()){
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     int(42)
//     ["username"]=>
//     string(3) "kkk"
//     ["password"]=>
//     string(3) "666"
//     ["salt"]=>
//     string(2) "k6"
//   }
// ……

$stmt->close();

$stmt = $mysqli->prepare("select * from zyblog_test_user where username = 'kkk'");

$stmt->bind_result($col1, $col2, $col3, $col4);
$stmt->execute(); // 执行语句
$stmt->store_result();
// 一共7条，从第5个开始
$stmt->data_seek(5);
$stmt->fetch();
printf("%s %s %s %s", $col1, $col2, $col3, $col4); // 47 kkk 666 k6
echo PHP_EOL;


$stmt->close();


