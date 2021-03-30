<?php

$m = new Memcached();
$m->addServer('127.0.0.1', '11211');

print_r($m->getStats());
// Array
// (
//     [127.0.0.1:11211] => Array
//         (
//             [pid] => 1713
//             [uptime] => 1277
//             [time] => 1614646202
//             [version] => 1.5.22
//             [libevent] => 2.1.8-stable
//             [pointer_size] => 64
// …………………………
// …………………………
// …………………………
            
print_r($m->getServerList());
// Array
// (
//     [0] => Array
//         (
//             [host] => 127.0.0.1
//             [port] => 11211
//             [type] => TCP
//         )

// )

$m->add("test1", "a");
$m->add("test2", 1);
$m->add("test3", "c", 3);
sleep(4);

print_r($m->getAllKeys());
// Array
// (
//     [0] => test1
//     [1] => test2
//     [2] => test3
// )

echo $m->get("test1"), PHP_EOL; // a
echo $m->get("test3"), PHP_EOL; // 

$m->getDelayed(['test1', 'test2', 'test3']);
print_r($m->fetchAll());
// Array
// (
//     [0] => Array
//         (
//             [key] => test1
//             [value] => a
//         )

//     [1] => Array
//         (
//             [key] => test2
//             [value] => 1
//         )

// )

$m->setOption(Memcached::OPT_COMPRESSION, false);
$m->append("test1", "aa");
echo $m->get("test1"), PHP_EOL; // aaa

$m->set("test4", "d");
print_r($m->getMulti(["test1", "test4"]));
// Array
// (
//     [test1] => aaaaaaaaaaaaaaaaaaaaa
//     [test4] => d
// )

$m->increment("test2");
echo $m->get("test2"), PHP_EOL; // 2

$m->decrement("test2");
echo $m->get("test2"), PHP_EOL; // 1


$mem = new Memcache();
$mem->connect('127.0.0.1', 11211);

print_r($mem->getStats());
// Array
// (
//     [pid] => 1713
//     [uptime] => 1281
//     [time] => 1614646206
//     [version] => 1.5.22
//     [libevent] => 2.1.8-stable
//     [pointer_size] => 64
//     [rusage_user] => 0.085507
//     [rusage_system] => 0.145715
//     [max_connections] => 1024
// ………………………………
// ………………………………
// ………………………………

echo $mem->getVersion(), PHP_EOL;
// 1.5.22

$mem->set("test5", "e");
echo $mem->get("test5"), PHP_EOL; // e