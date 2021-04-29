<?php

// 类别名

class foo {}

class_alias('foo', 'baz');

$a = new foo();
$b = new baz();

var_dump($a == $b); // bool(true)
var_dump($a === $b); // bool(false)
var_dump($a instanceof baz); // bool(true)
var_dump($b instanceof foo); // bool(true)

// 类、接口、特性是否存在
var_dump(class_exists('MyClass')); // bool(false)
var_dump(class_exists('foo')); // bool(true)

interface Ifoo{}
var_dump(interface_exists('MyInterface')); // bool(false)
var_dump(interface_exists('Ifoo')); // bool(true)

trait Tfoo{}
var_dump(trait_exists('MyTrait')); // bool(false)
var_dump(trait_exists('Tfoo')); // bool(true)

// 检查类中的方法、属性、特性是否存在

class con{
    private $b;
    protected $b1 = 'b1';
    public $b2 = 'b2';
    public function c(){
    }
    protected function d(){
    }
    private function e(){
    }

    function getClassName(){
        echo get_class(), PHP_EOL;
    }

    static function getStaticClassName(){
        echo 'get_class: ', get_class(), PHP_EOL;
        echo 'get_called_class: ', get_called_class(), PHP_EOL;
    }
}
$con = new con();

var_dump(method_exists($con, 'c')); // bool(true)
var_dump(method_exists('con', 'c')); // bool(true)
var_dump(method_exists('con', 'cc')); // bool(false)

var_dump(property_exists($con, 'b')); // bool(true)
var_dump(property_exists($con, 'bb')); // bool(false)

// 返回对象的一些属性

// 类名
var_dump(get_class($a)); // string(3) "foo"
var_dump(get_class($b)); // string(3) "foo"
var_dump(get_class($con)); // string(3) "con"
$con->getClassName(); // con

var_dump(get_class('a')); // Warning: get_class() expects parameter 1 to be object, string given in
// bool(false)

// 类和对象的属性数组
var_dump(get_class_vars('con'));
// array(1) {
//     ["b2"]=>
//     string(2) "b2"
//   }

var_dump(get_object_vars($con));
// array(1) {
//     ["b2"]=>
//     string(2) "b2"
//   }

$con->newp = 'newp';
var_dump(get_object_vars($con));
// array(2) {
//     ["b2"]=>
//     string(2) "b2"
//     ["newp"]=>
//     string(4) "newp"
//   }

// 类的方法数组
var_dump(get_class_methods('con'));
// array(2) {
//     [0]=>
//     string(1) "c"
//     [1]=>
//     string(12) "getClassName"
//   }

// 后期静态绑定的类名称
con::getStaticClassName();
// get_class: con
// get_called_class: con

class con_child extends con{}
con_child::getStaticClassName();
// get_class: con
// get_called_class: con_child

// 对象或类的父类名
echo get_parent_class($con), PHP_EOL; //
echo get_parent_class('con_child'), PHP_EOL; // con


// 获取所有已定义的类、接口、特性
var_dump(get_declared_classes());
// array(160) {
//     [0]=>
//     string(8) "stdClass"
//     [1]=>
//     string(9) "Exception"
//     [2]=>
//     string(14) "ErrorException"
//     [3]=>
//     ……………………
//     ……………………
//     ……………………
//     [156]=>
//     string(3) "foo"
//     [157]=>
//     string(3) "con"
//     [158]=>
//     string(9) "con_child"
//     [159]=>
//     string(3) "baz"
//   }

var_dump(get_declared_interfaces());
// array(19) {
//     [0]=>
//     string(11) "Traversable"
//     [1]=>
//     string(17) "IteratorAggregate"
//     [2]=>
//     string(8) "Iterator"
//     [3]=>
//     string(11) "ArrayAccess"
//     [4]=>
//     string(12) "Serializable"
//     [5]=>
//     string(9) "Countable"
//     ……………………
//     ……………………
//     ……………………
//     [17]=>
//     string(9) "Reflector"
//     [18]=>
//     string(4) "Ifoo"
//   }

var_dump(get_declared_traits());
// array(1) {
//     [0]=>
//     string(4) "Tfoo"
//   }

// 判断对象是否属于类或是某个类的子类
var_dump(is_a($con, 'con')); // bool(true)
var_dump(is_a(new con_child, 'con')); // bool(true)
var_dump(is_a($con, 'foo')); // bool(false)


// var_dump($con instanceof 'con'); // Parse error: syntax error, unexpected ''con'' (T_CONSTANT_ENCAPSED_STRING)
$conClassName = 'con';
var_dump($con instanceof con); // bool(true)
var_dump($con instanceof $conClassName); // bool(true)

var_dump(is_subclass_of($con, 'con')); // bool(false)
var_dump(is_subclass_of(new con_child, 'con')); // bool(true)
var_dump(is_subclass_of('con_child', 'con')); // bool(false)

// PHP的SPL扩展库（四）函数 class_implements class_parents class_uses