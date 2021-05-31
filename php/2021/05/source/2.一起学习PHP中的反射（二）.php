<?php

interface iA{

}

class A{

    /**
     * This is ONE DOC.
     */
    const ONE = 'number 1';
    
    // This is TWO DOC.
    private const TWO = 'number 2';

    /**
     * This is a DOC.
     */
    private $a = '1';
    
    // This is b DOC.
    protected $b = '2';

    /* This is c DOC. */
    public $c = '3';

    public $d;

    static $e = '5';
    static $f;

    public function __construct(){
        echo 'This is Class A, function Constructor.', PHP_EOL;
    }


    private function testA(){
        echo 'This is class A, function testA', PHP_EOL;
    }

    protected function testB(){
        echo 'This is class A, function testB', PHP_EOL;
    }

    public function testC(){
        echo 'This is class A, function testC', PHP_EOL;
    }
}

/**
 * This is Class B ，extends from A.
 * 
 * @author zyblog
 */
class B extends A {
    
}


class C implements iA{

}

$objA = new ReflectionClass('A');
$objB = new ReflectionClass('B');
$objC = new ReflectionClass('C');

// 类的构造函数
var_dump($objA->getConstructor());
// object(ReflectionMethod)#2 (2) {
//     ["name"]=>
//     string(11) "__construct"
//     ["class"]=>
//     string(1) "A"
//   }

var_dump($objB->getConstructor());
// object(ReflectionMethod)#3 (2) {
//     ["name"]=>
//     string(11) "__construct"
//     ["class"]=>
//     string(1) "A"
//   }

var_dump($objC->getConstructor()); // NULL

// 类的注释
var_dump($objB->getDocComment());
// string(67) "/**
//  * This is Class B ，extends from A.
//  * 
//  * @author zyblog
//  */"

var_dump($objA->getFileName());
// string(105) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/2.一起学习PHP中的反射（二）.php"

var_dump($objA->getName()); // string(1) "A"



var_dump($objC->getInterfaceNames());
// array(1) {
//     [0]=>
//     string(2) "iA"
//   }

var_dump($objC->getInterfaces());
// array(1) {
//     ["iA"]=>
//     object(ReflectionClass)#4 (1) {
//       ["name"]=>
//       string(2) "iA"
//     }
//   }

var_dump($objB->getParentClass());
// object(ReflectionClass)#4 (1) {
//     ["name"]=>
//     string(1) "A"
//   }

// 反射类开始结束行数
var_dump($objB->getEndLine()); // int(54)
var_dump($objC->getStartLine()); // int(56)

// 获取反射类所属扩展信息

var_dump((new ReflectionClass('ReflectionClass'))->getExtension());
// object(ReflectionExtension)#5 (1) {
//     ["name"]=>
//     string(10) "Reflection"
//   }
var_dump((new ReflectionClass('PDO'))->getExtensionName()); // string(3) "PDO"

$objExt = (new ReflectionClass('ReflectionClass'))->getExtension();

var_dump($objExt->getClassNames());
// array(16) {
//     [0]=>
//     string(19) "ReflectionException"
//     [1]=>
//     string(10) "Reflection"
//     [2]=>
//     string(9) "Reflector"
//     [3]=>
//     string(26) "ReflectionFunctionAbstract"
//     [4]=>
//     string(18) "ReflectionFunction"
//     [5]=>
//     string(19) "ReflectionGenerator"
//     [6]=>
//     string(19) "ReflectionParameter"
//     [7]=>
//     string(14) "ReflectionType"
//     [8]=>
//     string(19) "ReflectionNamedType"
//     [9]=>
//     string(16) "ReflectionMethod"
//     [10]=>
//     string(15) "ReflectionClass"
//     [11]=>
//     string(16) "ReflectionObject"
//     [12]=>
//     string(18) "ReflectionProperty"
//     [13]=>
//     string(23) "ReflectionClassConstant"
//     [14]=>
//     string(19) "ReflectionExtension"
//     [15]=>
//     string(23) "ReflectionZendExtension"
//   }

var_dump($objExt->getClasses());
// array(16) {
//     ["ReflectionException"]=>
//     object(ReflectionClass)#5 (1) {
//       ["name"]=>
//       string(19) "ReflectionException"
//     }
//     ["Reflection"]=>
//     object(ReflectionClass)#6 (1) {
//       ["name"]=>
//       string(10) "Reflection"
//     }
//     ["Reflector"]=>
//     object(ReflectionClass)#7 (1) {
//       ["name"]=>
//       string(9) "Reflector"
//     }
//     ["ReflectionFunctionAbstract"]=>
//     object(ReflectionClass)#8 (1) {
//       ["name"]=>
//       string(26) "ReflectionFunctionAbstract"
//     }
//     ["ReflectionFunction"]=>
//     object(ReflectionClass)#9 (1) {
//       ["name"]=>
//       string(18) "ReflectionFunction"
//     }
//     ["ReflectionGenerator"]=>
//     object(ReflectionClass)#10 (1) {
//       ["name"]=>
//       string(19) "ReflectionGenerator"
//     }
//     ["ReflectionParameter"]=>
//     object(ReflectionClass)#11 (1) {
//       ["name"]=>
//       string(19) "ReflectionParameter"
//     }
//     ["ReflectionType"]=>
//     object(ReflectionClass)#12 (1) {
//       ["name"]=>
//       string(14) "ReflectionType"
//     }
//     ["ReflectionNamedType"]=>
//     object(ReflectionClass)#13 (1) {
//       ["name"]=>
//       string(19) "ReflectionNamedType"
//     }
//     ["ReflectionMethod"]=>
//     object(ReflectionClass)#14 (1) {
//       ["name"]=>
//       string(16) "ReflectionMethod"
//     }
//     ["ReflectionClass"]=>
//     object(ReflectionClass)#15 (1) {
//       ["name"]=>
//       string(15) "ReflectionClass"
//     }
//     ["ReflectionObject"]=>
//     object(ReflectionClass)#16 (1) {
//       ["name"]=>
//       string(16) "ReflectionObject"
//     }
//     ["ReflectionProperty"]=>
//     object(ReflectionClass)#17 (1) {
//       ["name"]=>
//       string(18) "ReflectionProperty"
//     }
//     ["ReflectionClassConstant"]=>
//     object(ReflectionClass)#18 (1) {
//       ["name"]=>
//       string(23) "ReflectionClassConstant"
//     }
//     ["ReflectionExtension"]=>
//     object(ReflectionClass)#19 (1) {
//       ["name"]=>
//       string(19) "ReflectionExtension"
//     }
//     ["ReflectionZendExtension"]=>
//     object(ReflectionClass)#20 (1) {
//       ["name"]=>
//       string(23) "ReflectionZendExtension"
//     }
//   }

var_dump($objExt->getConstants());
// array(0) {
// }

var_dump((new ReflectionExtension('DOM'))->getConstants());
// array(45) {
//   ["XML_ELEMENT_NODE"]=>
//   int(1)
//   ["XML_ATTRIBUTE_NODE"]=>
//   int(2)
//   ……………………
//   ……………………
//   ……………………
//   ["DOM_NAMESPACE_ERR"]=>
//   int(14)
//   ["DOM_INVALID_ACCESS_ERR"]=>
//   int(15)
//   ["DOM_VALIDATION_ERR"]=>
//   int(16)
// }


var_dump($objExt->getDependencies());
// array(0) {
// }

var_dump((new ReflectionExtension('PDO'))->getDependencies());
// array(1) {
//     ["spl"]=>
//     string(8) "Required"
//   }

var_dump($objExt->getFunctions());
// array(0) {
// }

var_dump((new ReflectionExtension('fileinfo'))->getFunctions());
// array(6) {
//     ["finfo_open"]=>
//     object(ReflectionFunction)#19 (1) {
//       ["name"]=>
//       string(10) "finfo_open"
//     }
//     ["finfo_close"]=>
//     object(ReflectionFunction)#18 (1) {
//       ["name"]=>
//       string(11) "finfo_close"
//     }
//     ["finfo_set_flags"]=>
//     object(ReflectionFunction)#17 (1) {
//       ["name"]=>
//       string(15) "finfo_set_flags"
//     }
//     ["finfo_file"]=>
//     object(ReflectionFunction)#16 (1) {
//       ["name"]=>
//       string(10) "finfo_file"
//     }
//     ["finfo_buffer"]=>
//     object(ReflectionFunction)#15 (1) {
//       ["name"]=>
//       string(12) "finfo_buffer"
//     }
//     ["mime_content_type"]=>
//     object(ReflectionFunction)#14 (1) {
//       ["name"]=>
//       string(17) "mime_content_type"
//     }
//   }

var_dump($objExt->getINIEntries());
// array(0) {
// }

var_dump((new ReflectionExtension('mysqli'))->getINIEntries());
// array(11) {
//     ["mysqli.max_links"]=>
//     string(2) "-1"
//     ["mysqli.max_persistent"]=>
//     string(2) "-1"
//     ["mysqli.allow_persistent"]=>
//     string(1) "1"
//     ["mysqli.rollback_on_cached_plink"]=>
//     string(1) "0"
//     ["mysqli.default_host"]=>
//     NULL
//     ["mysqli.default_user"]=>
//     NULL
//     ["mysqli.default_pw"]=>
//     NULL
//     ["mysqli.default_port"]=>
//     string(4) "3306"
//     ["mysqli.default_socket"]=>
//     string(21) "/var/mysql/mysql.sock"
//     ["mysqli.reconnect"]=>
//     string(1) "0"
//     ["mysqli.allow_local_infile"]=>
//     string(1) "0"
//   }

var_dump($objExt->getName()); // string(10) "Reflection"
var_dump($objExt->getVersion()); // string(38) "7.3.24-(to be removed in future macOS)"

$objExt->info();
// Reflection

// Reflection => enabled

var_dump($objExt->isPersistent()); // bool(true)
var_dump($objExt->isTemporary()); // bool(false)

