<?php

$arr = [
    [1, 2, [3, 4]],
    [5, 6, [7, 8]],
];

foreach ($arr as list($a, $b, list($c, $d))) {
    echo $a, ',', $b, ',', $c, ',', $d, PHP_EOL;
}

$arr = [
    ["a" => 1, "b" => 2],
    ["a" => 3, "b" => 4],
];

foreach ($arr as list("a" => $a, "b" => $b)) {
    echo $a, ',', $b, PHP_EOL;
}

foreach ($arr as ["a" => $a, "b" => $b]) {
    echo $a, ',', $b, PHP_EOL;
}

["b" => $b, "a" => $a] = $arr[0];
echo $a, ',', $b, PHP_EOL;

[$arr1, $arr2] = $arr;
print_r($arr1);
print_r($arr2);

[0=>$arr1, 1=>$arr2] = $arr;
print_r($arr1);
print_r($arr2);