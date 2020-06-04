<?php
$arr = [
    "1" => "a",
    "01" => "b",
    1 => "aa",
    1.1 => "aaa",
    "0.1" => "bb",
];

// var_dump($arr);

// array(3) {
//     [1] =>
//     string(3) "aaa"
//     '01' =>
//     string(1) "b"
//     '0.1' =>
//     string(2) "bb"
// }

// $a  = [
//     0=> 'a',
//     2=> 'b',
//     3=> 'c',
//     '1' => 'd'
// ];
$a      = ['a']; // 1
$a[2]   = 'b'; // 3
$a[]    = 'c'; // 4
$a['1'] = 'd'; // 2

var_dump($a);

foreach ($a as $v) {
	echo $v, ',';
}
echo PHP_EOL, '========', PHP_EOL;
for ($i = 0; $i < count($a); ++$i) {
	echo $a[$i], ',';
}
echo PHP_EOL;