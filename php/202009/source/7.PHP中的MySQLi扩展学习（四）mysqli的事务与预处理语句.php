<?php

$mysqli = new mysqli('localhost', 'root', '', 'blog_test');

// 使用异常处理错误情况
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

try {
    // 开始事务
    $mysqli->begin_transaction();

    $mysqli->query("insert into tran_innodb (name, age) values ('Joe', 12)");
    $mysqli->query("insert into tran_innodb2 (name, age) values ('Joe', 12)"); // 不存在的表

    // 提交事务
    $mysqli->commit();

} catch (Exception $e) {
    // 回滚事务
    $mysqli->rollback();

    var_dump($e->getMessage());
    // string(44) "Table 'blog_test.tran_innodb2' doesn't exist"
}

$stmt = $mysqli->prepare("select * from zyblog_test_user where username = ?");

var_dump($stmt);
$username = 'aaa';
$stmt->bind_param("s", $username); // 绑定参数
$stmt->execute(); // 执行语句
$aUser = $stmt->fetch(); // 获取mysqli_result结果集对象

$username='bbb';
$stmt->bind_param('s', $username);
$stmt->execute();
$bUser = $stmt->fetch();

var_dump($aUser);
// array(4) {
//     ["id"]=>
//     int(1)
//     ["username"]=>
//     string(3) "aaa"
//     ["password"]=>
//     string(3) "aaa"
//     ["salt"]=>
//     string(3) "aaa"
//   }

var_dump($bUser);
// array(4) {
//     ["id"]=>
//     int(2)
//     ["username"]=>
//     string(3) "bbb"
//     ["password"]=>
//     string(3) "bbb"
//     ["salt"]=>
//     string(3) "123"
//   }




$mysqli->close();
