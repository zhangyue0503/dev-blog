<?php

/**
 * This is testA
 */
function testA(int $a = PHP_INT_MIN, $b){
    echo 'Function A: ', $a + $b, PHP_EOL;
}

function testB(){
    yield $i++;
    return $i;
}

function testC(...$a) : int{
    return 1;
}

function testD(){
    return function(){

    };
}

function &testE(){

}

class A {
    function testClassA(Exception $a = null){
        return function(){

        };
    }
}

// ReflectionFunction
$refFuncA = new ReflectionFunction('testA');

$funcA = $refFuncA->getClosure();
$funcA(1, 2); // Function A: 3

$refFuncA->invoke(1, 2); // Function A: 3
$refFuncA->invokeArgs([1, 2]); // Function A: 3

// php.ini disable_functions
var_dump($refFuncA->isDisabled()); // bool(false)
var_dump((new ReflectionFunction('dl'))->isDisabled()); // bool(true)

// ReflectionFunctionAbstract
var_dump($refFuncA->getStartLine()); // int(3)
var_dump($refFuncA->getEndLine()); // int(5)

var_dump($refFuncA->getDocComment());
// string(24) "/**
//  * This is testA
//  */"

var_dump($refFuncA->hasReturnType()); // bool(false)
var_dump((new ReflectionFunction('testB'))->hasReturnType()); // bool(false)
var_dump((new ReflectionFunction('testC'))->hasReturnType()); // bool(true)

var_dump($refFuncA->isVariadic()); // bool(false)
var_dump((new ReflectionFunction('testC'))->isVariadic()); // bool(true)

var_dump($refFuncA->isGenerator()); // bool(false)
var_dump((new ReflectionFunction('testB'))->isGenerator()); // bool(true)

var_dump((new ReflectionFunction((new A)->testClassA()))->getClosureScopeClass());
// object(ReflectionClass)#6 (1) {
//     ["name"]=>
//     string(1) "A"
//   }
var_dump((new ReflectionFunction((new A)->testClassA()))->getClosureThis());
// object(A)#3 (0) {
// }

var_dump((new ReflectionFunction('testD'))->getClosureThis()); // NULL

var_dump($refFuncA->returnsReference()); // bool(false)
var_dump((new ReflectionFunction('testE'))->returnsReference()); // bool(true)

var_dump($refFuncA->getParameters());
// array(2) {
//     [0]=>
//     object(ReflectionParameter)#3 (1) {
//       ["name"]=>
//       string(1) "a"
//     }
//     [1]=>
//     object(ReflectionParameter)#4 (1) {
//       ["name"]=>
//       string(1) "b"
//     }
//   }
var_dump((new ReflectionFunction('testC'))->getParameters());
// array(1) {
//     [0]=>
//     object(ReflectionParameter)#3 (1) {
//       ["name"]=>
//       string(1) "a"
//     }
//   }

// ReflectionParameter
$refParA = new ReflectionParameter('testA', 'a');
$refParClassA = new ReflectionParameter(['A', 'testClassA'], 'a');


var_dump($refParClassA->getClass());
// object(ReflectionClass)#5 (1) {
//     ["name"]=>
//     string(9) "Exception"
//   }
var_dump($refParClassA->getDeclaringClass());
// object(ReflectionClass)#5 (1) {
//     ["name"]=>
//     string(1) "A"
//   }

var_dump($refParClassA->getDeclaringFunction());
// object(ReflectionMethod)#5 (2) {
//     ["name"]=>
//     string(10) "testClassA"
//     ["class"]=>
//     string(1) "A"
//   }

var_dump($refParA->getDeclaringFunction());
// object(ReflectionFunction)#5 (1) {
//     ["name"]=>
//     string(5) "testA"
//   }

var_dump($refParA->getDefaultValue()); // int(-9223372036854775808)
var_dump($refParA->getDefaultValueConstantName()); // string(11) "PHP_INT_MIN"

var_dump($refParA->getPosition()); // int(0)
var_dump((new ReflectionParameter('testA', 'b'))->getPosition()); // int(1)

var_dump($refParA->isArray()); // bool(false)
var_dump($refParA->isCallable()); // bool(false)
var_dump($refParA->isDefaultValueAvailable()); // bool(true)
var_dump($refParA->isDefaultValueConstant()); // bool(true)
var_dump($refParA->isOptional()); // bool(false)
var_dump($refParA->isPassedByReference()); // bool(false)
var_dump($refParA->isVariadic()); // bool(false)


var_dump($refParA->getType());
// object(ReflectionNamedType)#5 (0) {
// }
var_dump($refParA->hasType()); // bool(true)
var_dump((new ReflectionParameter('testA', 'b'))->getType()); // NULL
var_dump((new ReflectionParameter('testA', 'b'))->hasType()); // bool(false)

var_dump($refParA->getType()->allowsNull()); // bool(false)
var_dump($refParClassA->getType()->allowsNull()); // bool(true)

// ReflectionGenerator
$genRef = new ReflectionGenerator(testB());

var_dump($genRef->getExecutingFile()); // string(105) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/4.一起学习PHP中的反射（四）.php"

var_dump($genRef->getExecutingGenerator()); 
// object(Generator)#4 (0) {
// }

var_dump($genRef->getExecutingLine()); // int(11)

var_dump($genRef->getFunction());
// object(ReflectionFunction)#7 (1) {
//     ["name"]=>
//     string(5) "testB"
//   }

var_dump($genRef->getThis()); // NULL


function testBB(){
    yield from testB();
}
$b = testBB();
$b->valid();
var_dump((new ReflectionGenerator($b))->getTrace());
// array(1) {
//     [0]=>
//     array(4) {
//       ["file"]=>
//       string(105) "/Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/05/source/4.一起学习PHP中的反射（四）.php"
//       ["line"]=>
//       int(181)
//       ["function"]=>
//       string(5) "testB"
//       ["args"]=>
//       array(0) {
//       }
//     }
//   }

// ReflectionObject
$a = new A();
$objRef = new ReflectionObject($a);
$a->f = 'aaa';
var_dump($objRef->getProperties());
// array(1) {
//     [0]=>
//     object(ReflectionProperty)#11 (2) {
//       ["name"]=>
//       string(1) "f"
//       ["class"]=>
//       string(1) "A"
//     }
//   }

var_dump((new ReflectionClass('A'))->getProperties());
// array(0) {
// }

// ReflectionException
try{
    new ReflectionClass('oooo');
}catch(ReflectionException $e){
    var_dump($e->getMessage());
}
// string(25) "Class oooo does not exist"
