<?php

print_r($argv);
$input = $argv[1];

// 数字和字母，不包含浮点数， [A-Za-z0-9]
if(ctype_alnum($input)){
    echo $input, '是英文数字的组合字符！', PHP_EOL;
}

// 英文字母， [A-Za-z]
if(ctype_alpha($input)){
    echo $input, '是英文字母！', PHP_EOL;
}

// 数字字符，不包含浮点数、负数（无符号正整数）
if(ctype_digit($input)){
    echo $input, '是数字字符！', PHP_EOL;
}

// 小写字母
if(ctype_lower($input)){
    echo $input, '是小写字母字符！', PHP_EOL;
}

// 大写字母
if(ctype_upper($input)){
    echo $input, '是大写字母字符！', PHP_EOL;
}

// 所有可打印字符
if(ctype_print($input)){
    echo $input, '是可打印字符！', PHP_EOL;
}

// 所有字符都是可见的，除了空格或者格式控制这些不可见的
if(ctype_graph($input)){
    echo $input, '是可打印字符，除空白字符！', PHP_EOL;
}

// 不包含空白、字母、数字的可打印字符 英文标点符号类
if(ctype_punct($input)){
    echo $input, '是不包含空白、字母、数字的可打印字符！', PHP_EOL;
}

// \n \t \r 之类
if(ctype_cntrl($input)){
    echo $input, '是格式控制字符！', PHP_EOL;
}

// 空格
if(ctype_space($input)){
    echo $input, '是空格字符！', PHP_EOL;
}

// 16进制 AB10BC99
if(ctype_xdigit($input)){
    echo $input, '是十六进制字符！', PHP_EOL;
}


// ctype_digit 与 is_numeric 的区别
$numeric_string = '42';
$integer        = 42;

echo ctype_digit($numeric_string), PHP_EOL;  // true
echo ctype_digit($integer), PHP_EOL;         // false (ASCII 42 is the * character)

echo is_numeric($numeric_string), PHP_EOL;   // true
echo is_numeric($integer), PHP_EOL;          // true

