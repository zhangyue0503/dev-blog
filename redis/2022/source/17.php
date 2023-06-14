<?php
$redis = new \Redis();
$redis->pconnect('/tmp/redis.sock');
$redis->flushDB();

$t1 = microtime(true);

for ($i = 0; $i < 100000; $i++) {
    $redis->set("info:" . $i, "val");
}

// $pipe = $redis->pipeline();
// for ($i = 0; $i < 100000; $i++) {
//     $pipe->set("info:" . $i, "val");
// }
// $pipe->exec();

$t2 = microtime(true);
echo $t2 - $t1;
