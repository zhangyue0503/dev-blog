<?php

$a = new stdClass();
$a->p = 'stdP1';
var_dump($a);

$b = new class{
    public $p = 1;
    function test(){
        echo "This is new class function：", $this->p,PHP_EOL;
    }
};
var_dump($b);
$b->test();

$c = (object)[
    1,
];
var_dump($c);
echo $c->{0};


