<?php

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_BAIL, 0);

// assert_options(ASSERT_CALLBACK, function($params){
//     echo "====faild====", PHP_EOL;
//     var_dump($params);
//     echo "====faild====", PHP_EOL;
// });

// assert(1!=1);
// ====faild====
// string(105) ".../source/一起学习PHP中断言函数的使用.php"
// ====faild====
// exit;

// assert(" ");
// Deprecated: assert(): Calling assert() with a string argument is deprecated
// Warning: assert(): Assertion " " failed

// assert("1");
// Deprecated: assert(): Calling assert() with a string argument is deprecated

// assert(0);
// Warning: assert(): assert(0) failed

// assert(1);

// assert("1==2");
// Deprecated: assert(): Calling assert() with a string argument is deprecated
// Warning: assert(): Assertion "1==2" failed 

// try{
//     assert(1==2,  new Exception("验证不通过"));
// }catch(Exception $e){
//     echo "验证失败！", $e->getMessage(), PHP_EOL;
// }

// assert(1==1,  new Exception("验证不通过"));

// assert(1==2,  new Exception("验证不通过"));
// Warning: assert(): Exception: 验证不通过

assert(1==1, "验证不通过");

assert(1==2, "验证不通过");
// Warning: assert(): 验证不通过 failed 


assert(1==1);

assert(1==2);
// Warning: assert(): assert(1 == 2)
// Fatal error: Uncaught AssertionError: 验证不通过


