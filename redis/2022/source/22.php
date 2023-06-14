<?php

$sentinel = new \RedisSentinel('127.0.0.1', 26379);
$instance = $sentinel->getMasterAddrByName('mymaster');
print_r($instance);
// Array
// (
//     [0] => 127.0.0.1
//     [1] => 6381
// )

$redis = new \Redis();
$redis->connect($instance[0], (int) $instance[1]);
$info = $redis->info("Server");
echo $info['tcp_port']; // 6381
