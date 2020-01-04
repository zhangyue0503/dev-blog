<?php

function bool2str($bool)
{
    if ($bool === false) {
        return 'FALSE';
    } else {
        return 'TRUE';
    }
}

function compareObjects(&$o1, &$o2)
{
    echo 'o1 == o2 : ' . bool2str($o1 == $o2) . "\n";
    echo 'o1 === o2 : ' . bool2str($o1 === $o2) . "\n";
}

class A {
    private $t = true;
    public function setT($t){
        $this->t = $t;
    }
}

class B {
    protected $t = true;
    public function setT1($t){
        $this->t = $t;
    }
}

class C {
    private $t = true;
    public function setT($t){
        $this->t = $t;
    }
}

$a1 = new A();
$a2 = new A();

compareObjects($a1, $a2); // 相同的类
// o1 == o2 : TRUE
// o1 === o2 : FALSE

$a11 = $a1;

compareObjects($a1, $a11); // 相同的实例
// o1 == o2 : TRUE
// o1 === o2 : TRUE

$a11->setT(false);

compareObjects($a1, $a11); // 相同实例属性值不同
// o1 == o2 : TRUE
// o1 === o2 : TRUE

$b = new B();

compareObjects($a1, $b); // 不同的类
// o1 == o2 : FALSE
// o1 === o2 : FALSE

$c = new C();

compareObjects($a1, $b); // 相同属性不同的类
// o1 == o2 : FALSE
// o1 === o2 : FALSE


$c = new stdClass();
$d = new stdClass();

$c->t1 = 'c';
$c->t2 = 10;
$c->t3 = 50;

$d->t1 = 'c';
$d->t2 = 11;
$d->t3 = 40;

echo 'c > d:', $c > $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c < d:', $c < $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE

$d->t2 = 10; // $t2属性改成相等的
echo 'c > d:', $c > $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c < d:', $c < $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$d->t3 = 50; // $c、$d属性都相等了
echo 'c >= d:', $c >= $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c <= d:', $c <= $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c == d:', $c == $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c === d:', $c === $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$c1 = clone $c; // 复制同一个对象
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$c1->t4 = 'f'; // 增加了一个属性
echo 'c > c1:', $c > $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c < c1:', $c < $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

unset($c1->t4);
$c1->t1 = 'd';  // 修改了一个值
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

