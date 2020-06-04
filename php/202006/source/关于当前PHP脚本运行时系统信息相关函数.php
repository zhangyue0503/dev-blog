<?php

echo '当前脚本拥有者：' . get_current_user(), PHP_EOL;
// 当前脚本拥有者：zhangyue

echo '当前脚本属组：' . getmygid(), PHP_EOL;
// 当前脚本属组：20

echo '当前脚本的用户属主：' . getmyuid(), PHP_EOL;
// 当前脚本的用户属主：501

echo '当前脚本的索引节点：' . getmyinode(), PHP_EOL;
// 当前脚本的索引节点：8691989143

echo '当前脚本的进程ID：' . getmypid(), PHP_EOL;
// 当前脚本的进程ID：1854
// Nginx：当前脚本的进程ID：711（php-fpm的进程ID）

echo "web服务器和PHP之间的接口类型：" . php_sapi_name(), PHP_EOL;
// web服务器和PHP之间的接口类型：cli
// Nginx：web服务器和PHP之间的接口类型：fpm-fcgi

echo "运行 PHP 的系统：" . php_uname("a"), PHP_EOL;
// 运行 PHP 的系统：Darwin zhangyuedeMBP 19.4.0 Darwin Kernel Version 19.4.0: Wed Mar  4 22:28:40 PST 2020; root:xnu-6153.101.6~15/RELEASE_X86_64 x86_64
//

echo "运行PHP的系统：" . PHP_OS, PHP_EOL;
// 运行 PHP 的系统：Darwin

// 当前脚本的资源使用情况
print_r(getrusage());
// Array
// (
//     [ru_oublock] => 0
//     [ru_inblock] => 0
//     [ru_msgsnd] => 0
//     [ru_msgrcv] => 0
//     [ru_maxrss] => 16809984
//     [ru_ixrss] => 0
//     [ru_idrss] => 0
//     [ru_minflt] => 4410
//     [ru_majflt] => 1
//     [ru_nsignals] => 0
//     [ru_nvcsw] => 0
//     [ru_nivcsw] => 86
//     [ru_nswap] => 0
//     [ru_utime.tv_usec] => 41586
//     [ru_utime.tv_sec] => 0
//     [ru_stime.tv_usec] => 41276
//     [ru_stime.tv_sec] => 0
// )

echo "当前的PHP版本：" . phpversion(), PHP_EOL;
// 当前的PHP版本：7.3.0

echo "当前的PHP版本：" . PHP_VERSION, PHP_EOL;
// 当前的PHP版本：7.3.0

echo "当前某个扩展的版本（Swoole）：" . phpversion('swoole'), PHP_EOL;
// 当前某个扩展的版本（Swoole）：4.4.12

echo "当前的PHP的zend引擎版本：" . zend_version(), PHP_EOL;
// 当前的PHP的zend引擎版本：3.3.0-dev

if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
    echo '我的版本大于7.0.0，当前版本是：' . PHP_VERSION . "\n";
} else {
    echo '我的版本还在5，要赶紧升级了，当前版本是：' . PHP_VERSION . "\n";
}

echo "当前脚本文件的最后修改时间： " . date("Y-m-d H:i:s.", getlastmod()), PHP_EOL;
// 当前脚本文件的最后修改时间： 2020-06-01 08:55:49.

// nginx环境下
set_time_limit(84600);
// while(1){

// }
