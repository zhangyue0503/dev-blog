<?php

class Manager{

    public static function run($config){
        echo "AAA", PHP_EOL;
        var_dump($config);
    }

    public static function ChineseMobile($mobile){
        if(preg_match("/^1[34578]\d{9}$/", $mobile)){
            return true;
        }
        return false;
    }
}