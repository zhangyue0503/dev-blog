<?php

$str = "a@qq.com,b@sina.COM,c@yahoo.com,一堆测试数据。Test Txt.";

preg_match_all("/(.*)@(.*)\.(.*),/iU", $str, $out);
print_r($out);
// Array
// (
//     [0] => Array
//         (
//             [0] => a@qq.com,
//             [1] => b@sina.com,
//             [2] => c@yahoo.com,
//         )

//     [1] => Array
//         (
//             [0] => a
//             [1] => b
//             [2] => c
//         )

//     [2] => Array
//         (
//             [0] => qq
//             [1] => sina
//             [2] => yahoo
//         )

//     [3] => Array
//         (
//             [0] => com
//             [1] => com
//             [2] => com
//         )

// )

preg_match_all("/(.*)@(.*)\.(.*),/iU", $str, $out, PREG_SET_ORDER);
print_r($out);
// Array
// (
//     [0] => Array
//         (
//             [0] => a@qq.com,
//             [1] => a
//             [2] => qq
//             [3] => com
//         )

//     [1] => Array
//         (
//             [0] => b@sina.COM,
//             [1] => b
//             [2] => sina
//             [3] => COM
//         )

//     [2] => Array
//         (
//             [0] => c@yahoo.com,
//             [1] => c
//             [2] => yahoo
//             [3] => com
//         )

// )


preg_match_all("/(.*)@(.*)\.(.*),/iU", $str, $out, PREG_OFFSET_CAPTURE);
print_r($out);
// Array
// (
//     [0] => Array
//         (
//             [0] => Array
//                 (
//                     [0] => a@qq.com,
//                     [1] => 0
//                 )

//             [1] => Array
//                 (
//                     [0] => b@sina.COM,
//                     [1] => 9
//                 )

//             [2] => Array
//                 (
//                     [0] => c@yahoo.com,
//                     [1] => 20
//                 )

//         )

//     [1] => Array
//         (
//             [0] => Array
//                 (
//                     [0] => a
//                     [1] => 0
//                 )

//             [1] => Array
//                 (
//                     [0] => b
//                     [1] => 9
//                 )

//             [2] => Array
//                 (
//                     [0] => c
//                     [1] => 20
//                 )

//         )

//     [2] => Array
//         (
//             [0] => Array
//                 (
//                     [0] => qq
//                     [1] => 2
//                 )

//             [1] => Array
//                 (
//                     [0] => sina
//                     [1] => 11
//                 )

//             [2] => Array
//                 (
//                     [0] => yahoo
//                     [1] => 22
//                 )

//         )

//     [3] => Array
//         (
//             [0] => Array
//                 (
//                     [0] => com
//                     [1] => 5
//                 )

//             [1] => Array
//                 (
//                     [0] => COM
//                     [1] => 16
//                 )

//             [2] => Array
//                 (
//                     [0] => com
//                     [1] => 28
//                 )

//         )

// )

preg_match("/(.*)@(.*)\.(.*),/iU", $str, $out);
print_r($out);
// Array
// (
//     [0] => a@qq.com,
//     [1] => a
//     [2] => qq
//     [3] => com
// )

preg_match("/(.*)@(.*)\.(.*),/iU", $str, $out, PREG_OFFSET_CAPTURE, 2);
print_r($out);
// Array
// (
//     [0] => Array
//         (
//             [0] => qq.com,b@sina.COM,
//             [1] => 2
//         )

//     [1] => Array
//         (
//             [0] => qq.com,b
//             [1] => 2
//         )

//     [2] => Array
//         (
//             [0] => sina
//             [1] => 11
//         )

//     [3] => Array
//         (
//             [0] => COM
//             [1] => 16
//         )

// )

print_r(preg_split("/@(.*)\.(.*),/iU", $str));
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
//     [3] => 一堆测试数据。Test Txt.
// )

print_r(preg_split("/@(.*)\.(.*),/iU", $str, 2, PREG_SPLIT_OFFSET_CAPTURE));
// Array
// (
//     [0] => Array
//         (
//             [0] => a
//             [1] => 0
//         )

//     [1] => Array
//         (
//             [0] => b@sina.COM,c@yahoo.com,一堆测试数据。Test Txt.
//             [1] => 9
//         )

// )






echo preg_replace("/@(.*)\.(.*),/iU", '@$1.$2.cn, ',$str), PHP_EOL;
// a@qq.com.cn, b@sina.COM.cn, c@yahoo.com.cn, 一堆测试数据。Test Txt.

echo preg_replace("/[\x{4E00}-\x{9FFF}]+/u", 'Many Test Info.',$str, -1, $count), PHP_EOL;
echo $count, PHP_EOL;
// a@qq.com,b@sina.COM,c@yahoo.com,Many Test Info.。Test Txt.
// 3

echo preg_replace("/@(.*)\.(.*),/iU", '@$1.$2.cn, ',$str, 2, $count), PHP_EOL;
echo $count, PHP_EOL;
// a@qq.com.cn, b@sina.COM.cn, c@yahoo.com,一堆测试数据。Test Txt.
// 2

echo preg_filter("/@(.*)\.(.*),/iU", '@$1.$2.cn, ',$subStr), PHP_EOL;

$subject = array('1', 'a', '2', 'b', '3', 'A', 'B', '4'); 
$pattern = array('/\d/', '/[a-z]/', '/[1a]/'); 
$replace = array('A:$0', 'B:$0', 'C:$0'); 

echo "preg_filter 的结果：", PHP_EOL;
print_r(preg_filter($pattern, $replace, $subject)); 
// preg_filter 的结果：
// Array
// (
//     [0] => A:C:1
//     [1] => B:C:a
//     [2] => A:2
//     [3] => B:b
//     [4] => A:3
//     [7] => A:4
// )

echo "preg_replace 的结果：", PHP_EOL;
print_r(preg_replace($pattern, $replace, $subject));
// preg_replace 的结果：
// Array
// (
//     [0] => A:C:1
//     [1] => B:C:a
//     [2] => A:2
//     [3] => B:b
//     [4] => A:3
//     [5] => A
//     [6] => B
//     [7] => A:4
// )

print_r(preg_replace_callback($pattern, function($matches){
    print_r($matches);
    return strtolower($matches[0]);
}, $subject));
// Array
// (
//     [0] => 1
// )
// Array
// (
//     [0] => 1
// )
// Array
// (
//     [0] => a
// )
// Array
// (
//     [0] => a
// )
// Array
// (
//     [0] => 2
// )
// Array
// (
//     [0] => b
// )
// Array
// (
//     [0] => 3
// )
// Array
// (
//     [0] => 4
// )
// Array
// (
//     [0] => 1
//     [1] => a
//     [2] => 2
//     [3] => b
//     [4] => 3
//     [5] => A
//     [6] => B
//     [7] => 4
// )

print_r(preg_replace_callback('/(.*)@(.*)\.(.*),/iU', function($matches){
    return strtoupper($matches[0]);
}, $str));
// A@QQ.COM,B@SINA.COM,C@YAHOO.COM,一堆测试数据。Test Txt.

print_r(preg_replace_callback_array(
    [
        '/(.*)@(.*)\.(.*),/iU' => function ($matches) {
            echo 'one:', $matches[0], PHP_EOL;
            return strtoupper($matches[0]);
        },
        '/Test Txt./iU' => function ($matches) {
            echo 'two:', $matches[0], PHP_EOL;
            return strtoupper($matches[0]);
        }
    ],
    $str
));
// one:a@qq.com,
// one:b@sina.COM,
// one:c@yahoo.com,
// two:Test Txt.
// A@QQ.COM,B@SINA.COM,C@YAHOO.COM,一堆测试数据。TEST TXT.

print_r(preg_grep("/\d/", [$str]));
// Array
// (
// )

print_r(preg_grep("/\d/", [$str], PREG_GREP_INVERT));
// Array
// (
//     [0] => a@qq.com,b@sina.COM,c@yahoo.com,一堆测试数据。Test Txt.
// )

print_r(preg_quote("(.*).(.*),"));
// \(\.\*\)\.\(\.\*\),


preg_match("///", $str);

print_r(preg_last_error()); 
// Warning: preg_match(): Delimiter must not be alphanumeric or backslash in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/03/source/6.PHP中PRGE正则函数的学习.php on line 332
// 1
// print_r(preg_last_error_msg());  // php8
