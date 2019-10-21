<?php

// 普通赋值
$v = '1';
$c = $v;
$c = '2';
echo $v, PHP_EOL;

// 引用赋值
$b = &$v;
$b = '3';
echo $v, PHP_EOL;

// 数组也是普通赋值
$arr1 = [1,2,3];
$arr2 = $arr1;
$arr2[1] = 5;
print_r($arr1);

// 对象都是引用赋值
class A {
    public $name = '我是A';
}

$a = new A();
$b = $a;

echo $a->name, PHP_EOL;
echo $b->name, PHP_EOL;

$b->name = '我是B';
echo $a->name, PHP_EOL;

// 使用克隆解决引用传递问题
class Child{
    public $name = '我是A1的下级';
}
class A1 {
    public $name = '我是A';
    public $child;

    function __construct(){
        $this->child = new Child();
    }

    function __clone(){
        $this->name = $this->name;
        // new 或者用Child的克隆都可以
        // $this->child = new Child();
        $this->child = clone $this->child;
    }
}

$a1 = new A1();

echo $a1->name, PHP_EOL; // 输出a1原始的内容
echo $a1->child->name, PHP_EOL;

$b1 = $a1;
echo $b1->name, PHP_EOL; // b1现在也是a1的内容
echo $b1->child->name, PHP_EOL;

$b1->name = '我是B1'; // b1修改内容
$b1->child->name = '我是B1的下级';
echo $a1->name, PHP_EOL; // a1变成b1的内容了
echo $a1->child->name, PHP_EOL;

// 使用__clone
$b2 = clone $b1; // b2克隆b1
$b2->name = '我是B2'; // b2修改内容
$b2->child->name = '我是B2的下级';
echo $b1->name, PHP_EOL; // b1不会变成b2修改的内容
echo $b1->child->name, PHP_EOL;
echo $b2->name, PHP_EOL; // b2修改的内容没问题，b1、b2不是一个货了
echo $b2->child->name, PHP_EOL;


