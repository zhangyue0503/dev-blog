<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', '123456');
$channel = $connection->channel();

$channel->tx_rollback();

// $queue = $channel->queue_declare('hello3', false,true,false,false);
// var_dump($queue);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$data = microtime() . ', '. $data;

$msg = new AMQPMessage($data,[
    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
    //  'expiration'=>10,  // 消息过期，毫秒,
    //  'priority'=>random_int(0,10), // 优先级
]);
$channel->basic_publish($msg, '', 'hello9');
// $msg->nack()

echo "[x] Sent '",$data, "'\n";

$channel->close();
$connection->close();

