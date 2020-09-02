<?php

// $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test1', 'root', '');
// Fatal error: Uncaught PDOException: SQLSTATE[HY000] [1049] Unknown database 'blog_test1' 

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');
$pdo->query('select * from aabbcc');
var_dump($pdo->errorCode());
// string(5) "42S02"

var_dump($pdo->errorInfo());
// array(3) {
//   [0]=>
//   string(5) "42S02"
//   [1]=>
//   int(1146)
//   [2]=>
//   string(38) "Table 'blog_test.aabbcc' doesn't exist"
// }

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$pdo->query('select * from aabbcc');
// Warning: PDO::query(): SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->query('select * from aabbcc');
// Fatal error: Uncaught PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist 

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
$pdo->query('select * from aabbcc');
// Warning: PDO::query(): SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist
