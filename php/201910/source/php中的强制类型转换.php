<?php

// function add(int $a, float $b):int
// {
//     return  $a + $b;
// }

// var_dump(add("1", 2.2));

// // (int)(integer)

// var_dump((int) true); // 1
// var_dump((int) false); // 0

// var_dump((int) 7.99); // 7

// var_dump((int) "35 ok"); // 35
// var_dump((int) "ok 77"); // 0
// var_dump((int) "ok yes"); // 0

// var_dump((int) []); // 0
// var_dump((int) [3, 4, 5]); // 1

// // (bool)(boolean)

// var_dump((bool) 0); // false
// var_dump((bool) 1); // true
// var_dump((bool)  - 1); // true

// var_dump((bool) 0.0); // false
// var_dump((bool) 1.1); // true
// var_dump((bool)  - 1.1); // true

// var_dump((bool) ""); // false
// var_dump((bool) "0"); // false
// var_dump((bool) "a"); // true

// var_dump((bool) []); // false
// var_dump((bool) ['a']); // true

// $a;
// var_dump((bool) $a); // false
// var_dump((bool) null); // false

// // (string)

// var_dump((string) true); // "1"
// var_dump((string) false); // ""

// var_dump((string) 55); // "55"
// var_dump((string) 12.22); // "12.22"

// var_dump((string) ['a']); // "Array"
// class S
// {
//     public function __tostring()
//     {
//         return "S";
//     }
// }
// var_dump((string) new S()); // "S"

// var_dump((string) null); // ""

// // (array)

// var_dump((array) 1);
// var_dump((array) 2.2);

// var_dump((array) "a");

// var_dump((array) true);

// class Arr
// {
//     public $a = 1;
//     private $b = 2.2;
//     protected $c = "f";
// }
// class ChildArr extends Arr
// {
//     public $a = 2;
//     private $d = "g";
//     private $e = 1;
// }
// var_dump((array) new Arr());
// var_dump((array) new ChildArr());

// var_dump((array) null);

// // (object)

// var_dump((object) 1);
// var_dump((object) 1.1);
// var_dump((object) "string");
// var_dump((object) true);
// var_dump((object) null);

// var_dump((object) [1, 2, 3]);
// var_dump((object) ["a" => 1, "b" => 2, "c" => 3]);
// $c = (object) [1, 2, 3];
// echo $c->{2};

// // (unset)

// var_dump((unset) 1);
// var_dump((unset) 1.1);
// var_dump((unset) "string");
// var_dump((unset) true);
// var_dump((unset) null);

// var_dump((unset) [1, 2, 3]);
// var_dump((unset) new \stdClass());

// // (binary)

// var_dump((binary) 1);
// var_dump((binary) 1.1);
// var_dump((binary) "string");
// var_dump((binary) true);
// var_dump((binary) null);

// var_dump((binary) [1, 2, 3]);
// var_dump((binary) new S());

