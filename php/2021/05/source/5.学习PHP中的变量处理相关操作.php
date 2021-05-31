<?php

$a = 1;
$b = '2.2';
$c = true;

// 类型转换
var_dump(boolval($a));
var_dump(doubleval($b));
var_dump(floatval($b));
var_dump(intval($b));
var_dump(strval($c));
// bool(true)
// float(2.2)
// float(2.2)
// int(2)
// string(1) "1"


var_dump((bool)$a);
var_dump((double)$b);
var_dump((float)$b);
var_dump((int)$b);
var_dump((string)$c);
var_dump((array)$c);
var_dump((object)$c);
// bool(true)
// float(2.2)
// float(2.2)
// int(2)
// string(1) "1"
// array(1) {
//   [0]=>
//   bool(true)
// }
// object(stdClass)#1 (1) {
//   ["scalar"]=>
//   bool(true)
// }

// 设置类型及获取变量类型信息
$d = 1;
settype($d, 'array');
var_dump($d);
// array(1) {
//     [0]=>
//     int(1)
//   }

$d = 1;
var_dump((array)$d);
// array(1) {
//     [0]=>
//     int(1)
//   }

var_dump(array($d));
// array(1) {
//     [0]=>
//     int(1)
//   }

var_dump(gettype($d)); // string(7) "integer"
// var_dump(get_debug_type($d)); // PHP8 string(3) "int"

// 判断变量是否存在及值的情况
var_dump(isset($e)); // bool(false)
$ee = '';
var_dump(isset($ee)); // bool(true)
unset($ee);
var_dump(isset($ee)); // bool(false)
$ee = NULL;
var_dump(isset($ee)); // bool(false)

// empty函数与直接if
$e;
if(empty($e)){
    echo 'empty';
}
if(!$e){
    echo 'empty';
}
// empty
// empty

// empty 判断条件
// "" (空字符串)
// 0 (作为整数的0)
// 0.0 (作为浮点数的0)
// "0" (作为字符串的0)
// null
// false
// array() (一个空数组)
// $var; (一个声明了，但是没有值的变量)

// 转换为布尔型
// 布尔值 false 本身
// 整型值 0（零）及 -0 (零)
// 浮点型值 0.0（零）-0.0(零)
// 空字符串，以及字符串 "0"
// 不包括任何元素的数组
// 特殊类型 NULL（包括尚未赋值的变量）
// 从空标记生成的 SimpleXML 对象

// 类型判断函数

$f = function(){};
var_dump(is_callable($f)); // emptyemptybool(true)

var_dump(is_countable($d)); // bool(false)
var_dump(is_countable((array)$d)); // bool(true)

class A implements Countable {
    public function count(){
        return 1;
    }
}
var_dump(is_countable(new A)); // bool(true)

var_dump(is_iterable($d)); // bool(false)
var_dump(is_iterable((array)$d)); // bool(true)
var_dump(is_iterable(new A)); // bool(false)
var_dump(is_iterable((function(){yield 1;})())); // bool(true)

var_dump(is_scalar($a)); // bool(true)
var_dump(is_scalar((array)$a)); // bool(false)

// 获取所有当前环境下的变量信息
var_dump(get_defined_vars());
// array(11) {
//     ["_GET"]=>
//     array(0) {
//     }
//     …………………………
//     …………………………
//     ["argv"]=>
//     array(1) {
//       [0]=>
//       string(108) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/5.学习PHP中的变量处理相关操作.php"
//     }
//     ["argc"]=>
//     int(1)
//     ["_SERVER"]=>
//     array(39) {
//       ["VSCODE_NODE_CACHED_DATA_DIR"]=>
//       string(100) "/Users/zhangyue/Library/Application Support/Code/CachedData/e713fe9b05fc24facbec8f34fb1017133858842b"
//       ["SHELL"]=>
//       string(8) "/bin/zsh"
//       …………………………
//       …………………………
//     }
//     ["a"]=>
//     int(1)
//     ["b"]=>
//     string(3) "2.2"
//     ["c"]=>
//     bool(true)
//     ["d"]=>
//     int(1)
//   }


// 变量引用信息查看
debug_zval_dump($b); // string(3) "2.2" refcount(1)
$b .= ' + 3.3';
$bb = $b;
debug_zval_dump($bb); // string(9) "2.2 + 3.3" refcount(3)

debug_zval_dump($a); // int(1)
$aa = &$a;
debug_zval_dump($a); // int(1)
debug_zval_dump($aa); // int(1)

// 句柄信息查看
$curl = curl_init();;
var_dump(get_resource_type($curl)); // string(4) "curl"

$fp = fopen("./4.一起学习PHP中的反射（四）.php", "w");
var_dump(get_resource_type($fp)); // string(6) "stream"

// var_dump(get_resource_id($curl)); // PHP8







