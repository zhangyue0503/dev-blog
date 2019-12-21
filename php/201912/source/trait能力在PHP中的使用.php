<?php

trait A
{
    public $a = 'A';
    public function testA()
    {
        echo 'This is ' . $this->a;
    }
}

class classA
{
    use A;
}
class classB
{
    use A;
    public function __construct()
    {
        $this->a = 'B';
    }
}

$a = new classA();
$b = new classB();

$a->testA();
$b->testA();


trait B {
    function test(){
        echo 'This is trait B!';
    }
}
trait C {
    function test(){
        echo 'This is trait C!';
    }
}

class testB{
    use B, C;
    function test(){
        echo 'This is class testB!';
    }
}

$b = new testB();
$b->test(); // This is class testB!

// class testC{
//     use B, C;
// }

// $c = new testC();
// $c->test(); // Fatal error: Trait method test has not been applied, because there are collisions with other trait methods on testC

trait D{
    function test(){
        echo 'This is trait D!';
    }
}

class parentD{
    function test(){
        echo 'This is class parentD';
    }
}

class testD extends parentD{
    use D;
}

$d = new testD();
$d->test(); // This is trait D!

class testE{
    use B, C {
        B::test insteadOf C;
        C::test as testC;
    }
}
$e = new testE();
$e->test(); // This is trait B!
$e->testC(); // This is trait C!


trait F{
    function test(){
        echo 'This is trait F!';
    }
    abstract function show();
}

class testF{
    use F;
    function show(){
        echo 'This is class testF!';
    }
}
$f = new testF();
$f->test();
$f->show();












