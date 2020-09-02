<?php

$dns = 'mysql:host=localhost;dbname=blog_test;port=3306;charset=utf8';
$pdo = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// 使用 :name 形式创建一个只进游标的 PDOStatement 对象
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

var_dump($stmt);
// object(PDOStatement)#2 (1) {
//     ["queryString"]=>
//     string(57) "select * from zyblog_test_user where username = :username"
//   }

$stmt->execute([':username' => 'aaa']);
$aUser = $stmt->fetchAll();

$stmt->execute([':username' => 'bbb']);
$bUser = $stmt->fetchAll();

var_dump($aUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "1"
//       [0]=>
//       string(1) "1"
//       ["username"]=>
//       string(3) "aaa"
//       ……

var_dump($bUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "2"
//       [0]=>
//       string(1) "2"
//       ["username"]=>
//       string(3) "bbb"
//       ……

// 使用 ? 形式创建一个只进游标的 PDOStatement 对象
$stmt = $pdo->prepare("select * from zyblog_test_user where username = ?", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

$stmt->execute(['aaa']);
$aUser = $stmt->fetchAll();

var_dump($aUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "1"
//       [0]=>
//       string(1) "1"
//       ["username"]=>
//       string(3) "aaa"
//       ……

// ================
// 事务
$pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)"); // 成功插入

$pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)"); // 报错停止整个PHP脚本执行
// Fatal error: Uncaught PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.tran_innodb2' doesn't exist

try {
    // 开始事务
    $pdo->beginTransaction();

    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)"); // 不存在的表

    // 提交事务
    $pdo->commit();
} catch (Exception $e) {
    // 回滚事务
    $pdo->rollBack();
    // 输出报错信息
    echo "Failed: " . $e->getMessage(), PHP_EOL;
    // Failed: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.tran_innodb2' doesn't exist
}

// 如果没有事务被激活，抛出异常
$pdo->rollBack();
// Fatal error: Uncaught PDOException: There is no active transaction