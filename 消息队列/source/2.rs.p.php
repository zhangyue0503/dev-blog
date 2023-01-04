<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

echo "生产者向消息队列中发送信息：Hello World！";

$redis->lpush('hello', 'Hello World！');
$redis->lpush('hello', 'Hello World！');
$redis->lpush('hello', 'Hello World！');
$redis->lpush('hello', 'Hello World！');
