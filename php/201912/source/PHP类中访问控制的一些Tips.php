<?php

class A {
    private $private;
    protected $protected;
    public $public;

    public function setPrivate($p){
        $this->private = $p;
    }

    public function setProtected($p){
        $this->protected = $p;
    }

    public function setPublic($p){
        $this->public = $p;
    }

    public function testA(){
        echo $this->private, '===', $this->protected, '===', $this->public, PHP_EOL;
    }
}

class B extends A{
    public function testB(){
        echo $this->private, '===';
        echo $this->protected, '===', $this->public, PHP_EOL;
    }
}

$a = new A();
// $a->private = 'a-private'; // atal error: Uncaught Error: Cannot access private property A::$private 
$a->setPrivate('a-private');
// $a->protected = 'a-protected'; // atal error: Uncaught Error: Cannot access protected property A::$protected 
$a->setProtected('a-protected');
$a->public = 'c-public';
$a->testA();

echo "Out side public:" . $a->public, PHP_EOL;
// echo "Out side private:" . $a->private, PHP_EOL; // Fatal error: Uncaught Error: Cannot access private property A::$private
// echo "Out side protected:" . $a->protected, PHP_EOL; // Fatal error: Uncaught Error: Cannot access protected property A::$protected

$b = new B();
$b->setProtected('b-protected');
$b->public = 'b-public';
$b->testB();

$b->setPrivate('b-private');
$b->testB();


class C extends A {
    private $private;

    public function testC(){
        echo $this->private, '===', $this->protected, '===', $this->public, PHP_EOL;
    }

    public function setPrivate($p){
        $this->private = $p;
    }
}

$c = new C();
$c->setProtected('c-protected');
$c->public = 'c-public';
$c->setPrivate('c-private');
$c->testC();

class D {
    public function testD(){
        $this->show();
    }
    private function show(){
        echo 'This is D', PHP_EOL;
    }
}

class E extends D {
    private function show(){
        echo 'This is E', PHP_EOL;
    }
}

$e = new E();
$e->testD(); // This is D


