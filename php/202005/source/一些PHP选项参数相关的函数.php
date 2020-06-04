<?php
define("MY_CONSTANT", 1);
print_r(get_defined_constants(true));

print_r(get_extension_funcs("swoole"));

print_r(get_loaded_extensions());  // php -m

echo get_include_path(), PHP_EOL; // .:/usr/local/Cellar/php/7.3.0/share/php/pear
echo ini_get('include_path'), PHP_EOL; // .:/usr/local/Cellar/php/7.3.0/share/php/pear

include "动态查看及加载PHP扩展.php";
print_r(get_included_files());
// Array
// (
//     [0] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202005/source/一些PHP选项参数相关的函数（一）.php
//     [1] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202005/source/动态查看及加载PHP扩展.php
// )
var_dump(get_resources());

$fp = fopen('1.txt','r');
var_dump(get_resources());
