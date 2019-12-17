<?php

abstract class A {
    public function show(){
        $this->getName();
        echo PHP_EOL;
    }

    protected abstract function getName();
    public abstract function getAge($age);
}

class ChildA1 extends A {
    public function getName(){
        echo "I'm ChildA1";
    }
    public function getAge($age){
        echo "Age is " . $age;
    }
}

class ChildA2 extends A {
    protected function getName(){
        echo "I'm ChildA2";
    }
    public function getAge($age, $year = ''){
        echo "Age is ". $age . ', bron ' . $year;
    }
}

$ca1 = new ChildA1();
$ca1->show();
$ca1->getAge(18);

$ca2 = new ChildA2();
$ca2->show();
$ca2->getAge(20, 2000);

interface B1 {
    const B1_NAME = 'Interface B1';
    function getName();
    function getAge($age);
}

interface B2 extends B1 {
    function show();
}

interface B3 {
    function getSchool();
}

class ChildB implements B2, B3{
    function getName(){
        echo "I'm ChildB";
    }
    function getAge($age, $year = ''){
        echo "Age is " . $age;
    }
    function show(){
        $this->getName();
        echo PHP_EOL;

        $this->getAge(23, 1997);
        echo PHP_EOL;

        echo self::B1_NAME;
        echo PHP_EOL;
    }
    
    function getSchool(){
        echo "study in Peking University";
        echo PHP_EOL;
    }
}

$b = new ChildB();
$b->show();
$b->getSchool();


interface USB{
    function run();
}

class Keyboard implements USB{
    function run(){
        echo "这是键盘";
    }
}

class UDisk implements USB{
    function run(){
        echo "这是U盘";
    }
}


function testUSB (USB $u){
    $u->run();
}

// 插入U盘
testUSB(new UDisk);

// 插入键盘
testUSB(new Keyboard);

