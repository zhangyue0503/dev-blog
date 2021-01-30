<?php

interface A {}
interface B {}

class TestA implements A,B {}

var_dump(class_implements(new TestA));
// array(2) {
//     ["A"]=>
//     string(1) "A"
//     ["B"]=>
//     string(1) "B"
//   }

var_dump(class_implements(new stdClass()));
// array(0) {
// }

class C{}

class TestB extends C {}

var_dump(class_parents(new TestB));
// array(1) {
//     ["C"]=>
//     string(1) "C"
//   }



trait D {}
trait E {}

class TestC {
    use D, E;
}

var_dump(class_uses(new TestC));
// array(2) {
//     ["D"]=>
//     string(1) "D"
//     ["E"]=>
//     string(1) "E"
//   }



var_dump(spl_object_hash(new TestA));
// string(32) "000000000ed109570000000025e36d74"

$a = new TestA;
var_dump(spl_object_hash($a));
// string(32) "000000000ed109570000000025e36d74"

var_dump(spl_object_id(new TestA));
// int(2)
var_dump(spl_object_id($a));
// int(1)

var_dump($a);
// object(TestA)#1 (0) {
// }
var_dump(new TestA);
// object(TestA)#2 (0) {
// }

var_dump(spl_classes());
// array(55) {
//     ["AppendIterator"]=>
//     string(14) "AppendIterator"
//     ["ArrayIterator"]=>
//     string(13) "ArrayIterator"
//     ["ArrayObject"]=>
//     string(11) "ArrayObject"
//     ["BadFunctionCallException"]=>
//     string(24) "BadFunctionCallException"
//     ["BadMethodCallException"]=>
//     string(22) "BadMethodCallException"
//     ["CachingIterator"]=>
//     string(15) "CachingIterator"
//     ["CallbackFilterIterator"]=>
//     string(22) "CallbackFilterIterator"
//     ["DirectoryIterator"]=>
//     string(17) "DirectoryIterator"
//     ["DomainException"]=>
//     string(15) "DomainException"
//     ["EmptyIterator"]=>
//     string(13) "EmptyIterator"
//     ["FilesystemIterator"]=>
//     string(18) "FilesystemIterator"
//     ["FilterIterator"]=>
//     string(14) "FilterIterator"
//     ["GlobIterator"]=>
// …………………………
// …………………………


$iterator = new ArrayIterator(['a'=>'a1', 'b'=>'b1', 'c'=>'c1']);

var_dump(iterator_to_array($iterator, true));
// array(3) {
//     ["a"]=>
//     string(2) "a1"
//     ["b"]=>
//     string(2) "b1"
//     ["c"]=>
//     string(2) "c1"
//   }

var_dump(iterator_to_array($iterator, false));
// array(3) {
//     [0]=>
//     string(2) "a1"
//     [1]=>
//     string(2) "b1"
//     [2]=>
//     string(2) "c1"
//   }

var_dump(iterator_count($iterator)); // int(3)

function printCaps($iterator){
    echo strtoupper($iterator->current()), PHP_EOL;
    return true;
}
iterator_apply($iterator, "printCaps", array($iterator));
// A1
// B1
// C1

function autoloadA($class){
    if(is_file('./autoloadA/' . $class . '.php')){
        require_once './autoloadA/' . $class . '.php';
    }
    
}
spl_autoload_register('autoloadA');

spl_autoload_register(function($class){
    if(is_file('./autoloadB/' . $class . '.php')){
        require_once './autoloadB/' . $class . '.php';
    }
});

$sky = new Sky();
$sky->result();
// This is Sky PHP!

$planet = new Planet();
$planet->result();
// This is Planet PHP!

var_dump(spl_autoload_functions());
// array(2) {
//     [0]=>
//     string(9) "autoloadA"
//     [1]=>
//     object(Closure)#3 (1) {
//       ["parameter"]=>
//       array(1) {
//         ["$class"]=>
//         string(10) "<required>"
//       }
//     }
//   }

spl_autoload_unregister('autoloadA');

var_dump(spl_autoload_functions());
// array(1) {
//     [0]=>
//     object(Closure)#3 (1) {
//       ["parameter"]=>
//       array(1) {
//         ["$class"]=>
//         string(10) "<required>"
//       }
//     }
//   }
