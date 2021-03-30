<?php

$str = "abcdefGHIjklMnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ";
$strC = "测试中文数据";



// 替换1
echo strtr($str, 'abc', 'cba'), PHP_EOL; // cbadefGHIjklMnOpQRSTUVWXYZcbadefGHIjklMnOpQRSTUVWXYZ

$helloStr = "hi all, I said hello";
echo strtr($helloStr, ["hello" => "hi", "hi" => "hello"]), PHP_EOL; // hello all, I said hi 
echo str_replace(["hello", "hi"], ["hi", "hello"], $helloStr), PHP_EOL; // hello all, I said hello

// 获取字符串
echo strtok($str, 'c'), PHP_EOL; // ab
echo strtok($str, 'H'), PHP_EOL; // abcdefG

echo strstr($str, "Mn"), PHP_EOL; // MnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ
echo strstr($str, "Mn", true), PHP_EOL; // abcdefGHIjkl

echo stristr($str, "mn"), PHP_EOL; // MnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ


echo strrchr($str, "Mn"), PHP_EOL; // MnOpQRSTUVWXYZ

echo strpbrk($str, "AVM"), PHP_EOL; // MnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ


// 查找字符串位置

echo strspn($str, 'VWXYZabcde'), PHP_EOL; // 5
echo strspn("42 is the answer to the 128th question.", "1234567890 is "), PHP_EOL; // 6

echo strcspn($str, 'VWXYZabcde'), PHP_EOL; // 0
echo strcspn($str, 'VWXYZ'), PHP_EOL; // 21

echo strpos($str, 'cd'), PHP_EOL; // 2
echo strpos($str, 'abcd'), PHP_EOL; // 0
if(strpos($str, 'abcd')!==false){
    echo '存在！', PHP_EOL;
}
// 存在！

echo strpos($str, 'cd', 3), PHP_EOL; // 28

var_dump(strpos($str, 'vwx')); // bool(false)
echo stripos($str, 'vwx'), PHP_EOL; // 21

echo strrpos($str, 'abc'), PHP_EOL; // 26
echo strripos($str, 'vwx'), PHP_EOL; // 47

// 比较字符串

var_dump(strcmp('Test', 'test')); // int(-32)
var_dump(strcmp('test', 'test')); // int(0)
var_dump(strcmp('test', 'Test')); // int(32)

var_dump(strcasecmp('Test', 'test')); // int(0)
var_dump(strcasecmp('Test', 'a test')); // int(19)

var_dump(strcmp('Test', 'Test a b', )); // int(-4)
var_dump(strncmp('Test', 'Test a b', 4)); // int(0)

var_dump(strncasecmp('Test', 'Test a b', 4)); // int(0)

var_dump(strcmp('test2.png', 'test10.png')); // int(1)
var_dump(strnatcmp('test2.png', 'test10.png')); // int(-1)

$arr1 = $arr2 = array("img12.png", "img10.png", "img2.png", "img1.png");
echo "Standard string comparison\n";
usort($arr1, "strcmp");
print_r($arr1);
// Standard string comparison
// Array
// (
//     [0] => img1.png
//     [1] => img10.png
//     [2] => img12.png
//     [3] => img2.png
// )

echo "\nNatural order string comparison\n";
usort($arr2, "strnatcmp");
print_r($arr2);
// Natural order string comparison
// Array
// (
//     [0] => img1.png
//     [1] => img2.png
//     [2] => img10.png
//     [3] => img12.png
// )


// 长度
echo strlen($str), PHP_EOL; // 52

// 简单入门PHP中的多字节字符串操作
echo strlen($strC), PHP_EOL; // 18
echo mb_strlen($strC), PHP_EOL; // 6

// 大小写
echo strtolower($str), PHP_EOL; // abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
echo strtoupper($str), PHP_EOL; // ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ

// 反转字符串

echo strrev($str), PHP_EOL; // ZYXWVUTSRQpOnMlkjIHGfedcbaZYXWVUTSRQpOnMlkjIHGfedcba

// 转义斜杠
$sql = "select * from a where a='1' and b = '2'";
echo addslashes($sql), PHP_EOL; // select * from a where a=\'1\' and b = \'2\'
echo stripcslashes(addslashes($sql)), PHP_EOL; // select * from a where a='1' and b = '2'
echo stripslashes(addslashes($sql)), PHP_EOL; // select * from a where a='1' and b = '2'

// 去除 html 和 php 标记
$text = '<p>Test paragraph.</p><!-- Comment --><?php echo 1;?> <br/><a href="#fragment">Other text</a>';
echo strip_tags($text), PHP_EOL;
// Test paragraph. Other text

echo strip_tags($text, '<br>'), PHP_EOL;
// Test paragraph. <br/>Other text



// echo str_replace('abc', 'cba', $str, $count), PHP_EOL; // cbadefGHIjklMnOpQRSTUVWXYZcbadefGHIjklMnOpQRSTUVWXYZ
// echo $count, PHP_EOL; // 2


