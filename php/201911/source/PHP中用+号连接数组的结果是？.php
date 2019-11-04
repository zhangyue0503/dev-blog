<?php

$a = [1, 2];
$b = [4, 5, 6];

$c = $a + $b;
print_r($c);

$c = $b + $a;
print_r($c);

$c = array_merge($a, $b);
print_r($c);

$c = array_merge($b, $a);
print_r($c);

$a = ['a' => 1, 'b' => 2];
$b = ['a' => 4, 'b' => 5, 'c' => 6];

print_r($a+$b);

$c = array_merge($a, $b);
print_r($c);

$c = array_merge($b, $a);
print_r($c);

$c = $a . $b;
print_r($c);