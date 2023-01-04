<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$data = '订单号：' . time();

$redis->publish('orders', $data);

echo '[x] 发送消息 ', $data, '\n';