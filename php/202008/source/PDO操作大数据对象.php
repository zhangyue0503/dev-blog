<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=blog_test', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


// 不正确
// $stmt = $pdo->prepare("insert into zy_blob (attach) values (?)");
// $fp = fopen('4960364865db53dcb33bcf.rar', 'rb');
// echo $fp;
// $stmt->execute([$fp]);

// $stmt = $pdo->query("select attach from zy_blob where id=1");
// $file = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($file); 
// Array
// (
//     [attach] => Resource id #6
// )

// 使用 PARAM_LOB 表示 SQL 中大对象数据类型
$stmt = $pdo->prepare("insert into zy_blob (attach) values (?)");

$fp = fopen('4960364865db53dcb33bcf.rar', 'rb');

$stmt->bindParam(1, $fp, PDO::PARAM_LOB); // 绑定参数类型为 PDO::PARAM_LOB
$stmt->execute();

$stmt = $pdo->prepare("select attach from zy_blob where id=2");
// // $file = $stmt->fetch(PDO::FETCH_ASSOC);
// // print_r($file); // 空的
$stmt->execute();
$stmt->bindColumn(1, $file, PDO::PARAM_LOB); // 绑定一列到一个 PHP 变量
$stmt->fetch(PDO::FETCH_BOUND); // 指定获取方式，返回 TRUE 且将结果集中的列值分配给通过 PDOStatement::bindParam() 或 PDOStatement::bindColumn() 方法绑定的 PHP 变量

$fp = fopen('a.rar', 'wb');
fwrite($fp, $file);