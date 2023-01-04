<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// 定义交换机
$channel->exchange_declare('orders', 'fanout', false, false, false);

$data = '订单号：' . time();
$msg = new AMQPMessage($data);

// 注意，这里是指定的交换机，第三个参数还是队列名，之前普通队列我们指定的是第三个参数
$channel->basic_publish($msg, 'orders');

echo '[x] 发送消息 ', $data, '\n';

$channel->close();
$connection->close();
