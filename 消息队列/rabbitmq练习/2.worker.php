<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', '123456');
$channel = $connection->channel();

// $channel->queue_declare('hello', false,true,false,false);

$channel->queue_declare('hello9', false,false,false,false,false,new AMQPTable([
    // 'x-single-active-consumer'=>true, // 单个活跃消费者
    // 'x-message-ttl'=>1000,
    'x-dead-letter-exchange'=>'direct_logs', // 死信到某个交换机
    'x-dead-letter-routing-key'=>'info', // 死信路由
    'x-max-priority'=>10 // 设置最大优先级
]));



echo "[x] Waiting for message. To exit press CTRL+C\n";

$callback = function($msg){
    echo '[x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo "[x] Done\n";
    // var_dump($msg);
    sleep(3);
    $msg->ack();
    // $msg->nack();
 
    echo "[x] Ack Ok!\n";
};



$channel->basic_qos(null, 1, null);
$channel->basic_consume('hello9', '', false, false, false, false,$callback);

while ($channel->is_open()){
    $channel->wait();
}


