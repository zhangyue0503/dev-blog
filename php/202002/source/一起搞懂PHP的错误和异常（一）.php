<?php
error_reporting(E_ALL);

// 捕获不了E_ERROR类的错误
set_error_handler(function( $errno , $errstr ){
    echo 'set_error_handler：', $errno, $errstr, PHP_EOL;
});

register_shutdown_function(function(){
    echo 'register_shutdown_function：', PHP_EOL;
    print_r(error_get_last());
});

// test(a+-); // Parse error: syntax error, unexpected ')' 

$a = 100 / 0; // Warning: Division by zero
echo $f; // Notice: Undefined variable: f 
test(); // Fatal error: Uncaught Error: Call to undefined function test()

echo 1;

try {
    $a = 100 / 0; // Warning: Division by zero
    echo $f; // Notice: Undefined variable: f 
} catch (Excepiton $e) {
    print_r($e); // 无法捕获
} 

test(); // Fatal error: Uncaught Error: Call to undefined function test() 


