<?php

$checker = new Spoofchecker();

$checker->setAllowedLocales('zh_CN');

var_dump($checker->areConfusable('google.com', 'goog1e.com')); // true

var_dump($checker->areConfusable('google.com', 'g00g1e.com')); // false

var_dump($checker->isSuspicious('google.com')); // FALSE

var_dump($checker->isSuspicious('Рaypal.com')); // TRUE
