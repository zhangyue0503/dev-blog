# 关于当前PHP脚本运行时系统信息相关函数

我们的 PHP 在执行的时候，其实可以获取到非常多的当前系统相关的信息。就像很多开源的 CMS 一般会在安装的时候来检测一些环境信息一样，这些信息都是可以方便地动态获取的。

## 脚本文件运行时的系统用户相关信息

首先，我们来看看获取当前系统相关的一些用户信息。这个用户信息就是我们系统运行 php 脚本时所使用的系统用户。

```php
echo '当前脚本拥有者：' . get_current_user(), PHP_EOL;
// 当前脚本拥有者：zhangyue

echo '当前脚本属组：' . getmygid(), PHP_EOL;
// 当前脚本属组：20

echo '当前脚本的用户属主：' . getmyuid(), PHP_EOL;
// 当前脚本的用户属主：501
```

看出来了嘛？其实这三个函数就是对应的 Linux 中的文件拥有者、所属组，get_current_user() 返回的是用户名，getmyuid() 返回的是用户的 UID ，它们两个是对应的同一个用户。getmygid() 则返回的是当前用户所属的用户组。

## 获取当前运行脚本的系统相关信息

这一组函数可以让我们获得系统的 innode 信息、当前脚本运行时的 进程ID 、服务接口类型、运行 PHP 的操作系统信息以及资源使用情况。

```php
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
```

从注释中，我们可以看出，getmypid() 在使用命令行时返回的是当前执行的 进程ID ，在网页中访问的时候返回的是 PHP-FPM 的 进程ID 。同理，php_sapi_name() 也会根据当前运行的环境返回不同的内容。

php_uname() 默认参数是就 'a' ，意思是返回完整的操作系统信息。它还有其它的参数可以返回单独的不同的信息，或者我们只需要知道当前操作是什么系统时，就直接使用 PHP_OS 常量会更加的方便。

getrusage() 能够返回系统资源的情况，比如 ru_nswap 就是系统当前的 swap 交换区的使用情况，但是这些参数并没有很详细的说明，毕竟这个函数还是使用的比较少的。

## 获取 PHP 及相关扩展组件的版本信息

```php
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
```

phpversion() 在没有参数的情况下和 PHP_VERSION 常量的效果是一样的，返回的是当前运行的 PHP 的版本号，但是，phpversion() 可以给一个扩展组件名的参数，这样，它就可以返回这个扩展组件的版本号。就像例子中，我们获取了当前环境下 Swoole 的版本号。zend_version() 就是很简单的返回了当前运行环境中的 Zend引擎 版本号。

version_compare() 可以帮助我们方便地进行版本号的对比。它是以逗号进行分隔进行的版本对比，也就是说，我们自己定义的字符串版本号都可以使用它来进行对比。具体的对比规则可以参考官方文档。

## 当前脚本文件的修改时间及脚本运行时间

```php
echo "当前脚本文件的最后修改时间： " . date("Y-m-d H:i:s.", getlastmod()), PHP_EOL;
// 当前脚本文件的最后修改时间： 2020-06-01 08:55:49.

// nginx环境下
set_time_limit(84600);
// while(1){

// }
```

getlastmod() 非常简单，就是返回当前运行的这个 PHP 文件最后被修改的时间。而 set_time_limit() 相信大家就不陌生了。在默认情况下，web请求都不会持续很长时间就会主动断开。比如在 php.ini 文件中，我们默认定义的 max_execution_time 是30秒，当一个请求消耗的时候超过这个时间后，请求就会断开。不过，总会有一些请求是确实需要我们消耗更长的时间来执行的，比如说生成 Excel 之类的文档往往就需要更长的时间。这个时候，我们就可以使用 set_time_limit() 来设置脚本最大执行时间来延长web请求的执行超时时间。

测试代码：


参考文档：
[https://www.php.net/manual/zh/function.get-current-user.php](https://www.php.net/manual/zh/function.get-current-user.php)
[https://www.php.net/manual/zh/function.getmyuid.php](https://www.php.net/manual/zh/function.getmyuid.php)
[https://www.php.net/manual/zh/function.getmygid.php](https://www.php.net/manual/zh/function.getmygid.php)
[https://www.php.net/manual/zh/function.getmyinode.php](https://www.php.net/manual/zh/function.getmyinode.php)
[https://www.php.net/manual/zh/function.getmypid.php](https://www.php.net/manual/zh/function.getmypid.php)
[https://www.php.net/manual/zh/function.getrusage.php](https://www.php.net/manual/zh/function.getrusage.php)
[https://www.php.net/manual/zh/function.php-sapi-name.php](https://www.php.net/manual/zh/function.php-sapi-name.php)
[https://www.php.net/manual/zh/function.php-uname.php](https://www.php.net/manual/zh/function.php-uname.php)
[https://www.php.net/manual/zh/function.phpversion.php](https://www.php.net/manual/zh/function.phpversion.php)
[https://www.php.net/manual/zh/function.set-time-limit.php](https://www.php.net/manual/zh/function.set-time-limit.php)
[https://www.php.net/manual/zh/function.zend-version.php](https://www.php.net/manual/zh/function.zend-version.php)
[https://www.php.net/manual/zh/function.getlastmod.php](https://www.php.net/manual/zh/function.getlastmod.php)