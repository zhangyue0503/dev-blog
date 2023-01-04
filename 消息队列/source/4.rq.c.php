<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道

// 定义队列
//$channel->queue_delete('hello');
//$channel->queue_declare('hello', false, true, false, false);




echo "等待消息，或者使用 Ctrl+C 退出程序。", PHP_EOL;

// 定义接收数据的回调函数
$callback = function ($msg) {
    echo '接收到数据： ', $msg->body, PHP_EOL;
    $msg->ack();
};

// 消费队列，获取到数据将调用 callback 回调函数
$channel->basic_consume('hello4', '', false, false, false, false, $callback);

// 频道是开启状态时，挂起程序，不停地执行
while ($channel->is_open()) {
    // 等待并监听频道中的队列信息
    // 发现上方 basic_consume 定义的队列有消息后
    // 就调用它对应的 callback
    $channel->wait();
}

// ack超时时间设置 rabbit.conf 中
// consumer_timeout = 1800000，30分钟