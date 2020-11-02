<?php

var_dump(copy('test.txt', 'cp_test.txt')); // bool(true)

var_dump(is_file("cp_test.txt")); // bool(true)

var_dump(move_uploaded_file('test.txt', 'mv_upload_test.txt')); // bool(false)
var_dump(is_file("mv_upload_test.txt")); // bool(false)
var_dump(is_uploaded_file("mv_upload_test.txt")); // bool(false)

var_dump(copy('test.txt', 're_test.txt')); // bool(true)
var_dump(rename('re_test.txt', 'new_re_test.txt')); // bool(true)

var_dump(copy('test.txt', 'del_test.txt')); // bool(true)
var_dump(unlink("del_test.txt")); // bool(true)

var_dump(is_dir("./")); // bool(true)
var_dump(disk_free_space("./")); // float(7727517696)
var_dump(disk_total_space("./")); // float(250790436864)

var_dump(mkdir("./a")); // bool(true)

realpath('./');
var_dump(realpath_cache_get());
// array(8) {
//     ["/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202010/source"]=>
//     array(4) {
//       ["key"]=>
//       float(1.4990943845035E+19)
//       ["is_dir"]=>
//       bool(true)
//       ["realpath"]=>
//       string(61) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202010/source"
//       ["expires"]=>
//       int(1603327834)
//     }
//     ["/Users/zhangyue/MyDoc/博客文章"]=>
//     array(4) {
//       ["key"]=>
//       int(8597410586338680)
//       ["is_dir"]=>
//       bool(true)
//       ["realpath"]=>
//       string(34) "/Users/zhangyue/MyDoc/博客文章"
//       ["expires"]=>
//       int(1603327834)
//     }
//     ["/Users"]=>
// ……
// ……

var_dump(realpath_cache_size()); // int(673)
var_dump(rmdir("./a"));  // bool(true)


var_dump(readlink('ltest2.txt')); // "test.txt"
var_dump(is_link('ltest2.txt')); // bool(true)

var_dump(file_exists('test.txt')); // bool(true)
var_dump(readfile('test.txt')); // asdfasdfint(8)
var_dump(file('test.txt'));
// array(1) {
//     [0]=>
//     string(8) "asdfasdf"
//   }

$c = file_get_contents('test.txt');
var_dump($c); // string(8) "asdfasdf"

var_dump(file_put_contents('fpc_test.txt', $c)); // int(8)

var_dump(fileatime('test.txt')); // int(1603243708)
var_dump(filectime('test.txt')); // int(1603242166)
var_dump(filemtime('test.txt')); // int(1603242166)

var_dump(fileinode('test.txt')); // int(8707958352)
var_dump(filesize('test.txt')); // int(8)
var_dump(filetype('test.txt')); // string(4) "file"

var_dump(is_executable('test.txt')); // bool(true)
var_dump(is_writable('test.txt')); // bool(true)
var_dump(is_readable('test.txt')); // bool(true)


var_dump(tempnam('./', 't_')); // string(70) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202010/source/t_Gx6S5d"


$temp = tmpfile();
fwrite($temp, "writing to tempfile");
fseek($temp, 0);
// sleep(30); // /tmp/phpU2LZ3V 文件
echo fread($temp, 1024), PHP_EOL; // writing to tempfile
fclose($temp); // 文件直接被删除了


foreach (glob("*.txt") as $filename) {
    echo "$filename size： " . filesize($filename) , PHP_EOL;
}
// cp_test.txt size 8
// fpc_test.txt size 8
// ltest.txt size 8
// ltest2.txt size 8
// new_re_test.txt size 8
// test.txt size 8
// test3.txt size 0

foreach (glob("../../202009/*.md") as $filename) {
    echo "$filename size： " . filesize($filename) , PHP_EOL;
}
// ./../202009/1.PHP中的PDO操作学习（三）预处理类及绑定数据.md size： 16881
// ../../202009/10.PHP中非常好玩的Calendar扩展学习.md size： 8784
// ../../202009/11.学习PHP中的国际化功能来查看货币及日期信息.md size： 5521
// ../../202009/12.PHP中的日期相关函数（一）.md size： 14217
// ../../202009/13.PHP中的日期相关函数（二）.md size： 9858
// ../../202009/2.PHP中的PDO操作学习（四）查询结构集.md size： 12825
// ../../202009/3.在PHP中使用SPL库中的对象方法进行XML与数组的转换.md size： 6068
// ../../202009/4.PHP中的MySQLi扩展学习（一）MySQLi介绍.md size： 6029
// ../../202009/5.PHP中的MySQLi扩展学习（二）mysqli类的一些少见的属性方法.md size： 9726
// ../../202009/6.PHP中的MySQLi扩展学习（三）mysqli的基本操作.md size： 9403
// ../../202009/7.PHP中的MySQLi扩展学习（四）mysqli的事务与预处理语句.md size： 3556
// ../../202009/8.PHP中的MySQLi扩展学习（五）MySQLI_STMT对象操作.md size： 7450
// ../../202009/9.PHP中的MySQLi扩展学习（六）MySQLI_result对象操作.md size： 10650

$old = umask(0);
echo $old, PHP_EOL; // 18
$now = umask();
echo $now, PHP_EOL; // 0


var_dump(parse_ini_file('/usr/local/etc/php/7.3/php.ini'));
// array(133) {
//     ["#zend_extension"]=>
//     string(9) "xdebug.so"
//     ["extension"]=>
//     string(6) "vld.so"
//     ["engine"]=>
// ……
// ……

var_dump(parse_ini_file('/usr/local/etc/php/7.3/php.ini', true));
// array(38) {
//     ["#zend_extension"]=>
//     string(9) "xdebug.so"
//     ["extension"]=>
//     string(6) "vld.so"
//     ["PHP"]=>
//     array(45) {
//       ["engine"]=>
//       string(1) "1"
//       ["short_open_tag"]=>
// ……
// ……

$ini = file_get_contents('/usr/local/etc/php/7.3/php.ini');
var_dump(parse_ini_string($ini));
// array(133) {
//     ["#zend_extension"]=>
//     string(9) "xdebug.so"
//     ["extension"]=>
//     string(6) "vld.so"
//     ["engine"]=>
// ……
// ……

var_dump(parse_ini_string($ini, true));
// array(38) {
//     ["#zend_extension"]=>
//     string(9) "xdebug.so"
//     ["extension"]=>
//     string(6) "vld.so"
//     ["PHP"]=>
//     array(45) {
//       ["engine"]=>
//       string(1) "1"
//       ["short_open_tag"]=>
// ……
// ……

