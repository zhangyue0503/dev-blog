<?php

$mysqli = new mysqli();
$mysqli->real_connect("localhost", "root", "", "blog_test");

var_dump($mysqli); 
// ["thread_id"]=>
// int(163)

$mysqli->real_connect("localhost", "root2", "123", "blog_test");
var_dump($mysqli);
// ["thread_id"]=>
// int(164)
$mysqli->select_db('mysql');



$mysqli = new mysqli("localhost", "root", "", "blog_test");

$mysqli->query("insert into zyblog_test_user(username, password, salt) values('3a', '3a', '3a')");
var_dump($mysqli->affected_rows);

$mysqli->query("update zyblog_test_user set password='3aa' where username='3a'");
var_dump($mysqli->affected_rows);

$mysqli->query("delete from zyblog_test_user where id = 60");
var_dump($mysqli->affected_rows);

$res = $mysqli->query("select * from zyblog_test_user where username='3a'");
print_r($res);
// mysqli_result Object
// (
//     [current_field] => 0
//     [field_count] => 4
//     [lengths] =>
//     [num_rows] => 3
//     [type] => 0
// )

print_r($res->fetch_assoc());
// Array
// (
//     [id] => 61
//     [username] => 3a
//     [password] => 3aa
//     [salt] => 3a
// )

while ($row = $res->fetch_assoc()) {
    print_r($row);
}
// Array
// (
//     [id] => 62
//     [username] => 3a
//     [password] => 3aa
//     [salt] => 3a
// )
// Array
// (
//     [id] => 63
//     [username] => 3a
//     [password] => 3aa
//     [salt] => 3a
// )
// ……

$sql = "insert into zyblog_test_user(username, password, salt) values('3bb', '3bb', '3bb');"
        . "update zyblog_test_user set password='3aa' where username='3a';"
        . "select * from zyblog_test_user where username='3b';"
        . "select now()";

$pdo = new PDO("mysql:dns=locahost;dbname=blog_test", 'root', '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$res = $pdo->exec($sql);
var_dump($res); // int(1)
// $stmt = $pdo->query($sql);
// foreach ($stmt as $row) { //PHP Fatal error:  Uncaught PDOException: SQLSTATE[HY000]: General error in
//     var_dump($row);
// }



$mysqli->multi_query($sql);
$i = 1;
do{
    echo '第' . $i . '条：', PHP_EOL;
    $i++;
    $result = $mysqli->use_result();
    var_dump($result);
    var_dump($mysqli->affected_rows);
    if(is_object($result)){
        var_dump($result->fetch_assoc());
    }
    var_dump($mysqli->next_result());
    echo '========', PHP_EOL;
    
}
while($mysqli->more_results() );
// 第1条：
// bool(false)
// int(1)
// ========
// 第2条：
// bool(false)
// int(0)
// ========
// 第3条：
// object(mysqli_result)#2 (5) {
//   ["current_field"]=>
//   int(0)
//   ["field_count"]=>
//   int(4)
//   ["lengths"]=>
//   NULL
//   ["num_rows"]=>
//   int(0)
//   ["type"]=>
//   int(1)
// }
// int(-1)
// array(4) {
//   ["id"]=>
//   string(2) "67"
//   ["username"]=>
//   string(2) "3b"
//   ["password"]=>
//   string(2) "3b"
//   ["salt"]=>
//   string(2) "3b"
// }
// ========
// 第4条：
// bool(false)
// int(0)
// ========


$mysqli = new mysqli("localhost", "root", "", "blog_test");

$mysqli->multi_query($sql);
$i = 1;
do{
    echo '第' . $i . '条：', PHP_EOL;
    $i++;
    $result = $mysqli->store_result();
    var_dump($result);
    var_dump($mysqli->affected_rows);
    if(is_object($result)){
        var_dump($result->fetch_assoc());
    }
    var_dump($mysqli->next_result());
    echo '========', PHP_EOL;
}
while($mysqli->more_results() );
// 第1条：
// bool(false)
// int(1)
// ========
// 第2条：
// bool(false)
// int(0)
// ========
// 第3条：
// object(mysqli_result)#1 (5) {
//   ["current_field"]=>
//   int(0)
//   ["field_count"]=>
//   int(4)
//   ["lengths"]=>
//   NULL
//   ["num_rows"]=>
//   int(7)
//   ["type"]=>
//   int(0)
// }
// int(7)
// array(4) {
//   ["id"]=>
//   string(2) "67"
//   ["username"]=>
//   string(2) "3b"
//   ["password"]=>
//   string(2) "3b"
//   ["salt"]=>
//   string(2) "3b"
// }
// ========
// 第4条：
// object(mysqli_result)#3 (5) {
//   ["current_field"]=>
//   int(0)
//   ["field_count"]=>
//   int(1)
//   ["lengths"]=>
//   NULL
//   ["num_rows"]=>
//   int(1)
//   ["type"]=>
//   int(0)
// }
// int(1)
// array(1) {
//   ["now()"]=>
//   string(19) "2020-09-14 10:31:37"
// }

