<?php

$func = function($say){
    echo $this->name, '：', $say, PHP_EOL;
};
// $func('good');
// exit;

class Lily {
    private $name = 'Lily';
}
$lily = new Lily();

// $func1 = $func->bindTo($lily, 'Lily');
// // $func1 = $func->bindTo($lily, Lily::class);
// // $func1 = $func->bindTo($lily, $lily);
// $func1('cool');


$func2 = $func->bindTo($lily);
$func2('cool2'); // Fatal error: Uncaught Error: Cannot access private property Lily::$name

// $func->call($lily, 'well');



