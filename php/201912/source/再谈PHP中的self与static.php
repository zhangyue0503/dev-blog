<?php

class A
{
    public static $name = "I'm A!";

    public function selfName()
    {
        echo self::$name;
    }

    public function staticName()
    {
        echo static::$name;
    }
}

class B extends A{
    public static $name = "I'm B!";
}

$b = new B();
$b->selfName(); // I'm A!
$b->staticName(); // I'm B!

class C extends A{
    public static $name = "I'm C!";

    public function selfName()
    {
        echo self::$name;
    }
}

$c = new C();
$c->selfName(); // I'm C!
$c->staticName(); // I'm C!

