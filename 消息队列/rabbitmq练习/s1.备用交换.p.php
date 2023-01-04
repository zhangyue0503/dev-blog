<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "./vendor/autoload.php";

$connection = new AMQPStreamConnection('192.168.56.106', 5672, 'admin', 123456);
$channel = $connection->channel();

$channel->exchange_declare('my-ex1', 'direct', false, true, false);

$channel->queue_declare('r1',true,true);
$channel->queue_bind('r1', 'my-ex1', 'key1');

$serverity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';



$data = implode(' ', array_slice($argv, 2));
if (empty($data)){
    $data = "Hello World!";
}
$msg = new AMQPMessage($data, [
    // 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
]);
$channel->confirm_select();


// 1.异步发布确认
$channel->set_ack_handler(function(AMQPMessage $message){
    var_dump($message);
    echo 'ACK!!';
});
$channel->set_nack_handler(function(AMQPMessage $message){
    var_dump($message);
    echo 'NACK!!';
});
// 1.异步发布确认

$channel->basic_publish($msg, 'my-ex3', $serverity);
$channel->wait_for_pending_acks(5.000); // 2.同步单个发布确认

// 3.批量发布确认
// $batch_size = 100;
// $outstanding_message_count = 0;
// while (thereAreMessagesToPublish()) {
//     $data = ...;
//     $msg = new AMQPMessage($data);
//     $channel->basic_publish($msg, 'exchange');
//     $outstanding_message_count++;
//     if ($outstanding_message_count === $batch_size) {
//         $channel->wait_for_pending_acks(5.000);
//         $outstanding_message_count = 0;
//     }
// }
// if ($outstanding_message_count > 0) {
//     $channel->wait_for_pending_acks(5.000);
// }



echo '[x] Sent ',$severity, ':', $data, '\n';

$channel->close();
$connection->close();
