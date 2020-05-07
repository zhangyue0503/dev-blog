<?php

echo getcwd();

//  php-cgi dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// ...../MyDoc/博客文章/dev-blog/php/202004/source

// php dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// ...../MyDoc/博客文章

// php -r "echo 121;"
// 121

// PHP文件获取命令行参数
print_r($argv);
// php-cgi dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php 1 2 3
// X-Powered-By: PHP/7.3.0
// Content-type: text/html; charset=UTF-8

// php dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php 1 2 3
// Array
// (
//     [0] => dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
//     [1] => 1
//     [2] => 2
//     [3] => 3
// )


// php -r 参数
// php -r "var_dump($argv);" app 
// Warning: var_dump() expects at least 1 parameter, 0 given in Command line code on line 1
// 双引号 "，sh/bash 实行了参数替换
// php -r 'var_dump($argv);' app
// array(2) {
//     [0]=>string(19) "Standard input code"
//     [1]=>string(3) "app"
// }
// php -r 'var_dump($argv);' -- -h
// array(2) {
//     [0]=>string(19) "Standard input code"
//     [1]=>string(2) "-h"
// }

// 交互式运行PHP
// php -a
// php > $a = 1;
// php > echo $a;
// php > 1

// 输出 phpinfo()
// php -i

// 输出 PHP 中加载的模块
// php -m

// 查看模块详细信息
// php --ri swoole  

// 显示去除了注释和多余空白的源代码
// php -w dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// <?php
//  echo getcwd(); print_r($argv);

// 通过 linux 管道读取输入
// cat dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php | php -r "print file_get_contents('php://stdin');"
// ......这个文件里面所有的内容





