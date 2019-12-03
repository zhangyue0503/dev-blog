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
$b->selfName();
$b->staticName();

class C extends A{
    public static $name = "I'm C!";

    public function selfName()
    {
        echo self::$name;
    }
}

$c = new C();
$c->selfName();
$c->staticName();

