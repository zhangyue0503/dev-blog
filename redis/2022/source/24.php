<?php

// $c = new \RedisCluster(null, ['127.0.0.1:6379', '127.0.0.1:6380', '127.0.0.1:6381',
//     '127.0.0.1:7379', '127.0.0.1:7380', '127.0.0.1:7381']);
$c = new \RedisCluster("aaa", ['127.0.0.1:6379']);
var_dump($c);
// object(RedisCluster)#1 (0) {
// }

$c->set("a1", "111");
$c->set("b1", "111");
$c->incr("b1");
$c->lPush("c1", 1, 2, 3);

print_r($c->get("a1"));
echo PHP_EOL;
print_r($c->get("b1"));`
echo PHP_EOL;
print_r($c->lRange("c1", 0, -1));

// 关闭所有服务
// 删除 node 文件和 rdb 文件
// 关闭 cluster-enabled
// 重启服务
