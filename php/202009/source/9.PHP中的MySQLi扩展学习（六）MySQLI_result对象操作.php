<?php
$mysqli = new mysqli('localhost', 'root', '', 'blog_test');

$stmt = $mysqli->prepare("select * from zyblog_test_user where username = 'kkk'");

$stmt->execute(); // 执行语句
$result = $stmt->get_result();
var_dump($result);
// object(mysqli_result)#3 (5) {
//     ["current_field"]=>
//     int(0)
//     ["field_count"]=>
//     int(4)
//     ["lengths"]=>
//     NULL
//     ["num_rows"]=>
//     int(7)
//     ["type"]=>
//     int(0)
//   }

$result->fetch_array();
var_dump($result);
// ……
// ……
// ["lengths"]=>
//   array(4) {
//     [0]=>
//     int(0)
//     [1]=>
//     int(3)
//     [2]=>
//     int(3)
//     [3]=>
//     int(2)
//   }
// ……
// ……

// 全部数据
var_dump($result->fetch_all());
// array(7) {
//     [0]=>
//     array(4) {
//       [0]=>
//       int(42)
//       [1]=>
//       string(3) "kkk"
//       [2]=>
//       string(3) "666"
//       [3]=>
//       string(2) "k6"
//     }
//     ……
//     ……



$result->data_seek(0);
var_dump($result->fetch_all(MYSQLI_ASSOC));
// array(7) {
//     [0]=>
//     array(4) {
//       ["id"]=>
//       int(42)
//       ["username"]=>
//       string(3) "kkk"
//       ["password"]=>
//       string(3) "666"
//       ["salt"]=>
//       string(2) "k6"
//     }
//     ……
//     ……

$result->data_seek(0);
var_dump($result->fetch_array());
// array(8) {
//     [0]=>
//     int(42)
//     ["id"]=>
//     int(42)
//     [1]=>
//     string(3) "kkk"
//     ["username"]=>
//     string(3) "kkk"
//     [2]=>
//     string(3) "666"
//     ["password"]=>
//     string(3) "666"
//     [3]=>
//     string(2) "k6"
//     ["salt"]=>
//     string(2) "k6"
//   }

var_dump($result->fetch_array(MYSQLI_ASSOC));
// array(4) {
//     ["id"]=>
//     int(43)
//     ["username"]=>
//     string(3) "kkk"
//     ["password"]=>
//     string(3) "666"
//     ["salt"]=>
//     string(2) "k6"
//   }

$result->data_seek(0);
var_dump($result->fetch_assoc());
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

$result->data_seek(0);
var_dump($result->fetch_object());
// object(stdClass)#4 (4) {
//     ["id"]=>
//     int(42)
//     ["username"]=>
//     string(3) "kkk"
//     ["password"]=>
//     string(3) "666"
//     ["salt"]=>
//     string(2) "k6"
//   }

$result->data_seek(0);
class User
{
    public function __construct()
    {
        print_r(func_get_args());
    }
}
var_dump($result->fetch_object('User', [1, 2, 3]));
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
// )
// object(User)#4 (4) {
//     ["id"]=>
//     int(42)
//     ["username"]=>
//     string(3) "kkk"
//     ["password"]=>
//     string(3) "666"
//     ["salt"]=>
//     string(2) "k6"
//   }

var_dump($result->fetch_row());
// array(4) {
//     [0]=>
//     int(43)
//     [1]=>
//     string(3) "kkk"
//     [2]=>
//     string(3) "666"
//     [3]=>
//     string(2) "k6"
//   }



$result->data_seek(0);
while ($finfo = $result->fetch_field()) {
    var_dump($result->current_field);
    var_dump($finfo);
}
// int(1)
// object(stdClass)#4 (13) {
//     ["name"]=>
//     string(2) "id"
//     ["orgname"]=>
//     string(2) "id"
//     ["table"]=>
//     string(16) "zyblog_test_user"
//     ["orgtable"]=>
//     string(16) "zyblog_test_user"
//     ["def"]=>
//     string(0) ""
//     ["db"]=>
//     string(9) "blog_test"
//     ["catalog"]=>
//     string(3) "def"
//     ["max_length"]=>
//     int(0)
//     ["length"]=>
//     int(11)
//     ["charsetnr"]=>
//     int(63)
//     ["flags"]=>
//     int(49667)
//     ["type"]=>
//     int(3)
//     ["decimals"]=>
//     int(0)
//   }
// int(2)
//   object(stdClass)#5 (13) {
//     ["name"]=>
//     string(8) "username"
//     ["orgname"]=>
//     string(8) "username"
//     ……
//     ……

$result->field_seek(1);
while ($finfo = $result->fetch_field()) {
    var_dump($finfo);
}
// object(stdClass)#5 (13) {
//     ["name"]=>
//     string(8) "username"
//     ["orgname"]=>
//     string(8) "username"

var_dump($result->fetch_fields());
// array(4) {
//     [0]=>
//     object(stdClass)#5 (13) {
//       ["name"]=>
//       string(2) "id"
//       ["orgname"]=>
//       string(2) "id"
//       ["table"]=>
//       string(16) "zyblog_test_user"
//       ["orgtable"]=>
//       string(16) "zyblog_test_user"
//       ["def"]=>
//       string(0) ""
//       ["db"]=>
//       string(9) "blog_test"
//       ["catalog"]=>
//       string(3) "def"
//       ["max_length"]=>
//       int(0)
//       ["length"]=>
//       int(11)
//       ["charsetnr"]=>
//       int(63)
//       ["flags"]=>
//       int(49667)
//       ["type"]=>
//       int(3)
//       ["decimals"]=>
//       int(0)
//     }
//     [1]=>
//     object(stdClass)#4 (13) {
//       ["name"]=>
//       string(8) "username"

var_dump($result->fetch_field_direct(2));
// object(stdClass)#7 (13) {
//     ["name"]=>
//     string(8) "password"
//     ["orgname"]=>
//     string(8) "password"
//     ["table"]=>
//     string(16) "zyblog_test_user"
//     ["orgtable"]=>
//     string(16) "zyblog_test_user"
//     ["def"]=>
//     string(0) ""
//     ["db"]=>
//     string(9) "blog_test"
//     ["catalog"]=>
//     string(3) "def"
//     ["max_length"]=>
//     int(3)
//     ["length"]=>
//     int(765)
//     ["charsetnr"]=>
//     int(33)
//     ["flags"]=>
//     int(0)
//     ["type"]=>
//     int(253)
//     ["decimals"]=>
//     int(0)
//   }

$stmt->close();
