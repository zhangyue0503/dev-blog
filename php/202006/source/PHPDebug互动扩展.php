<?php

// echo 111;
// phpdbg_break_file("PHPDebug互动扩展.php", 3);

// echo 222;
// phpdbg_break_file("PHPDebug互动扩展.php", 6);

$i = 1;
// phpdbg -e PHP\ Debug互动扩展.php
function testFunc(){
    global $i;
    $i += 3;
    echo "This is testFunc! i：" . $i, PHP_EOL;
}

testFunc();
// phpdbg_break_function('testFunc');

// // phpdbg_break_next();

// class A{
//     function testFuncA(){
//         echo "This is class A testFuncA!", PHP_EOL;
//     }
// }
// $a = new A;
// $a->testFuncA();
// phpdbg_break_method('A', 'testFuncA');

