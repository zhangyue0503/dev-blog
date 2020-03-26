<?php



/**
 * 随机生成四位字符串的salt
 * 也可以根据实际情况使用6位或更长的salt
 */
function generateSalt()
{
    // 使用随机方式生成一个四位字符
    $chars = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    for ($i = 0; $i < 4; $i++) {
        $str .= $chars[mt_rand(0, count($chars) - 1)];
    }
    return $str;
}

/**
 * 密码生成
 * 使用两层hash，将salt加在第二层
 * sha1后再加salt然后再md5
 */
function generateHashPassword($password, $salt)
{
    return md5(sha1($password) . $salt);
}

$pdo = new PDO('mysql:host=localhost;dbname=blog_test;charset=utf8mb4', 'root', '');

$username = 'ZyBlog1';
$password = '123456';

// 注册
function register($username, $password)
{
    global $pdo;

    // 首先判断用户是否已注册
    $pre = $pdo->prepare("SELECT COUNT(id) FROM zyblog_test_user WHERE username = :username");
    $pre->bindParam(':username', $username);
    $pre->execute();
    $result = $pre->fetchColumn();

    // 如果用户名存在，则无法注册
    if ($result > 0) {
        echo '用户名已注册！', PHP_EOL;
        return 0;
    }

    // 生成salt
    $salt = generateSalt();
    // 密码进行加盐hash处理
    $password = generateHashPassword($password, $salt);

    // 插入新用户
    $pre = $pdo->prepare("insert into zyblog_test_user(username, password, salt) values(?, ?, ?)");

    $pre->bindValue(1, $username);
    $pre->bindValue(2, $password);
    $pre->bindValue(3, $salt);

    $pre->execute();

    return $pdo->lastInsertId();
}

$userId = register($username, $password);
if ($userId > 0) {
    echo '注册成功！用户ID为：' . $userId, PHP_EOL;
}

// 注册成功！用户ID为：1

// 查询数据库中的数据
$sth = $pdo->prepare("SELECT * FROM zyblog_test_user");
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);
print_r($result);

// Array
// (
//     [0] => Array
//         (
//             [id] => 1
//             [username] => ZyBlog1
//             [password] => bbff8283d0f90625015256b742b0e694
//             [salt] => xOkb
//         )

// )

// 登录时验证
function login($username, $password)
{
    global $pdo;
    // 先根据用户名查表
    $pre = $pdo->prepare("SELECT * FROM zyblog_test_user WHERE username = :username");
    $pre->bindParam(':username', $username);
    $pre->execute();
    $result = $pre->fetch(PDO::FETCH_ASSOC);

    // 用户名存在并获得用户信息后
    if ($result) {
        // 根据用户表中的salt字段生成hash密码
        $password = generateHashPassword($password, $result['salt']);

        // 比对hash密码确认登录是否成功
        if ($password == $result['password']) {
            return true;
        }
    }
    return false;
}

$isLogin = login($username, $password);
if ($isLogin) {
    echo '登录成功！', PHP_EOL;
} else {
    echo '登录失败，用户名或密码错误！', PHP_EOL;
}

// 登录成功！

// 测试表
/*
CREATE TABLE `zyblog_test_user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '用户名',
    `password` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '密码',
    `salt` char(4) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '盐',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
*/