<?php



// 创建匿名函数
$func = create_function('$a, $b', 'return $a+$b;');
echo $func(1,2), PHP_EOL; // 3

$func = function($a, $b){
    return $a+$b;
};
echo $func(1, 2), PHP_EOL; // 3

// 函数参数操作
function test($a, $b){
    var_dump(func_get_args());

    var_dump(func_num_args());

    var_dump(func_get_arg(1));
}

test(1,2,3);
// array(3) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//   }

// int(3)

// int(3)

// 判断函数是否存在
var_dump(function_exists('test')); // bool(true)
var_dump(function_exists('test1')); // bool(false)

var_dump(function_exists('str_replace')); // bool(true)

// 获得全部已定义的函数
var_dump(get_defined_functions());
// array(2) {
//     ["internal"]=>
//     array(1544) {
//       [0]=>
//       string(12) "zend_version"
//       [1]=>
//       string(13) "func_num_args"
//       [2]=>
//       string(12) "func_get_arg"
//       [3]=>
//       string(13) "func_get_args"
//       [4]=>
//       string(6) "strlen"
//       [5]=>
//       string(6) "strcmp"
//       …………………………
//       …………………………
//       …………………………
//       …………………………
//       [1540]=>
//       string(15) "xmlwriter_flush"
//       [1541]=>
//       string(2) "dl"
//       [1542]=>
//       string(21) "cli_set_process_title"
//       [1543]=>
//       string(21) "cli_get_process_title"
//     }
//     ["user"]=>
//     array(1) {
//       [0]=>
//       string(4) "test"
//     }
//   }



// 在 PHP 中止时运行的函数
register_shutdown_function(function(){
    echo join(func_get_args(), ',');
}, 1, 2);
// 1,2