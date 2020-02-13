<?php

function test()
{
    throw new Exception('This is test Error...');
}

try {
    test();
} catch (Exception $e) {
    print_r($e);
}

try {
    // $pdo = new PDO(); // Fatal error: Uncaught ArgumentCountError: PDO::__construct() expects at least 1 parameter, 0 given
    $pdo = new PDO('');
} catch (PDOException $e) {
    print_r($e); // invalid data source name
}

class TestException extends Exception
{
    protected $code = 200;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message = 'TestException：' . $message;
    }

    public function __toString()
    {
        return 'code: ' . $this->code . '; ' . $this->message;
    }
}

function test2()
{
    throw new TestException('This is test2 Error...');
}

try {
    test2();
} catch (TestException $e) {
    echo $e, PHP_EOL; // code: 200; TestException：This is test2 Error...
}

try {
    test2();
} catch (TestException $e) {
    echo $e, PHP_EOL; // code: 200; TestException：This is test2 Error...
} finally {
    echo 'continue this code ...', PHP_EOL;
}

// test2(); // Fatal error: Uncaught TestException: This is test2 Error...

function test3($d)
{
    if ($d == 0) {
        throw new Exception('除数不能为0');
    }
    return 1 / $d;
}

try {
    echo test3(2), PHP_EOL;
} catch (Exception $e) {
    echo 'Excepition：' . $e->getMessage(), PHP_EOL;
} finally {
    echo 'finally：继续执行！', PHP_EOL;
}

// 0.5
// finally：继续执行！

try {
    echo test3(0), PHP_EOL;
} catch (Exception $e) {
    echo 'Excepition：' . $e->getMessage(), PHP_EOL;
} finally {
    echo 'finally：继续执行！', PHP_EOL;
}

// Excepition：除数不能为0
// finally：继续执行！
