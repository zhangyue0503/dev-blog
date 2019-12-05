<?php

// function __autoload($name){
//     include __DIR__ . '/autoload/' . $name . '.class.php';
// }

// spl_autoload_register(function($name){
//     include __DIR__ . '/autoload/' . $name . '.class.php';
// });

spl_autoload_register(function($name){
    include __DIR__ . '/autoload/' . $name . '.class.php';
    echo $name, PHP_EOL;
});

$autoA = new AutoA();
var_dump($autoA);

$autoA = new AutoA();
var_dump($autoA);

$autoA = new AutoA();
var_dump($autoA);

$autoB = new AutoB();
var_dump($autoB);