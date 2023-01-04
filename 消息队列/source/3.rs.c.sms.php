<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

echo "[x] 等待数据，退出请按 CTRL+C\n";

$redis->subscribe(['orders'], function($r,$c,$msg){
    echo '[x] 接收到 ', $msg, "，开始向相关方发送短信....\n";
});