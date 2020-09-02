<?php

$data = [
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
];

// $p = $_GET['p'];
$p = 2;
$currentPage = $p <= 1 ? 0 : $p - 1;
$pageSize = 3;
$offset = $currentPage * $pageSize;

// array_slice
var_dump(array_slice($data, $offset, $pageSize));
// array(3) {
//     [0]=>
//     string(1) "D"
//     [1]=>
//     string(1) "E"
//     [2]=>
//     string(1) "F"
//   }

// array_chunk
$pages = array_chunk($data, $pageSize);
var_dump($pages);
// array(4) {
//     [0]=>
//     array(3) {
//       [0]=>
//       string(1) "A"
//       [1]=>
//       string(1) "B"
//       [2]=>
//       string(1) "C"
//     }
//     [1]=>
//     array(3) {
//       [0]=>
//       string(1) "D"
//       [1]=>
//       string(1) "E"
//       [2]=>
//       string(1) "F"
//     }
//     [2]=>
//     array(3) {
//       [0]=>
//       string(1) "G"
//       [1]=>
//       string(1) "H"
//       [2]=>
//       string(1) "I"
//     }
//     [3]=>
//     array(2) {
//       [0]=>
//       string(1) "J"
//       [1]=>
//       string(1) "K"
//     }
//   }

var_dump($pages[$currentPage]);
// array(3) {
//     [0]=>
//     string(1) "A"
//     [1]=>
//     string(1) "B"
//     [2]=>
//     string(1) "C"
//   }

// LimitIterator

foreach (new LimitIterator(new ArrayIterator($data), $offset, $pageSize) as $d) {
    var_dump($d);
}
// string(1) "D"
// string(1) "E"
// string(1) "F"

foreach (new LimitIterator(new ArrayIterator($data)) as $d) {
    var_dump($d);
}
// string(1) "A"
// string(1) "B"
// string(1) "C"
// string(1) "D"
// string(1) "E"
// string(1) "F"
// string(1) "G"
// string(1) "H"
// string(1) "I"
// string(1) "J"
// string(1) "K"

// 错误参数情况
// array_slice
var_dump(array_slice($data, $offset, 150));
// array(8) {
//     [0]=>
//     string(1) "D"
//     [1]=>
//     string(1) "E"
//     [2]=>
//     string(1) "F"
//     [3]=>
//     string(1) "G"
//     [4]=>
//     string(1) "H"
//     [5]=>
//     string(1) "I"
//     [6]=>
//     string(1) "J"
//     [7]=>
//     string(1) "K"
//   }
var_dump(array_slice($data, 15, $pageSize));
// array(0) {
// }

// array_chunk
var_dump($pages[15]);
// NULL

// LimitIterator
foreach (new LimitIterator(new ArrayIterator($data), $offset, 150) as $d) {
    var_dump($d);
}
// string(1) "D"
// string(1) "E"
// string(1) "F"
// string(1) "G"
// string(1) "H"
// string(1) "I"
// string(1) "J"
// string(1) "K"

// foreach (new LimitIterator(new ArrayIterator($data), 15, $pageSize) as $d) {
//     var_dump($d);
// }
// Fatal error: Uncaught OutOfBoundsException: Seek position 15 is out of range


var_dump(array_slice($data, $offset, -150));
// array(0) {
// }

var_dump(array_slice($data, -1, $pageSize));
// array(1) {
//     [0]=>
//     string(1) "K"
//   }

var_dump($pages[-1]);
// NULL

foreach (new LimitIterator(new ArrayIterator($data), $offset, -2) as $d) {
    var_dump($d);
}
// string(1) "D"
// string(1) "E"
// string(1) "F"
// string(1) "G"
// string(1) "H"
// string(1) "I"
// string(1) "J"
// string(1) "K"

// foreach (new LimitIterator(new ArrayIterator($data), $offset, -2) as $d) {
//     var_dump($d);
// }
// Fatal error: Uncaught OutOfRangeException: Parameter count must either be -1 or a value greater than or equal 0 i

foreach (new LimitIterator(new ArrayIterator($data), -1, $pageSize) as $d) {
    var_dump($d);
}
// Fatal error: Uncaught OutOfRangeException: Parameter count must either be -1 or a value greater than or equal 0 i