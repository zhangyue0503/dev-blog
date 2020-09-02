<?php

// pdo
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');
// print_r($pdo->query('SELECT * FROM zyblog_test_user'));


$stmt = $pdo->prepare('SELECT * FROM zyblog_test_user');
$stmt->execute();
$stmt->closeCursor(); // 
// $stmt = null; // 
$pdo = null;

// mysqli
// $conn = new mysqli('127.0.0.1', 'root', '', 'blog_test');

// $result = $conn->query('SELECT * FROM zyblog_test_user');
// $stmt = $conn->prepare("SELECT * FROM zyblog_test_user");
// $stmt->execute();

// $conn->close();

// show full processlist;

sleep(60);


