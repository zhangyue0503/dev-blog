<?php

$routePages = [
    '/testRoute2.php',
    '/route/testRoute1.php'
];

if(in_array($_SERVER['REQUEST_URI'], $routePages)){
    include __DIR__ . $_SERVER['REQUEST_URI'];
}else{
    print_r($_SERVER);
}

// php -S localhost:8081

// php -S localhost:8081 -t dev-blog/php/202004/source

// include __DIR__ . '/PHP的CLI命令行运行模式浅析.php';


