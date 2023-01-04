<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', '123456');
$channel = $connection->channel();

$channel->queue_declare('hello', false,false,false,false);

$msg = new AMQPMessage('Hello World');
$channel->basic_publish($msg, '', 'hello');

echo "[x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

