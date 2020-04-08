<?php

$db = [
    'server' => 'localhost:3306',
    'user' => 'root',
    'password' => '',
    'database' => 'blog_test',
];

$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $mysqli = new mysqli($db["server"], $db["user"], $db["password"], $db["database"]); //持久连接
    $mysqli->close();
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 6.5814000000
$mysqli = null;

$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $mysqli = new mysqli('p:' . $db["server"], $db["user"], $db["password"], $db["database"]); //持久连接
    $mysqli->close();
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 0.0965000000

$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $pdo = new PDO("mysql:dbname={$db['database']};host={$db['server']}", $db['user'], $db['password']);
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 6.6171000000

$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $pdo = new PDO("mysql:dbname={$db['database']};host={$db['server']}", $db['user'], $db['password'], [PDO::ATTR_PERSISTENT => true]); //持久连接
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 0.0398000000

function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
}
