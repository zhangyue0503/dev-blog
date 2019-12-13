<?php

class A
{
    static $a = 'This is A!';

    public function show()
    {
        echo self::$a, PHP_EOL;
        echo static::$a, PHP_EOL;
    }
}

class B extends A
{
    static $a = 'This is B!';

}

$b = new B;
$b->show();

class C
{
    static $c = 1;
    public $d = 1;
}
class D extends C
{
    public function add()
    {
        self::$c++;
        $this->d++;
    }
}

$d1 = new D();
$d2 = new D();

$d1->add();
echo 'c：' . D::$c . ',d：' . $d1->d . ';', PHP_EOL;

$d2->add();
echo 'c：' . D::$c . ',d：' . $d2->d . ';', PHP_EOL;

class E {
    public static function test(){
        echo "This is E test!";
    }
}

class F extends E{
    public static function t(){
        self::test();
        parent::test();
        static::test();
    }

    public static function test(){
        echo "This is F test!";
    }
}

F::t();
