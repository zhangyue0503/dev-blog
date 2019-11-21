<?php

function testA($a, $b)
{
    echo $a + $b;
}

var_dump(testA(1, 2)); // NULL

function testB($a, $b)
{
    return $a + $b;
}

var_dump(testB(1, 2)); // 3

function testC($a, $b)
{
    return;
    echo $a + $b; // 后面不会执行了
}

var_dump(testC(1, 2)); // NULL

function testD($a, $b)
{
    return [
        $a + $b,
        $a * $b,
    ];
}

var_dump(testD(1, 2)); // [3, 2]

function testE($a, $b): bool
{
    if ($a + $b == 3) {
        return true;
    } else {
        return null;
    }
}

var_dump(testE(1, 2)); // true
// var_dump(testE(1.1, 2.2)); //TypeError: Return value of testE() must be of the type bool, null returned

function testF($a, $b): array
{
    return [
        $a + $b,
        $a * $b,
    ];
}
var_dump(testF(1, 2)); // [3, 2]

interface iA
{

}
class A implements iA
{}
class B extends A
{
    public $b = 'call me B!';
}

function testG(): A
{
    return new B();
}

function testH(): B
{
    return new B();
}

function testI(): iA
{
    return new B();
}

var_dump(testG()); // B的实例
var_dump(testH()); // B的实例
var_dump(testI()); // B的实例

function testJ(): void
{
    echo "testJ";
    // return 1;
}
var_dump(testJ());
