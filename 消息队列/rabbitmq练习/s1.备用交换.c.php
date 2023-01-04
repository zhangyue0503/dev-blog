<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);

$channel = $connection->channel();

$channel->exchange_declare('my-ex1', 'direct', false,true,false,false,false, new AMQPTable([
    'alternate-exchange'=> 'my-ae',
]));
$channel->exchange_declare('my-ae', 'fanout');

$channel->queue_declare('r1');
$channel->queue_bind('r1', 'my-ex1', 'key1');

$channel->queue_declare('r2');
$channel->queue_bind('r2', 'my-ae','');


$channel->basic_consume('r1', '', false, true, false, false, function($msg){
    echo 'r1:', $msg->body, PHP_EOL;
});

$channel->basic_consume('r2', '', false, true, false, false, function($msg){
    echo 'r2:', $msg->body,'---', $msg->delivery_info['routing_key'],PHP_EOL;
});

while($channel->is_open()){
    $channel->wait();
}

$channel->close();
$connection->close();

