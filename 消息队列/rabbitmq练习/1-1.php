<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', '123456');
$channel = $connection->channel();

$channel->queue_declare('hello', false,false,false,false);

echo "[x] Waiting for message. To exit press CTRL+C\n";

$callback = function($msg){
    echo '[x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false,$callback);

while ($channel->is_open()){
    $channel->wait();
}


