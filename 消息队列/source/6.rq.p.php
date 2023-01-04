<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/vendor/autoload.php';


// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道

$channel->queue_declare('hello6', false, true, false, false, false, new AMQPTable([
    'x-max-priority'=>10, // 设置最大优先级
]));

// 创建消息
for ($i = 6; $i > 0; $i--) {
    $priority = random_int(0, 2);
    $body = '优先消息测试，当前优先级为：' . $priority;
    $msg = new AMQPMessage($body,
        ['priority' => $priority]
    );
    $channel->basic_publish($msg, '', 'hello6'); // 将消息放入队列中

    echo "生产者向消息队列中发送信息：" . $body, PHP_EOL;
}

