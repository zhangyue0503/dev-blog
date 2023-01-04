<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;

// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道


$channel->queue_declare('hello6', false, true, false, false, false, new AMQPTable([
    'x-max-priority'=>10, // 设置最大优先级
]));

echo "等待消息，或者使用 Ctrl+C 退出程序。", PHP_EOL;

// 定义接收数据的回调函数
$callback = function ($msg) {
    echo '接收到数据： ', $msg->body, PHP_EOL;
};

$channel->basic_consume('hello6', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}
