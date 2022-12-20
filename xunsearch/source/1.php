<?php

require_once 'vendor/autoload.php';

$xs = new XS('demo'); 

$doc = $xs->search->search("项目");

print_r($xs->search->getConnString());

print_r($doc);

