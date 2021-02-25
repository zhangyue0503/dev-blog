<?php


$vector = new \Ds\Vector(["a", "b", "c"]);

$vector->push("d");
$vector->push(5);
$vector->push(6);
$vector->push(7);
$vector->push(8);

$vector->set(3, "ccc");

var_dump($vector->get(3)); // string(3) "ccc"
var_dump($vector->pop()); // int(8)

$vector->unshift(1);
$vector->unshift(-1); 

var_dump($vector->shift()); // int(-1)

$vector->insert(5, 'five');
var_dump($vector->get(5)); // string(4) "five"

var_dump($vector->get(6)); // int(5)
$vector->remove(6);
var_dump($vector->get(6)); // int(6)

var_dump($vector[4]); // string(3) "ccc"

$vector[4] = 'Num 4.';

var_dump($vector[4]); // string(6) "Num 4."

var_dump($vector);
// object(Ds\Vector)#1 (8) {
//   [0]=>
//   int(1)
//   [1]=>
//   string(1) "a"
//   [2]=>
//   string(1) "b"
//   [3]=>
//   string(1) "c"
//   [4]=>
//   string(6) "Num 4."
//   [5]=>
//   string(4) "five"
//   [6]=>
//   int(6)
//   [7]=>
//   int(7)
// }

$set = new \Ds\Set(["a", "b", "c"]);
$set->add("d");

$set->add("b");

var_dump($set);
// object(Ds\Set)#2 (4) {
//   [0]=>
//   string(1) "a"
//   [1]=>
//   string(1) "b"
//   [2]=>
//   string(1) "c"
//   [3]=>
//   string(1) "d"
// }


$deque = new \Ds\Deque(["a", "b", "c"]);

$deque->push("d");
$deque->unshift("z");

var_dump($deque);
// object(Ds\Deque)#3 (5) {
//     [0]=>
//     string(1) "z"
//     [1]=>
//     string(1) "a"
//     [2]=>
//     string(1) "b"
//     [3]=>
//     string(1) "c"
//     [4]=>
//     string(1) "d"
//   }

var_dump($deque->pop()); // string(1) "d"
var_dump($deque->shift()); // string(1) "z"