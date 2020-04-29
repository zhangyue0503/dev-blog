<?php

apcu_add("int", 1);
apcu_add("string", "I'm String");
apcu_add("arr", [1,2,3]);

class A{
    private $apc = 1;
    function test(){
        echo "s";
    }
}

apcu_add("obj", new A);

var_dump(apcu_fetch("int"));
var_dump(apcu_fetch("string"));
var_dump(apcu_fetch("arr"));
var_dump(apcu_fetch("obj"));


apcu_cas("int", 1, 2);
var_dump(apcu_fetch("int"));

// Warning  apcu_cas() expects parameter 2 to be int
apcu_cas("string", "I'm String", "I'm  New String");

// apcu_store("entry", "I'm entry");
apcu_entry("entry", function($key){
    return "This is " . $key;
});
var_dump(apcu_fetch("entry"));

var_dump(apcu_cache_info());
