<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false, false, false);

$serverity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = implode(' ', array_slice($argv, 2));
if (empty($data)){
    $data = "Hello World!";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'direct_logs', $serverity);

echo '[x] Sent ',$severity, ':', $data, '\n';

$channel->close();
$connection->close();
