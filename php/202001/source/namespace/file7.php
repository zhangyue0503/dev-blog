<?php

namespace FILE7;

// 类必须使用完全限定的全局空间
$o1 = new \stdClass();
// $o2 = new stdClass(); // Fatal error: Uncaught Error: Class 'FILE7\stdClass' not found

// 方法会先在本命名空间查找，如果没找到会去全局找
function strlen($str)
{
    return __NAMESPACE__ . '：' . (\strlen($str) - 1);
}
echo strlen('abc'), PHP_EOL; // FILE7：2 
echo \strlen('abc'), PHP_EOL; // 3

echo strtoupper('abc'), PHP_EOL; // ABC

// 常量也是有后备能力的

const E_ERROR = 22; 
echo E_ERROR, PHP_EOL; // 22
echo \E_ERROR, PHP_EOL; // 1

echo INI_ALL, PHP_EOL; // 7
