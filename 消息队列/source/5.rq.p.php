<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/vendor/autoload.php';


// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道

$channel->queue_declare('hello5', false, true, false, false, false, new AMQPTable([
    'x-message-ttl'=>10000,
    'x-dead-letter-exchange'=>'dead_letter', // 死信到某个交换机
    'x-dead-letter-routing-key'=>'', // 死信路由
]));

// 创建消息
$msg = new AMQPMessage('Hello World!');
$msg = new AMQPMessage('Hello World!' . time(),[
   'expiration'=> 3000,
]);
$channel->basic_publish($msg, '', 'hello5'); // 将消息放入队列中

echo "生产者向消息队列中发送信息：Hello World！";
