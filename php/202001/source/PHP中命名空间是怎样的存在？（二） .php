<?php

namespace Pro;
// 子命名空间
require 'namespace/file3-1.php';
require 'namespace/file3-2.php';
require 'namespace/file3-2-1.php';

use MyProject\FILE31;
use MyProject\FILE32;
use MyProject\FILE32\FILE321;

FILE31\testA31(); // FILE31\testA()
FILE32\testA32(); // FILE32\testA()
FILE32\FILE321\testA321(); // FILE321\testA()
FILE321\testA321(); // FILE321\testA()


// 一个文件中多个命名空间
require 'namespace/file4.php';

use FILE41, FILE42;

FILE41\testA41(); // FILE41\testA()
FILE42\testA42(); // FILE42\testA()

// 非限定名称、限定名称、完全限定名称

use MyProject\FILE32\objectA32 as obj32;

$o = new obj32(); // 非限定名称
$o->test(); // FILE32\ObjectA

$o = new FILE32\objectA32(); // 限定名称
$o->test(); // FILE32\ObjectA

$o = new \MyProject\FILE32\objectA32(); // 完全限定名称
$o->test(); // FILE32\ObjectA

// namespace与__NAMESPACE__

require 'namespace/file5.php';

function test(){
    echo __NAMESPACE__ . ': test()', PHP_EOL;
}

namespace\test(); // Pro: test()

\FILE5\test(); // FILE5: test()











