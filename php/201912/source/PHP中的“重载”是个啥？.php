<?php

class A{
    function foo($a){
        echo $a;
    }
    // Fatal error: Cannot redeclare A::foo()
    function foo($a, $b){
        echo $a+$b;
    }
}

// 重写
class A
{
    public function test($a)
    {
        echo 'This is A：' . $a, PHP_EOL;
    }
}

class childA extends A
{
    public function test($a)
    {
        echo 'This is A child：' . $a, PHP_EOL;
    }
}

$ca = new childA();
$ca->test(1);

// 重载
class B
{
    public function foo(...$args)
    {
        if (count($args) == 2) {
            $this->fooAdd(...$args);
        } else if (count($args) == 1) {
            echo $args[0], PHP_EOL;
        } else {
            echo 'other';
        }
    }

    private function fooAdd($a, $b)
    {
        echo $a + $b, PHP_EOL;
    }
}

$b = new B();
$b->foo(1);
$b->foo(1, 2);


// 使用__call()进行重载
class C
{
    public function __call($name, $args)
    {
        if ($name == 'foo') {
            $funcIndex = count($args);
            if (method_exists($this, 'foo' . $funcIndex)) {
                return $this->{'foo' . $funcIndex}(...$args);
            }
        }
    }

    private function foo1($a)
    {
        echo $a, PHP_EOL;
    }

    private function foo2($a, $b)
    {
        echo $a + $b, PHP_EOL;
    }

    private function foo3($a, $b, $c)
    {
        echo $a + $b + $c, PHP_EOL;
    }

}

$c = new C();
$c->foo(1);
$c->foo(1, 2);
$c->foo(1, 2, 3);

// 参数类型不同的重载
class D {
    function __call($name, $args){
        if($name == 'foo'){
            if(is_string($args[0])){
                $this->fooString($args[0]);
            }else {
                $this->fooInt($args[0]);
            }
        }
    }
    private function fooInt(int $a){
        echo $a . ' is Int', PHP_EOL;
    }

    private function fooString(string $a){
        echo $a . ' is String', PHP_EOL;
    }
}

$d = new D();
$d->foo(1);
$d->foo('1');


