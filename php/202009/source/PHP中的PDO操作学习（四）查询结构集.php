<?php

$dns = 'mysql:host=localhost;dbname=blog_test;port=3306;charset=utf8';
$pdo = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// fetch

$stmt = $pdo->prepare("select * from zyblog_test_user");
$stmt->execute();

$row = $stmt->fetch();
print_r($row);
// Array
// (
//     [id] => 1
//     [0] => 1
//     [username] => aaa
//     [1] => aaa
//     [password] => aaa
//     [2] => aaa
//     [salt] => aaa
//     [3] => aaa
// )



$row = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($row);
// Array
// (
//     [id] => 2
//     [username] => bbb
//     [password] => bbb
//     [salt] => 123
// )

$row = $stmt->fetch(PDO::FETCH_LAZY);
print_r($row);
// PDORow Object
// (
//     [queryString] => select * from zyblog_test_user
//     [id] => 3
//     [username] => ccc
//     [password] => bbb
//     [salt] => c3
// )

$row = $stmt->fetch(PDO::FETCH_OBJ);
print_r($row);
// stdClass Object
// (
//     [id] => 4
//     [username] => ccc
//     [password] => bbb
//     [salt] => c3
// )

// 获取全部数据

// while($row = $stmt->fetch()){
//     print_r($row);
// }
// Array
// (
//     [id] => 2
//     [0] => 2
//     [username] => bbb
//     [1] => bbb
//     [password] => bbb
//     [2] => bbb
//     [salt] => 123
//     [3] => 123
// )
// ……

// MySQL 不支持游标

$stmt = $pdo->prepare("select * from zyblog_test_user", [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
print_r($row);
// Array
// (
//     [id] => 1
//     [username] => aaa
//     [password] => aaa
//     [salt] => aaa
// )

$stmt = $pdo->prepare("select * from zyblog_test_user", [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_LAST);
print_r($row);
// Array
// (
//     [id] => 1
//     [username] => aaa
//     [password] => aaa
//     [salt] => aaa
// )

// fetchAll

$stmt = $pdo->prepare("select * from zyblog_test_user limit 2");
$stmt->execute();

$list = $stmt->fetchAll();
print_r($list);
// Array
// (
//     [0] => Array
//         (
//             [id] => 1
//             [0] => 1
//             [username] => aaa
//             [1] => aaa
//             [password] => aaa
//             [2] => aaa
//             [salt] => aaa
//             [3] => aaa
//         )

//     [1] => Array
//         (
//             [id] => 2
//             [0] => 2
//             [username] => bbb
//             [1] => bbb
//             [password] => bbb
//             [2] => bbb
//             [salt] => 123
//             [3] => 123
//         )

// )

$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($list);
// Array
// (
// )

$stmt = $pdo->prepare("select * from zyblog_test_user limit 2");
$stmt->execute();

$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($list);
// Array
// (
//     [0] => Array
//         (
//             [id] => 1
//             [username] => aaa
//             [password] => aaa
//             [salt] => aaa
//         )

//     [1] => Array
//         (
//             [id] => 2
//             [username] => bbb
//             [password] => bbb
//             [salt] => 123
//         )

// )

$stmt = $pdo->prepare("select * from zyblog_test_user limit 2");
$stmt->execute();

$list = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
print_r($list);
// Array
// (
//     [0] => aaa
//     [1] => bbb
// )

class User{
    function __construct($a){
        echo $a, PHP_EOL;
    }
}
$stmt = $pdo->prepare("select * from zyblog_test_user limit 2");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_CLASS, 'User', ['FetchAll User']);
print_r($list);
// FetchAll User
// FetchAll User
// Array
// (
//     [0] => User Object
//         (
//             [id] => 1
//             [username] => aaa
//             [password] => aaa
//             [salt] => aaa
//         )

//     [1] => User Object
//         (
//             [id] => 2
//             [username] => bbb
//             [password] => bbb
//             [salt] => 123
//         )

// )
function getValue(){
    print_r(func_get_args());
}
// Array
// (
//     [0] => 1
//     [1] => aaa
//     [2] => aaa
//     [3] => aaa
// )
// Array
// (
//     [0] => 2
//     [1] => bbb
//     [2] => bbb
//     [3] => 123
// )
$stmt = $pdo->prepare("select * from zyblog_test_user limit 2");
$stmt->execute();
$list = $stmt->fetchAll(PDO::FETCH_FUNC, 'getValue');
print_r($list);
// Array
// (
//     [0] => 
//     [1] => 
// )

// fetchColumn
$stmt = $pdo->prepare("select * from zyblog_test_user");
$stmt->execute();
$column = $stmt->fetchColumn(2);
echo $column, PHP_EOL;
// aaa

$column = $stmt->fetchColumn(3);
echo $column, PHP_EOL;
// 123

// fetchObject
$stmt = $pdo->prepare("select * from zyblog_test_user");
$stmt->execute();
$user = $stmt->fetchObject('User', ['FetchObject User']);
print_r($user);
// FetchObject User
// User Object
// (
//     [id] => 1
//     [username] => aaa
//     [password] => aaa
//     [salt] => aaa
// )

// rowCount
$stmt = $pdo->prepare("select * from zyblog_test_user");
$stmt->execute();
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL;
// 41

$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(?, ?, ?)");
$stmt->execute(['kkk','666','k6']);
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL; // 1
$id = $pdo->lastInsertId();
echo $rowCount, PHP_EOL; // 1

$stmt = $pdo->prepare("update zyblog_test_user set username=? where username = ?");
$stmt->execute(['ccc','cccc']);
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL; // 25

$stmt = $pdo->prepare("update zyblog_test_user set username=? where username = ?");
$stmt->execute(['ccc','cccc']);
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL; // 0

$stmt = $pdo->prepare("delete from zyblog_test_user where username = ?");
$stmt->execute(['ddd']);
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL; // 11

$stmt = $pdo->prepare("delete from zyblog_test_user where username = ?");
$stmt->execute(['ddd']);
$rowCount = $stmt->rowCount();
echo $rowCount, PHP_EOL; // 0
