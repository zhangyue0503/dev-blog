<?php

$a = new stdClass();
var_dump($a);

$b = new class{
    public $p = 1;
};
var_dump($b);

$c = (object)[
    'p' => 1
];
var_dump($c);


