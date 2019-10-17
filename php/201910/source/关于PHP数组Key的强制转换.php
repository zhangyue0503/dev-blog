<?php
$arr = [
    "1" => "a",
    "01" => "b",
    1 => "aa",
    1.1 => "aaa",
    "0.1" => "bb",
];

var_dump($arr);

// array(3) {
//     [1] =>
//     string(3) "aaa"
//     '01' =>
//     string(1) "b"
//     '0.1' =>
//     string(2) "bb"
// }


$a      = ['a'];
$a[2]   = 'b';
$a[]    = 'c';
$a['1'] = 'd';
foreach ($a as $v) {
	echo $v, ',';
}
for ($i = 0; $i < count($a); ++$i) {
	echo $a[$i], '  ,';
}