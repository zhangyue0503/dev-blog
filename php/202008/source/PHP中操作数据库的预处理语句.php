<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=blog_test', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// :xxx 占位符
$stmt = $pdo->prepare("insert into zyblog_test_user (username, password, salt) values (:username, :password, :salt)");
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':salt', $salt);

$username = 'one';
$password = '123123';
$salt = 'aaa';
$stmt->execute();

$username = 'two';
$password = '123123';
$salt = 'bbb';
$stmt->execute();

// ? 占位符
$stmt = $pdo->prepare("insert into zyblog_test_user (username, password, salt) values (?, ?, ?)");
$stmt->bindParam(1, $username);
$stmt->bindParam(2, $password);
$stmt->bindParam(3, $salt);

$username = 'three';
$password = '123123';
$salt = 'ccc';
$stmt->execute();

// 查询获取数据
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

$stmt->execute(['username'=>'one']);

while($row = $stmt->fetch()){
    print_r($row);
}

// mysqli 预处理
$conn = new mysqli('127.0.0.1', 'root', '', 'blog_test');
$username = 'one';
$stmt = $conn->prepare("select username from zyblog_test_user where username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();

echo $stmt->bind_result($unames);

var_dump($unames);

while ($stmt->fetch()) {
    printf("%s\n", $unames);
}
