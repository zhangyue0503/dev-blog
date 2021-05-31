<?php

namespace Test;

interface iA{

}

trait tA{

}
trait tB{
    function traitBInfo(){
        echo 'This is trait B. function is traitBInfo.';
    }
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

    public function __construct($a = 1, $b = 2){
        echo 'This is Class A, function Constructor.', PHP_EOL;
        $this->argsA = $a;
        $this->argsB = $b;
    }

    public function __destruct(){

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

    public function testD($a, $b){
        echo $a + $b, PHP_EOL;
    }

    static function testE($a, $b){
        echo $a * $b, PHP_EOL;
    }

    
}

/**
 * This is Class B ，extends from A.
 * 
 * @author zyblog
 */
class B extends A {
    use tA, tB { tB::traitBInfo as info;}
    public function testC(){
        echo 'This is Class B, function testC', PHP_EOL;
    }
}


abstract class C implements iA{
    abstract function testF();
    final function testG(){}
    private function __clone(){}
}

$objA = new \ReflectionClass('Test\\A');
$objB = new \ReflectionClass('Test\\B');
$objC = new \ReflectionClass('Test\\C');

var_dump($objA->getName()); // string(6) "Test\A"
var_dump($objA->getShortName()); // string(1) "A"
var_dump($objA->getNamespaceName()); // string(4) "Test"
var_dump($objA->inNamespace()); // bool(true)

var_dump($objB->getTraits());
// array(2) {
//     ["Test\tA"]=>
//     object(ReflectionClass)#3 (1) {
//       ["name"]=>
//       string(7) "Test\tA"
//     }
//     ["Test\tB"]=>
//     object(ReflectionClass)#4 (1) {
//       ["name"]=>
//       string(7) "Test\tB"
//     }
//   }
var_dump($objB->getTraitAliases());
// array(1) {
//     ["info"]=>
//     string(19) "Test\tB::traitBInfo"
//   }
var_dump($objB->getTraitNames());
// array(2) {
//     [0]=>
//     string(7) "Test\tA"
//     [1]=>
//     string(7) "Test\tB"
//   }

// 设置静态属性值
$objA->setStaticPropertyValue('f', 'fff');
echo A::$f, PHP_EOL; // fff

// 是否实现了接口
var_dump($objA->implementsInterface('Test\\iA')); // bool(false)
var_dump($objC->implementsInterface('Test\\iA')); // bool(true)

// 是否是抽象类
var_dump($objA->isAbstract()); // bool(false)
var_dump($objC->isAbstract()); // bool(true)

// 是否是特性
var_dump((new \ReflectionClass('Test\\tA'))->isTrait()); // bool(true)

// 是否是匿名类
var_dump($objA->isAnonymous()); // bool(false)
$class = new class {};
var_dump((new \ReflectionClass($class))->isAnonymous()); // bool(true)

// 是否可以调用 __clone
var_dump($objA->isCloneable()); // bool(true)
var_dump($objC->isCloneable()); // bool(false)

// 是否是不可修改类
var_dump($objA->isFinal()); // bool(false)
final class finalClass{}
var_dump((new \ReflectionClass('Test\\finalClass'))->isFinal()); // bool(true)

// 判断反射的类是否是指定对象
$a = new A();
$b = new B;
var_dump($objA->isInstance($a)); // bool(true)
var_dump($objA->isInstance($b)); // bool(true)
var_dump($objA->isInstance(new \stdClass)); // bool(false)

// 判断是否可以实例化
var_dump($objA->isInstantiable()); // bool(true)
var_dump($objC->isInstantiable()); // bool(false)

// 判断是否是接口
var_dump((new \ReflectionClass('Test\\iA'))->isInterface()); // bool(true)

// 判断是否是原生或者扩展提供的类
var_dump($objA->isInternal()); // bool(false)
var_dump((new \ReflectionClass('PDO'))->isInternal()); // bool(true)

// 判断是否是用户定义的类
var_dump($objA->isUserDefined()); // bool(true)
var_dump((new \ReflectionClass('PDO'))->isUserDefined()); // bool(false)

class IteratorClass implements \Iterator{
    public function key() { }
    public function current() { }
    function next() { }
    function valid() { }
    function rewind() { }
}
// 判断类是否可以遍历 foreach
var_dump($objA->isIterable()); // bool(false)
var_dump((new \ReflectionClass('Test\\IteratorClass'))->isIterable()); // bool(true)
// 判断类是否是迭代类
var_dump($objA->isIterateable()); // bool(false)
var_dump((new \ReflectionClass('Test\\IteratorClass'))->isIterateable()); // bool(true)

// 判断反射的类是否是指定类的子类
var_dump($objB->isSubclassOf('Test\\A')); // bool(true)
var_dump($objB->isSubclassOf('Test\\B')); // bool(false)

// 实例化一个反射类
$objA1 = $objA->newInstance(11, 22);
var_dump($objA1);
// object(Test\A)#8 (6) {
//     ["a":"Test\A":private]=>
//     string(1) "1"
//     ["b":protected]=>
//     string(1) "2"
//     ["c"]=>
//     string(1) "3"
//     ["d"]=>
//     NULL
//     ["argsA"]=>
//     int(11)
//     ["argsB"]=>
//     int(22)
//   }

$objA2 = $objA->newInstanceArgs([111, 222]);
var_dump($objA2);
// object(Test\A)#8 (6) {
//     ["a":"Test\A":private]=>
//     string(1) "1"
//     ["b":protected]=>
//     string(1) "2"
//     ["c"]=>
//     string(1) "3"
//     ["d"]=>
//     NULL
//     ["argsA"]=>
//     int(111)
//     ["argsB"]=>
//     int(222)
//   }

$objA3 = $objA->newInstanceWithoutConstructor([111, 222]);
var_dump($objA3);
// object(Test\A)#9 (4) {
//     ["a":"Test\A":private]=>
//     string(1) "1"
//     ["b":protected]=>
//     string(1) "2"
//     ["c"]=>
//     string(1) "3"
//     ["d"]=>
//     NULL
//   }

// $objC1 = $objC->newInstance(11, 22); // atal error: Uncaught Error: Cannot instantiate abstract class Test\C 



// ReflectionMethod

var_dump($objA->getMethods());
// array(4) {
//     [0]=>
//     object(ReflectionMethod)#5 (2) {
//       ["name"]=>
//       string(11) "__construct"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//     [1]=>
//     object(ReflectionMethod)#4 (2) {
//       ["name"]=>
//       string(5) "testA"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//     [2]=>
//     object(ReflectionMethod)#6 (2) {
//       ["name"]=>
//       string(5) "testB"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//     [3]=>
//     object(ReflectionMethod)#7 (2) {
//       ["name"]=>
//       string(5) "testC"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//   }

var_dump($objA->getMethods(\ReflectionMethod::IS_PUBLIC));
// array(2) {
//     [0]=>
//     object(ReflectionMethod)#7 (2) {
//       ["name"]=>
//       string(11) "__construct"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//     [1]=>
//     object(ReflectionMethod)#6 (2) {
//       ["name"]=>
//       string(5) "testC"
//       ["class"]=>
//       string(6) "Test\A"
//     }
//   }

var_dump($objA->hasMethod('testA')); // bool(true)
var_dump($objA->getMethod('testA'));
// object(ReflectionMethod)#6 (2) {
//     ["name"]=>
//     string(5) "testA"
//     ["class"]=>
//     string(6) "Test\A"
//   }

var_dump($objA->hasMethod('testAA')); // bool(false)
// var_dump($objA->getMethod('testAA')); // Fatal error: Uncaught ReflectionException: Method testAA does not exist

$objMethodA = $objA->getMethod('testA');
$objMethodB = $objA->getMethod('testB');
$objMethodC = $objA->getMethod('testC');

// 可以使用这个返回值直接调用非公开方法。
$fun = $objMethodA->getClosure(new A());
$fun(); // This is class A, function testA

var_dump($objMethodB->getDeclaringClass());
// object(ReflectionClass)#9 (1) {
//     ["name"]=>
//     string(6) "Test\A"
//   }

var_dump($objMethodA->getModifiers()); // int(1024)
var_dump($objMethodB->getModifiers()); // int(512)
var_dump($objMethodC->getModifiers()); // int(256)

var_dump($objMethodA->isPrivate()); // bool(true)
var_dump($objMethodA->isProtected()); // bool(false)
var_dump($objMethodA->isPublic()); // bool(false)


// var_dump($objMethodC->getPrototype()); // Fatal error: Uncaught ReflectionException: Method Test\A::testA does not have a prototype
var_dump((new \ReflectionMethod('Test\\B', 'testC'))->getPrototype());
// object(ReflectionMethod)#10 (2) {
//     ["name"]=>
//     string(5) "testC"
//     ["class"]=>
//     string(6) "Test\A"
//   }

var_dump((new \ReflectionMethod('Test\\C', 'testF'))->isAbstract()); // bool(true)
var_dump((new \ReflectionMethod('Test\\C', 'testG'))->isFinal()); // bool(true)

var_dump((new \ReflectionMethod('Test\\A', '__construct'))->isConstructor()); // bool(true)
var_dump((new \ReflectionMethod('Test\\A', '__destruct'))->isDestructor()); // bool(true)


var_dump($objMethodA->isStatic()); // bool(false)
var_dump((new \ReflectionMethod('Test\\A', 'testE'))->isStatic()); // bool(true)

(new \ReflectionMethod('Test\\A', 'testD'))->invoke(new A(), 2,3); // 5
(new \ReflectionMethod('Test\\A', 'testE'))->invoke(null, 2,3); // 6

(new \ReflectionMethod('Test\\A', 'testD'))->invokeArgs(new A(), [2,3]); // 5
(new \ReflectionMethod('Test\\A', 'testE'))->invokeArgs(null, [2,3]); // 6

// $objMethodA->invoke(new A()); // Fatal error: Uncaught ReflectionException: Trying to invoke private method Test\A::testA() from scope ReflectionMethod
$objMethodA->setAccessible(true);
$objMethodA->invoke(new A()); // This is class A, function testC




