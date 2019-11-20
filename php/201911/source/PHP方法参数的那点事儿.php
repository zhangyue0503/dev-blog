<?php
$a = 1;
function test(&$arg)
{
    $arg++;
}
test($a);
echo $a; // 2

class A
{
    public $a = 1;
}
function testA($obj)
{
    $o = clone $obj;
    $o->a++;
}
$o = new A();
testA($o);
echo $o->a; // 2

// function testArgsA($a = 1, $b){
//     echo $a+$b;
// }

// testArgs();

function testArgsB($a = 1, $b = 2)
{
    echo $a + $b;
}

testArgsB();

function testArgsC($a, $b = 2)
{
    echo $a + $b;
}

testArgsC(1);

function testArgsD($a = null)
{
    if ($a) {
        echo $a;
    }
}

testArgsD(1);
testArgsD('a');

function testAssignA(int $a = 0)
{
    echo $a;
}

testAssignA(1);
// testAssignA("a"); // error

// function testAssignB(integer $a = 0)
// {
//     echo $a;
// }

function testAssignC(string $a = '')
{
    if ($a) {
        echo __FUNCTION__ . ':' . $a;
    }
}

testAssignC(); //
// testAssignC(NULL); //TypeError
testAssignC(1); // testAssignC:a

function testAssignD(string $a = null)
{
    if ($a == null) {
        echo 'null';
    }
}

testAssignD(null); // null

function testAssignE(?string $a)
{
    if ($a == null) {
        echo 'null';
    }
}
testAssignE(null); // null

function testMultiArgsA($a)
{
    var_dump(func_get_arg(2));
    var_dump(func_get_args());
    var_dump(func_num_args());
    echo $a;
}

testMultiArgsA(1, 2, 3, 4);

function testMultiArgsB($a, ...$b)
{
    var_dump(func_get_arg(2));
    var_dump(func_get_args());
    var_dump(func_num_args());
    echo $a;
    var_dump($b); // 除$a以外的
}

testMultiArgsB(1, 2, 3, 4);


function testMultiArgsC($a, $b){
    echo $a, $b;
}

testMultiArgsC(...[1, 2]);


$array1 = [[1],[2],[3]];
$array2 = [4];
$array3 = [[5],[6],[7]];

$result = array_merge(...$array1); // Legal, of course: $result == [1,2,3];
print_r($result);
$result = array_merge($array2, ...$array1); // $result == [4,1,2,3]
print_r($result);
// $result = array_merge(...$array1, $array2); // Fatal error: Cannot use positional argument after argument unpacking.
$result = array_merge(...$array1, ...$array3); // Legal! $result == [1,2,3,5,6,7]
print_r($result);



