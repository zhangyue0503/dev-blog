<?php

$a = function () {
    echo "this is testA";
};
$a(); // this is testA

function testA ($a) {
    var_dump($a); // class Closure#1 (0) {}
}
testA($a);

$b = function ($name) {
    echo 'this is ' . $name;
};

$b('Bob'); // this is Bob

$age = 16;
$c = function ($name) {
    echo 'this is ' . $name . ', Age is ' . $age;
};

$c('Charles'); // this is Charles, Age is

$c = function ($name) use ($age) {
    echo 'this is ' . $name . ', Age is ' . $age;
};

$c('Charles'); // this is Charles, Age is 16

function testD(){
    global $testOutVar;
    echo $testOutVar;
}
$d = function () use ($testOutVar) {
    echo $testOutVar;
};
$dd = function () {
    global $testOutVar;
    echo $testOutVar;
};
$testOutVar = 'this is d';
$d(); // NULL
testD(); // this is d
$dd(); // this is d



$testOutVar = 'this is e';
$e = function () use ($testOutVar) {
    echo $testOutVar;
};
$e(); // this is e

$testOutVar = 'this is ee';
$e(); // this is e

$testOutVar = 'this is f';
$f = function () use (&$testOutVar) {
    echo $testOutVar;
};
$f(); // this is f

$testOutVar = 'this is ff';
$f(); // this is ff

class G
{}
$g = function () {
    global $age;
    echo $age; // 16
    $gClass = new G();
    var_dump($gClass); // G info
};
$g();

function testH()
{
    return function ($name) {
        echo "this is " . $name;
    };
}
testH()("testH's closure!"); // this is testH's closure!

$age = 18;
class A
{
    private $name = 'A Class';
    public function testA()
    {
        $insName = 'test A function';
        $instrinsic = function () {
            var_dump($this); // this info
            echo $this->name; // A Class
            echo $age; // NULL
            echo $insName; // null
        };
        $instrinsic();

        $instrinsic1 = function () {
            global $age, $insName;
            echo $age; // 18
            echo $insName; // NULL
        };
        $instrinsic1();

        global $age;
        $instrinsic2 = function () use ($age, $insName) {
            echo $age; // 18
            echo $insName; // test A function
        };
        $instrinsic2();

    }
}

$aClass = new A();
$aClass->testA();

$arr1 = [
    ['name' => 'Asia'],
    ['name' => 'Europe'],
    ['name' => 'America'],
];

$arr1Params = ' is good!';
// foreach($arr1 as $k=>$a){
//     $arr1[$k]['name'] = $a['name'] . $arr1Params;
// }
// print_r($arr1);

array_walk($arr1, function (&$v) use ($arr1Params) {
    $v['name'] .= ' is good!';
});
print_r($arr1);

class B
{}
class C
{}
class D
{}
class Ioc
{
    public $objs = [];
    public $containers = [];

    public function __construct()
    {
        $this->objs['b'] = function () {
            return new B();
        };
        $this->objs['c'] = function () {
            return new C();
        };
        $this->objs['d'] = function () {
            return new D();
        };
    }
    public function bind($name)
    {
        if (!isset($this->containers[$name])) {
            if (isset($this->objs[$name])) {
                $this->containers[$name] = $this->objs[$name]();
            } else {
                return null;
            }
        }
        return $this->containers[$name];
    }
}

$ioc = new Ioc();
$bClass = $ioc->bind('b');
$cClass = $ioc->bind('c');
$dClass = $ioc->bind('d');
$eClass = $ioc->bind('e');

var_dump($bClass); // B
var_dump($cClass); // C
var_dump($dClass); // D
var_dump($eClass); // NULL


// https://www.php.net/manual/zh/functions.anonymous.php#100545
$fib = function ($n) use (&$fib) {
    if ($n == 0 || $n == 1) {
        return 1;
    }

    return $fib($n - 1) + $fib($n - 2);
};

echo $fib(10);

https://www.php.net/manual/zh/functions.anonymous.php#119388
// $fruits = ['apples', 'oranges'];
// $example = function () use ($fruits[0]) { // Parse error: syntax error, unexpected '[', expecting ',' or ')'
//     echo $fruits[0]; 
// };
// $example();
