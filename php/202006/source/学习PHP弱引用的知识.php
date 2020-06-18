<?php

$obj = new stdClass;
$weakref = $obj;

var_dump($weakref);
// object(stdClass)#1 (0) {
// }

unset($obj);
var_dump($weakref);
// object(stdClass)#1 (0) {
// }

$obj1 = new stdClass;
$weakref = WeakReference::create($obj1);

var_dump($weakref->get());
// object(stdClass)#2 (0) {
// }

unset($obj1);
var_dump($weakref->get());
// NULL

$weakref = WeakReference::create(new stdClass);
var_dump($weakref->get());
// NULL