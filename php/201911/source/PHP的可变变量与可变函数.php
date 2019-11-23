<?php

$a = 'hello';

$$a = 'world';

echo $a, ' ', $hello;

$a = 1;
$$a = 2;

// echo $1;
echo ${1};

$a = ['b', 'c', 'd'];
$$a = 'f';

echo $b, $c, $d;

class A
{}
class B extends A
{}

$a = new A();
// $$a = new B(); // Catchable fatal error: Object of class A could not be converted to string

// echo ...

function testA()
{
    echo "testA";
}

$a = 'testA';
$a(); // testA

class C
{
    public function testA()
    {
        echo "C:testA";
    }
    public function testB()
    {
        echo "C:testB";
    }
    public function testC()
    {
        echo "C:testC";
    }
}

$funcs = ['testA', 'testB', 'testC'];

$c = new C();
foreach ($funcs as $func) {
    $c->$func();
}
