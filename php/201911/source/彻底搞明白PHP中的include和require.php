<?php

// include "a.php"; // warning
// require "a.php"; // error

// echo 111; // 使用include时111会输出

// require_once 'includeandrequire/file1.php'; // file1
// require_once 'includeandrequire/file1.php'; // noting

// include_once 'includeandrequire/file1.php'; // noting
// include_once 'includeandrequire/file1.php'; // noting

// require 'includeandrequire/file1.php'; // file1
// require 'includeandrequire/file1.php'; // file1

// require 'includeandrequire/file1.php'; // file1
// require 'includeandrequire/file1.php'; // file1

// $a = 'myFile';
// $b = 'youFile';
// require_once 'includeandrequire/file2.php';
// echo $a, PHP_EOL; // myFile
// echo $b, PHP_EOL; // file2


// function test(){
//     require_once 'includeandrequire/file3.php';
//     echo $c, PHP_EOL; // file3
// }
// test();
// echo $c, PHP_EOL; // empty


// function foo(){
//     require_once('includeandrequire/file3.php');
//     return $c;
// }

// for($a=1;$a<=5;$a++){
//     echo foo(), PHP_EOL;
// }

// function test1(){
//     require_once('includeandrequire/file1.php');
// }
// function test2(){
//     require_once('includeandrequire/file1.php');
// }
// test1();
// test2();

// $v = require 'includeandrequire/file4.php';
// echo $v, PHP_EOL; // file4

// include 'includeandrequire/file4.txt';
// // 可以吧

// include 'https://www.baidu.com/index.html';
// // 百度首页的html代码


function include_all_once ($pattern) {
    foreach (glob($pattern) as $file) { 
        require $file;
    }
}

include_all_once('includeandrequire/*');