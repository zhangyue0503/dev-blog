<?php

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

ReflectionClass::export(new ReflectionClass('A'));
// Class [ <internal:Reflection> class ReflectionClass implements Reflector ] {

//     - Constants [3] {
//       Constant [ public int IS_IMPLICIT_ABSTRACT ] { 16 }
//       Constant [ public int IS_EXPLICIT_ABSTRACT ] { 32 }
//       Constant [ public int IS_FINAL ] { 4 }
//     }
  
//     - Static properties [0] {
//     }
  
//     - Static methods [1] {
//       Method [ <internal:Reflection, prototype Reflector> static public method export ] {
  
//         - Parameters [2] {
//           Parameter #0 [ <required> $argument ]
//           Parameter #1 [ <optional> $return ]
//         }
//       }
//     }
  
//     - Properties [1] {
//       Property [ <default> public $name ]
//     }

//  ……………………………………
//  ……………………………………
//  ……………………………………
//  ……………………………………
  
//       Method [ <internal:Reflection> public method getExtension ] {
  
//         - Parameters [0] {
//         }
//       }
  
//       Method [ <internal:Reflection> public method getExtensionName ] {
  
//         - Parameters [0] {
//         }
//       }
  
//       Method [ <internal:Reflection> public method inNamespace ] {
  
//         - Parameters [0] {
//         }
//       }
  
//       Method [ <internal:Reflection> public method getNamespaceName ] {
  
//         - Parameters [0] {
//         }
//       }
  
//       Method [ <internal:Reflection> public method getShortName ] {
  
//         - Parameters [0] {
//         }
//       }
//     }
//   }


$obj = new ReflectionClass('A');
echo $obj;
// Class [ <user> class A ] {
//     @@ /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/1.一起学习PHP中的反射（一）.php 3-41
  
//     - Constants [2] {
//       Constant [ public string ONE ] { number 1 }
//       Constant [ private string TWO ] { number 2 }
//     }
  
//     - Static properties [2] {
//       Property [ public static $e ]
//       Property [ public static $f ]
//     }
  
//     - Static methods [0] {
//     }
  
//     - Properties [4] {
//       Property [ <default> private $a ]
//       Property [ <default> protected $b ]
//       Property [ <default> public $c ]
//       Property [ <default> public $d ]
//     }
  
//     - Methods [3] {
//       Method [ <user> private method testA ] {
//         @@ /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/1.一起学习PHP中的反射（一）.php 30 - 32
//       }
  
//       Method [ <user> protected method testB ] {
//         @@ /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/1.一起学习PHP中的反射（一）.php 34 - 36
//       }
  
//       Method [ <user> public method testC ] {
//         @@ /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/1.一起学习PHP中的反射（一）.php 38 - 40
//       }
//     }
//   }


// 常量操作
print_r($obj->getConstants());
// Array
// (
//     [ONE] => number 1
//     [TWO] => number 2
// )

echo $obj->getConstant('ONE'), PHP_EOL;// number 1

var_dump($obj->hasConstant('TWO')); // bool(true)
var_dump($obj->hasConstant('THREE')); // bool(false)

var_dump($obj->getReflectionConstants());
// array(2) {
//     [0]=>
//     object(ReflectionClassConstant)#2 (2) {
//       ["name"]=>
//       string(3) "ONE"
//       ["class"]=>
//       string(1) "A"
//     }
//     [1]=>
//     object(ReflectionClassConstant)#3 (2) {
//       ["name"]=>
//       string(3) "TWO"
//       ["class"]=>
//       string(1) "A"
//     }
//   }

var_dump($obj->getReflectionConstant('ONE'));
// object(ReflectionClassConstant)#3 (2) {
//     ["name"]=>
//     string(3) "ONE"
//     ["class"]=>
//     string(1) "A"
//   }

// ReflectionClassConstant 对象
$objContant1 = $obj->getReflectionConstant('ONE');
$objContant2 = $obj->getReflectionConstant('TWO');

var_dump($objContant1->getName()); // string(3) "ONE"
var_dump($objContant2->getName()); // string(3) "TWO"

var_dump($objContant1->getValue()); // string(8) "number 1"
var_dump($objContant2->getValue()); // string(8) "number 2"

var_dump($objContant1->getDocComment());
// string(35) "/**
// * This is ONE DOC.
// */"

var_dump($objContant2->getDocComment()); // bool(false)

var_dump($objContant1->getDeclaringClass());
// object(ReflectionClass)#4 (1) {
//     ["name"]=>
//     string(1) "A"
//   }

var_dump($objContant1->getModifiers()); // int(256)
var_dump($objContant2->getModifiers()); // int(1024)

var_dump($objContant1->isPrivate()); // bool(false)
var_dump($objContant1->isProtected()); // bool(false)
var_dump($objContant1->isPublic()); // bool(true)

ReflectionClassConstant::export('A', 'ONE');
// Constant [ public string ONE ] { number 1 }
// PHP7.4过时，PHP8移除，直接 __toString() 了


// 属性操作
var_dump($obj->getDefaultProperties());
// array(6) {
//     ["e"]=>
//     string(1) "5"
//     ["f"]=>
//     NULL
//     ["a"]=>
//     string(1) "1"
//     ["b"]=>
//     string(1) "2"
//     ["c"]=>
//     string(1) "3"
//     ["d"]=>
//     NULL
//   }

var_dump($obj->getProperties());
// array(6) {
//     [0]=>
//     object(ReflectionProperty)#2 (2) {
//       ["name"]=>
//       string(1) "a"
//       ["class"]=>
//       string(1) "A"
//     }
//     [1]=>
//     object(ReflectionProperty)#3 (2) {
//       ["name"]=>
//       string(1) "b"
//       ["class"]=>
//       string(1) "A"
//     }
//     [2]=>
//     object(ReflectionProperty)#4 (2) {
//       ["name"]=>
//       string(1) "c"
//       ["class"]=>
//       string(1) "A"
//     }
//     [3]=>
//     object(ReflectionProperty)#5 (2) {
//       ["name"]=>
//       string(1) "d"
//       ["class"]=>
//       string(1) "A"
//     }
//     [4]=>
//     object(ReflectionProperty)#6 (2) {
//       ["name"]=>
//       string(1) "e"
//       ["class"]=>
//       string(1) "A"
//     }
//     [5]=>
//     object(ReflectionProperty)#7 (2) {
//       ["name"]=>
//       string(1) "f"
//       ["class"]=>
//       string(1) "A"
//     }
//   }

var_dump($obj->getProperty('a'));
// object(ReflectionProperty)#7 (2) {
//     ["name"]=>
//     string(1) "a"
//     ["class"]=>
//     string(1) "A"
//   }

// ReflectionProperty

$objPro1 = $obj->getProperty('a');
$objPro2 = $obj->getProperty('b');
$objPro3 = new ReflectionProperty('A', 'c');
$objPro4 = $obj->getProperty('d');
$objPro5 = $obj->getProperty('e');

// $objPro111 = $obj->getProperty('aaa');  // PHP Fatal error:  Uncaught ReflectionException: Property aaa does not exist




var_dump($objPro1->getName()); // string(1) "a"
// var_dump($objPro1->getValue(new A)); // PHP Fatal error:  Uncaught ReflectionException: Cannot access non-public member A::$a 

var_dump($objPro3->getValue(new A)); // string(1) "3"

var_dump($objPro1->getDocComment());
// string(33) "/**
//      * This is a DOC.
//      */"
var_dump($objPro2->getDocComment()); // bool(false)
var_dump($objPro3->getDocComment()); // bool(false)

var_dump($objPro1->getDeclaringClass());
// object(ReflectionClass)#4 (1) {
//     ["name"]=>
//     string(1) "A"
//   }

$objPro1->setAccessible(true);
var_dump($objPro1->getValue(new A)); // string(1) "1"

$classA = new A;
$objPro4->setValue($classA, 'This is d value.');
var_dump($classA->d); // string(16) "This is d value."


var_dump($objPro1->getModifiers()); // int(1024)
var_dump($objPro2->getModifiers()); // int(512)
var_dump($objPro3->getModifiers()); // int(256)

var_dump($objPro1->isPrivate()); // bool(true)
var_dump($objPro1->isProtected()); // bool(false)
var_dump($objPro1->isPublic()); // bool(false)

var_dump($objPro1->isDefault()); // bool(true)

var_dump($objPro1->isStatic()); // bool(false)
var_dump($objPro5->isStatic()); // bool(true)

// PHP8
// var_dump($objPro1->getDefaultValue());
// var_dump($objPro1->hasDefaultValue());
// PHP7.4
// var_dump($objPro3->isInitialized());
// var_dump($objPro3->getType());
// var_dump($objPro3->hasType());



// 静态属性数组
var_dump($obj->getStaticProperties());
// array(2) {
//     ["e"]=>
//     string(1) "5"
//     ["f"]=>
//     NULL
//   }

var_dump($obj->getStaticPropertyValue('e')); // string(1) "5"




