<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道

// 定义队列
$channel->queue_declare('hello', false, false, false, false);

// 创建消息
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello'); // 将消息放入队列中

echo "生产者向消息队列中发送信息：Hello World！";

$channel->close();
$connection->close();