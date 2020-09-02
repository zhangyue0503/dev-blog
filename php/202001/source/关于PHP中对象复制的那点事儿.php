<?php

// // clone方法
// class testA{
//     public $testValue;
// }
// class A
// {
//     public static $reference = 0;
//     public $instanceReference = 0;
//     public $t;

//     public function __construct()
//     {
//         $this->instanceReference = ++self::$reference;
//         $this->t = new testA();

//     }

//     public function __clone()
//     {
//         $this->instanceReference = ++self::$reference;
//         $this->t = new testA();
//     }
// }

// $a1 = new A();
// $a2 = new A();
// $a11 = clone $a1;
// $a22 = $a2;

// var_dump($a11); // $instanceReference, 3
// var_dump($a22); // $instanceReference, 2

// $a1->t->testValue = '现在是a1';
// echo $a11->t->testValue, PHP_EOL; // ''


// $a2->t->testValue = '现在是a2';
// echo $a22->t->testValue, PHP_EOL; // 现在是a2
// $a22->t->testValue = '现在是a22';
// echo $a2->t->testValue, PHP_EOL; // 现在是a22

// // 使用clone后
// $a22 = clone $a2;
// var_dump($a22); // $instanceReference, 4

// $a2->t->testValue = '现在是a2';
// echo $a22->t->testValue, PHP_EOL; // NULL
// $a22->t->testValue = '现在是a22';
// echo $a2->t->testValue, PHP_EOL; // 现在是a2




// 循环引用问题
class B
{
    public $that;

    function __clone()
    {
        // Segmentation fault: 11
        // $this->that = clone $this->that;
        $this->that = unserialize(serialize($this->that));
        // object(B)#6 (1) {
        //     ["that"]=>
        //     object(B)#7 (1) {
        //       ["that"]=>
        //       object(B)#8 (1) {
        //         ["that"]=>
        //         *RECURSION*  无限递归
        //       }
        //     }
        //   }
    }
}

$b1 = new B();
$b2 = new B();
$b1->that = $b2;
$b2->that = $b1;


$b3 = clone $b1;

var_dump($b3);


