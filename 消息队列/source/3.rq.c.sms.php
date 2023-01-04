<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('orders', 'fanout', false,false,false);

[$queue_name, ,] = $channel->queue_declare('',false, false, true,false);

$channel->queue_bind($queue_name, 'orders');

echo "[x] 等待数据，退出请按 CTRL+C\n";

$callback = function($msg) {
    echo '[x] 接收到 ', $msg->body, "，开始向相关方发送短信....\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while($channel->is_open()){
    $channel->wait();
}

$channel->close();
$connection->close();