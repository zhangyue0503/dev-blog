<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false,false,false);

[$queue_name, ,] = $channel->queue_declare('',false, false, true,false);

$binding_keys = array_slice($argv, 1);
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

foreach ($binding_keys as $binding_key) {
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}

echo "[x] Waiting for logs.To exit press CTRL+C\n";

$callback = function($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while($channel->is_open()){
    $channel->wait();
}

$channel->close();
$connection->close();