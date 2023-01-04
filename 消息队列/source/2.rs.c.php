<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


echo "等待消息，或者使用 Ctrl+C 退出程序。", PHP_EOL;

while(1){
    $data = $redis->rpop('hello');
    if ($data){
        echo '接收到数据： ', $data, PHP_EOL;
    }
}
