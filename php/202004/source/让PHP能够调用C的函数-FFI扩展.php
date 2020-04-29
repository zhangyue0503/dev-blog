<?php

// cd php-7.4.4/ext/ffi/
// phpize
// ./configure
// make && make install

// 创建一个 FFI 对象，加载 libc 并且导入 printf 函数
$ffi_printf = FFI::cdef(
    "int printf(const char *format, ...);", // C 的定义规则
    "libc.so.6"); // 指定 libc 库
// 调用 C 的 printf 函数
$ffi_printf->printf("Hello %s!\n", "world"); // Hello World

// 加载 math 并且导入 pow 函数
$ffi_pow = FFI::cdef(
    "double pow(double x, double y);", 
    "libboost_math_c99.so.1.66.0");
// 这里调用的是 C 的 pow 函数，不是 PHP 自己的
echo $ffi_pow->pow(2,3), PHP_EOL; // 8


// 创建一个 int 变量
$x = FFI::new("int");
var_dump($x->cdata); // int(0)

// 为变量赋值
$x->cdata = 5;
var_dump($x->cdata); // int(5)

// 计算变量
$x->cdata += 2;
var_dump($x->cdata); // int(7)


// 结合上面的两个 FFI 对象操作

echo "pow value:", $ffi_pow->pow($x->cdata, 3), PHP_EOL;
// pow value:343
$ffi_printf->printf("Int Pow value is : %f\n", $ffi_pow->pow($x->cdata, 3));
// Int Pow value is : 343.000000


// 创建一个数组
$a = FFI::new("long[1024]");
// 为数组赋值
for ($i = 0; $i < count($a); $i++) {
    $a[$i] = $i;
}
var_dump($a[25]); // int(25)

$sum = 0;
foreach ($a as $n) {
    $sum += $n;
}
var_dump($sum); // int(523776)

var_dump(count($a)); // int(1024) 数组长度
var_dump(FFI::sizeof($a)); // int(8192)，内存大小




