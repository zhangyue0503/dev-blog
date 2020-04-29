<?php

error_reporting(E_ALL);


echo $a; // Notice: Undefined variable: a
print_r(error_get_last());
// Array
// (
//     [type] => 8
//     [message] => Undefined variable: a
//     [file] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/一些简单的错误处理函数（一）.php
//     [line] => 5
// )
echo $b;
print_r(error_get_last()); // 不会打印$a的问题
// Array
// (
//     [type] => 8
//     [message] => Undefined variable: b
//     [file] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202004/source/一些简单的错误处理函数（一）.php
//     [line] => 17
// )

echo $a;
echo $b;
print_r(error_get_last()); // 同样只会打印$b的问题


echo $a; // Notice: Undefined variable: a
error_clear_last();
print_r(error_get_last()); // 不会输出


error_log("Test Error One!");
// php.ini 中定义的 error_log 文件
// [22-Apr-2020 09:04:34 Asia/Shanghai] Test Error One!

error_log("Test Error One!", 1, "423257356@qq.com");


echo $a;
error_log(base64_encode(json_encode(error_get_last())), 1, "423257356@qq.com");
