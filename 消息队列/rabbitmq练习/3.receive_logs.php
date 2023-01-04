<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false,false,false);

[$queue_name, ,] = $channel->queue_declare('',false, false, true,false);

$channel->queue_bind($queue_name, 'logs');

echo "[x] Waiting for logs.To exit press CTRL+C\n";

$callback = function($msg) {
 echo '[x]', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while($channel->is_open()){
    $channel->wait();
}

$channel->close();
$connection->close();