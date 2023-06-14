<?php
$redis = new Redis();
$redis->connect("localhost");
$redis->setOption(Redis::OPT_READ_TIMEOUT, -1); // 要设置连接超时时间，要不一会就断了

$redis->subscribe(['a', 'b', 'c'], function ($redis, $chan, $msg) {
    // var_dump($redis);
    if ($chan == 'a') {
        echo "a msg:" . $msg, PHP_EOL;
    }
    if ($chan == 'b') {
        echo "b msg:" . $msg, PHP_EOL;
    }
    if ($chan == 'c') {
        echo "c msg:" . $msg, PHP_EOL;
        $redis->unsubscribe(['b']);
    }
});
