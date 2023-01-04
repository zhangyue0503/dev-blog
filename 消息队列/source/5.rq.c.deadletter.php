<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;

// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道

// 死信队列及交换机
$channel->exchange_declare('dead_letter', 'direct', false,true,false);
$channel->queue_declare('dead_letter_queue', false, true);
$channel->queue_bind('dead_letter_queue', 'dead_letter');


echo "等待死信队列消息，或者使用 Ctrl+C 退出程序。", PHP_EOL;

// 定义接收数据的回调函数
$callback = function ($msg) {
    echo '死信队列接收到数据： ', $msg->body, PHP_EOL;
//    echo '死信队列接收到数据： ', $msg->body,' 时间：',time(), PHP_EOL;
};

// 消费队列，获取到数据将调用 callback 回调函数
$channel->basic_consume('dead_letter_queue', '', false, true, false, false, $callback);

// 频道是开启状态时，挂起程序，不停地执行
while ($channel->is_open()) {
    // 等待并监听频道中的队列信息
    // 发现上方 basic_consume 定义的队列有消息后
    // 就调用它对应的 callback
    $channel->wait();
}
