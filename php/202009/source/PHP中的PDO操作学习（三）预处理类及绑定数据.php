<?php

$dns = 'mysql:host=localhost;dbname=blog_test;port=3306;charset=utf8';
$pdo = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$stmt = $pdo->prepare("select * from zyblog_test_user");

// PDOStatement 对象的内容
var_dump($stmt);
// object(PDOStatement)#2 (1) {
//     ["queryString"]=>
//     string(57) "select * from zyblog_test_user where username = :username"
//   }

// 没有指定异常处理状态下的错误信息函数 
$pdo_no_exception = new PDO($dns, 'root', '');
$errStmt = $pdo_no_exception->prepare("select * from errtable");
$errStmt->execute();
var_dump($errStmt->errorCode()); // string(5) "42S02"
var_dump($errStmt->errorInfo());
// array(3) {
//     [0]=>
//     string(5) "42S02"
//     [1]=>
//     int(1146)
//     [2]=>
//     string(40) "Table 'blog_test.errtable' doesn't exist"
//   }


// 为语句设置默认的获取模式。
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "1"
//     ["username"]=>
//     string(3) "aaa"
//     ["password"]=>
//     string(3) "aaa"
//     ["salt"]=>
//     string(3) "aaa"
//   }
// ……

// MySQL 驱动不支持 setAttribute
// $stmt->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY);
// Fatal error: Uncaught PDOException: SQLSTATE[IM001]: Driver does not support this function: This driver doesn't support setting attributes

// MySQL 驱动不支持 getAttribute
// var_dump($stmt->getAttribute(PDO::ATTR_AUTOCOMMIT));
// Fatal error: Uncaught PDOException: SQLSTATE[IM001]: Driver does not support this function: This driver doesn't support getting attributes 

// 返回结果集列数、返回结果集中一列的元数据
$stmt = $pdo->prepare("select * from zyblog_test_user");
$stmt->execute();
var_dump($stmt->columnCount()); // int(4)
var_dump($stmt->getColumnMeta(0)); 
// array(7) {
//     ["native_type"]=>
//     string(4) "LONG"
//     ["pdo_type"]=>
//     int(2)
//     ["flags"]=>
//     array(2) {
//       [0]=>
//       string(8) "not_null"
//       [1]=>
//       string(11) "primary_key"
//     }
//     ["table"]=>
//     string(16) "zyblog_test_user"
//     ["name"]=>
//     string(2) "id"
//     ["len"]=>
//     int(11)
//     ["precision"]=>
//     int(0)
//   }

// 直接打印出一条预处理语句包含的信息
$stmt = $pdo->prepare("select * from zyblog_test_user where username=? and salt = ?");
$username = 'aaa';
$stmt->bindParam(1, $username, PDO::PARAM_STR);
$stmt->bindValue(2, 'aaa', PDO::PARAM_STR);
$stmt->execute();
var_dump($stmt->debugDumpParams()); 
// SQL: [60] select * from zyblog_test_user where username=? and salt = ?
// Sent SQL: [68] select * from zyblog_test_user where username='aaa' and salt = 'aaa'
// Params:  2
// Key: Position #0:
// paramno=0
// name=[0] ""
// is_param=1
// param_type=2
// Key: Position #1:
// paramno=1
// name=[0] ""
// is_param=1
// param_type=2



// bindColumn
$stmt = $pdo->prepare("select * from zyblog_test_user");

$stmt->execute();

$stmt->bindColumn(1, $id);
$stmt->bindColumn(2, $username, PDO::PARAM_STR);
$stmt->bindColumn("password", $password);
$stmt->bindColumn("salt", $salt, PDO::PARAM_INT); // 指定类型强转成了 INT 类型

// 不存在的字段
// $stmt->bindColumn(5, $t); 
//Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: Invalid column index

while($row = $stmt->fetch(PDO::FETCH_BOUND)){
    $data = [
        'id'=>$id,
        'username'=>$username,
        'password'=>$password,
        'salt'=>$salt,
    ];
    var_dump($data);
}
// array(4) {
//     ["id"]=>
//     string(1) "1"
//     ["username"]=>
//     string(3) "aaa"
//     ["password"]=>
//     string(3) "aaa"
//     ["salt"]=>
//     int(0)
//   }
//   array(4) {
//     ["id"]=>
//     string(1) "2"
//     ["username"]=>
//     string(3) "bbb"
//     ["password"]=>
//     string(3) "bbb"
//     ["salt"]=>
//     int(123)
//   }
// ……

// 外部获取变量就是最后一条数据的信息
$data = [
    'id'=>$id,
    'username'=>$username,
    'password'=>$password,
    'salt'=>$salt,
];
print_r($data);
// Array
// (
//     [id] => 2
//     [username] => bbb
//     [password] => bbb
//     [salt] => bbb
// )

// bindParam 
$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(:username, :pass, :salt)");

$username = 'ccc';
$passwrod = '333';
$salt = 'c3';

$stmt->bindParam(':username', $username);
$stmt->bindParam(':pass', $password);
$stmt->bindParam(':salt', $salt);

$stmt->execute();

// bindParam 问号占位符
$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(?, ?, ?)");

$username = 'ccc';
$passwrod = '333';
$salt = 'c3';

$stmt->bindParam(1, $username);
$stmt->bindParam(2, $password);
$stmt->bindParam(3, $salt);

$stmt->execute();

// bindValue
$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(:username, :pass, :salt)");

$username = 'ddd';
$passwrod = '444';
$salt = 'd4';

$stmt->bindValue(':username', $username);
$stmt->bindValue(':pass', $password);
$stmt->bindValue(':salt', $salt);

$stmt->execute();

// bindValue 可以绑定常量
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

//$stmt->bindParam(':username', 'ccc');
// Fatal error: Uncaught Error: Cannot pass parameter 2 by reference

$stmt->bindValue(':username', 'ccc');

$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(2) "19"
//     ["username"]=>
//     string(3) "ccc"
//     ["password"]=>
//     string(3) "bbb"
//     ["salt"]=>
//     string(2) "c3"
//   }
// ……
echo "==============", PHP_EOL;
unset($username);

// bindParam 是以引用方式绑定，bindValue 是定义后就立即将参数进行绑定
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

$stmt->bindValue(':username', $username);
$username = 'ccc';

$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($row);
}
// 

echo "==============", PHP_EOL;
unset($username);

$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

$username = 'ccc';
$stmt->bindValue(':username', $username);


$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(2) "19"
//     ["username"]=>
//     string(3) "ccc"
//     ["password"]=>
//     string(3) "bbb"
//     ["salt"]=>
//     string(2) "c3"
//   }
// ……

echo "==============", PHP_EOL;
unset($username);

$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

$stmt->bindParam(':username', $username);
$username = 'ddd';

$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "8"
//     ["username"]=>
//     string(3) "ddd"
//     ["password"]=>
//     string(3) "bbb"
//     ["salt"]=>
//     string(2) "d4"
//   }
//   ……

// execute 直接传递参数
$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(:username, :pass, :salt)");
$stmt->execute([
    ':username'=>'jjj',
    ':pass'=>'888',
    ':salt'=>'j8'
]);
// 使用问号占位符的话是按从0开始的下标
$stmt = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(?, ?, ?)");
$stmt->execute(['jjjj','8888','j8']);