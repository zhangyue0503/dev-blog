<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false,false,false);

[$queue_name, ,] = $channel->queue_declare('',false, false, true,false);

$severities = array_slice($argv, 1);
if (empty($severities)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [info] [warning] [error]\n");
    exit(1);
}

foreach ($severities as $severity) {
    $channel->queue_bind($queue_name, 'direct_logs', $severity);
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