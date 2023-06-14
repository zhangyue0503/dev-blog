<?php
// for ($i = 0; $i <= 100000; $i++) {
//     $data[] = 'k' . $i;
// }
// for ($i = 0; $i <= 511; $i++) {
//     $data['k' . $i] = $i;
// }

// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);

// $redis->sAdd('c', ...$data);
// $redis->sAddArray('c', $data);

// for ($i = 0; $i <= 511; $i++) {
//     $data['k' . $i] = $i;
// }

// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);

// $redis->hMSet('b', $data);

// $redis->hMSet('b', $data);

for ($i = 0; $i <= 512; $i++) {
    $data['k' . $i] = $i;
}

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$redis->hMSet('b', $data);
