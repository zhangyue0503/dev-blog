<?php

try {
    test();
} catch (Throwable $e) {
    print_r($e);
}

echo '未定义test()', PHP_EOL;

try {
    new PDO();
} catch (ArgumentCountError $e) {
    print_r($e);
}

echo '没给PDO参数', PHP_EOL;

function test1(): int
{
    return 'test';
}
try {
    test1();
} catch (TypeError $e) {
    print_r($e);
}

echo '返回值类型不正确', PHP_EOL;

// set_exception_handler(function ($ex) {
//     echo 'set_exception_handler：', PHP_EOL;
//     print_r($ex);

// });
// test();
// echo 'Not Execute...';

set_error_handler(function ($errno, $errmsg) {
    if($errmsg == 'Division by zero'){
        throw new DivisionByZeroError();
    }else{
        throw new Error($errmsg, $errno + 10000);
    }
});

try{
    100 / 0; // DivisionByZeroError：DivisionByZeroError Object
    echo $f; // Error: code = 10008
}catch(DivisionByZeroError $e){
    echo 'DivisionByZeroError：'; 
    print_r($e);
}catch(Error $e){
    echo 'Error'; 
    print_r($e);
}

