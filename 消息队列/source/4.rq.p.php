<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/vendor/autoload.php';


// 建立连接
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel(); // 获取频道
$channel->confirm_select();

// 定义队列
//$channel->queue_delete('hello');
//$channel->exchange_delete('ex1');
//$channel->exchange_declare('ex1', 'direct');
$channel->queue_declare('hello4', false, false, false, false);
//$channel->queue_bind('hello', 'ex1', 'h1');





$channel->set_ack_handler(
    function (AMQPMessage $message){
        echo '消息已经被发送成功啦！', $message->body, PHP_EOL;
    }
);

$channel->set_nack_handler(
    function (AMQPMessage $message){
        echo '消息发送失败啦，我们要做别的操作啦！', $message->body, PHP_EOL;
    }
);



// 创建消息
$msg = new AMQPMessage('Hello World!', ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
$channel->basic_publish($msg, '', 'hello4'); // 将消息放入队列中
//$channel->wait_for_pending_acks(5);

echo "生产者向消息队列中发送信息：Hello World！";
$channel->wait(null,false,5);
