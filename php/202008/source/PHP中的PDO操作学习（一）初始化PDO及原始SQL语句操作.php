<?php

print_r(PDO::getAvailableDrivers());
// Array
// (
//     [0] => dblib
//     [1] => mysql
//     [2] => odbc
//     [3] => pgsql
//     [4] => sqlite
// )

$dns = 'mysql:host=localhost;dbname=blog_test;port=3306;charset=utf8';
// https://www.php.net/manual/zh/ref.pdo-mysql.connection.php
$pdo = new PDO($dns, 'root', '', [PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC]);

showPdoAttribute($pdo);
// PDO::ATTR_DRIVER_NAME: mysql
// PDO::ATTR_AUTOCOMMIT: 1
// PDO::ATTR_ERRMODE: 0
// PDO::ATTR_CASE: 0
// PDO::ATTR_CLIENT_VERSION: mysqlnd 5.0.12-dev - 20150407 - $Id: 401a40ebd5e281cf22215acdc170723a1519aaa9 $
// PDO::ATTR_CONNECTION_STATUS: Localhost via UNIX socket
// PDO::ATTR_ORACLE_NULLS: 0
// PDO::ATTR_PERSISTENT: 

// PDO::ATTR_SERVER_INFO: Uptime: 176944  Threads: 1  Questions: 474  Slow queries: 0  Opens: 255  Flush tables: 1  Open tables: 233  Queries per second avg: 0.002
// PDO::ATTR_SERVER_VERSION: 5.7.17
// PDO::ATTR_TIMEOUT: 
$stmt = $pdo->query('select * from zyblog_test_user limit 5');
foreach ($stmt as $row) {
    var_dump($row);
}
exit;

$pdo = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
showPdoAttribute($pdo);
// ……
// PDO::ATTR_ERRMODE: 2
// ……

$pdo2 = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo $pdo2->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE), PHP_EOL;
// 4

$pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
echo $pdo2->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE), PHP_EOL;
// 2

// 显示pdo连接属性
function showPdoAttribute($pdo){
    $attributes = array(
        "DRIVER_NAME", "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
        "ORACLE_NULLS", "PERSISTENT", "SERVER_INFO", "SERVER_VERSION"
    );
    
    foreach ($attributes as $val) {
        echo "PDO::ATTR_$val: ";
        echo $pdo->getAttribute(constant("PDO::ATTR_$val")) . "\n";
    }
}

// 普通查询 - 遍历1
$stmt = $pdo->query('select * from zyblog_test_user limit 5');
foreach ($stmt as $row) {
    var_dump($row);
}

// array(8) {
//     ["id"]=>
//     string(3) "204"
//     [0]=>
//     string(3) "204"
//     ["username"]=>
//     string(5) "three"
//     [1]=>
//     string(5) "three"
//     ["password"]=>
//     string(6) "123123"
//     [2]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "ccc"
//     [3]=>
//     string(3) "ccc"
//   }
//   ……

echo '===============', PHP_EOL;
// 普通查询 - 遍历2
$stmt = $pdo->query('select * from zyblog_test_user limit 5');

while ($row = $stmt->fetch()) {
    var_dump($row);
}

// array(8) {
//     ["id"]=>
//     string(3) "204"
//     [0]=>
//     string(3) "204"
//     ["username"]=>
//     string(5) "three"
//     [1]=>
//     string(5) "three"
//     ["password"]=>
//     string(6) "123123"
//     [2]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "ccc"
//     [3]=>
//     string(3) "ccc"
//   }
//   ……

echo '===============', PHP_EOL;
// 返回数组格式


$stmt = $pdo2->query('select * from zyblog_test_user limit 5');
foreach ($stmt as $row) {
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_ASSOC);
foreach ($stmt as $row) {
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……



echo '===============', PHP_EOL;
// 返回对象格式
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_OBJ);
foreach ($stmt as $row) {
    var_dump($row);
}
// object(stdClass)#4 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

echo '===============', PHP_EOL;

class user
{
    public $id;
    public $username;
    public $password;
    public $salt;

    public function __construct()
    {
        echo 'func_num_args: ' . func_num_args(), PHP_EOL;
        echo 'func_get_args: ';
        var_dump(func_get_args());
    }
}

class user2
{

}
// 返回指定对象
$u = new user;
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_INTO, $u);
foreach ($stmt as $row) {
    var_dump($row);
}
// object(user)#3 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

// 空类测试
$u = new user2;
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_INTO, $u);
$resArr = []; // 注意引用问题
foreach ($stmt as $row) {
    var_dump($row);
    $resArr[] = $row;
    // $resArr[] = clone $row;
}

// object(user2)#2 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

$resArr[0]->id = 55555;
print_r($resArr);
// Array
// (
//     [0] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [1] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [2] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [3] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [4] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

// )

echo '===============', PHP_EOL;
// 根据类返回指定对象
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_CLASS, 'user', ['x1', 'x2']);
$resArr = [];
foreach ($stmt as $row) {
    var_dump($row);
    $resArr[] = $row;
}
$resArr[0]->id = 55555;
print_r($resArr);
// func_num_args: 2
// func_get_args: array(2) {
//   [0]=>
//   string(2) "x1"
//   [1]=>
//   string(2) "x2"
// }
// object(user)#4 (4) {
//   ["id"]=>
//   string(1) "5"
//   ["username"]=>
//   string(3) "two"
//   ["password"]=>
//   string(6) "123123"
//   ["salt"]=>
//   string(3) "bbb"
// }
// ……
echo '===============', PHP_EOL;

// 只返回第几个字段
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_COLUMN, 2);
foreach ($stmt as $row) {
    var_dump($row);
}
// string(32) "bbff8283d0f90625015256b742b0e694"
// string(6) "123123"
// string(6) "123123"
// string(6) "123123"
// string(6) "123123"

// 增、删、改语句
// 正常增加
$count = $pdo->exec("insert into zyblog_test_user(`username`, `password`, `salt`) value('akk', 'bkk', 'ckk')");
$id = $pdo->lastInsertId();

var_dump($count); // int(1)
var_dump($id); // string(3) "205"
echo '===============', PHP_EOL;
// 错误sql语句增加
// $count = $pdo->exec("insert into zyblog_test_user(`username`, `password`, `salt`) value('akk', 'bkk', 'ckk', 'dkk')");
// Fatal error: Uncaught PDOException: SQLSTATE[21S01]: Insert value list does not match column list: 1136 Column count doesn't match value count at row 1

// 正常更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='{$id}'");

var_dump($count); // int(1)

// 数据不变更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='{$id}'");
var_dump($count); // int(0)

// 条件错误更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='123123123123'");
var_dump($count); // int(0)
echo '===============', PHP_EOL;
// 删除
$count = $pdo->exec("delete from zyblog_test_user where id = '{$id}'");
var_dump($count); // int(1)

// 条件错误删除
$count = $pdo->exec("delete from zyblog_test_user where id = '5555555555'");
var_dump($count); // int(0)
