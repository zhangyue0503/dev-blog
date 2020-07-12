<?php

define('A', 'TestA');

runkit_constant_redefine('A', 'NewTestA');

echo A; // NewTestA

// print_r(get_extension_funcs('runkit7'));

//
print_r(runkit_superglobals());
//Array
//(
//    [0] => GLOBALS
//    [1] => _GET
//    [2] => _POST
//    [3] => _COOKIE
//    [4] => _SERVER
//    [5] => _ENV
//    [6] => _REQUEST
//    [7] => _FILES
//    [8] => _SESSION
//)

function testme() {
  echo "Original Testme Implementation\n";
}
testme(); // Original Testme Implementation
runkit_function_redefine('testme','','echo "New Testme Implementation\n";');
testme(); // New Testme Implementation

// php.ini runkit.internal_override=1
runkit_function_redefine('str_replace', '', 'echo "str_replace changed!\n";');
str_replace(); // str_replace changed!

runkit_function_rename ('implode', 'joinArr' );
var_dump(joinArr(",", ['a', 'b', 'c'])); 
// string(5) "a,b,c"


array_map(function($v){
   echo $v,PHP_EOL;
},[1,2,3]);
// 1
// 2
// 3
runkit_function_remove ('array_map');

// array_map(function($v){
//   echo $v;
// },[1,2,3]);
// PHP Fatal error:  Uncaught Error: Call to undefined function array_map()


//runkit_method_add('PDO', 'testAddPdo', '', 'echo "This is PDO new Func!\n";');
//PDO::testAddPdo();
// PHP Warning:  runkit_method_add(): class PDO is not a user-defined class

class Example{
}

runkit_method_add('Example', 'func1', '', 'echo "This is Func1!\n";');
runkit_method_add('Example', 'func2', function(){
    echo "This is Func2!\n";
});
$e = new Example;
$e->func1(); // This is Func1!
$e->func2(); // This is Func2!

runkit_method_redefine('Example', 'func1', function(){
    echo "New Func1!\n";
});
$e->func1(); // New Func1!

runkit_method_rename('Example', 'func2', 'func22');
$e->func22(); // This is Func2!

runkit_method_remove('Example', 'func1');
//$e->func1();
// PHP Fatal error:  Uncaught Error: Call to undefined method Example::func1()