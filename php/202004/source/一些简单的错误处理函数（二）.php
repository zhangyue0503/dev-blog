<?php

error_reporting(E_ALL);

echo $a;
//  E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING 不能处理
set_error_handler(function($errno, $errstr, $errfile, $errline){
    echo "Has Error：", $errno, ',', $errstr, ',', $errfile, ',', $errline, PHP_EOL; 
}, E_ALL | E_STRICT);

echo $a;

restore_error_handler();

echo $a;

// set_exception_handler(function($ex){
//     echo "Has Exception: " , $ex->getMessage(), PHP_EOL;
// });

// throw new Exception('Init Error');

// set_exception_handler(function($ex){
//     echo "Has Exception First: " , $ex->getMessage(), PHP_EOL;
// });
// set_exception_handler(function($ex){
//     echo "Has Exception Second: " , $ex->getMessage(), PHP_EOL;
// });

// restore_exception_handler();

// throw new Exception('Init Error Next');


trigger_error("I'm Error One!"); // Notice: I'm Error One! 

set_error_handler(function($errno, $errstr, $errfile, $errline){
    echo "Has Error：", $errno, ',', $errstr, ',', $errfile, ',', $errline, PHP_EOL; 
}, E_ALL | E_STRICT);
trigger_error("I'm Error One!"); // Has Error：1024,I'm Error One!
trigger_error("I'm Error One!", E_USER_WARNING); // Has 512,I'm Error One!
trigger_error("I'm Error One!", E_USER_ERROR); // Has 256,I'm Error One!

trigger_error("I'm Error One!", E_WARNING); // Has Error：2,Invalid error type specified
