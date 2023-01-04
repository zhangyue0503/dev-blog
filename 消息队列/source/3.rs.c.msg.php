<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->setOption(Redis::OPT_READ_TIMEOUT, -1); // 要设置连接超时时间，要不一会就断了

echo "[x] 等待数据，退出请按 CTRL+C\n";

$redis->subscribe(['orders'], function($r,$c,$msg){
    echo '[x] 接收到 ', $msg, "，开始向相关方发送站内消息....\n";
});