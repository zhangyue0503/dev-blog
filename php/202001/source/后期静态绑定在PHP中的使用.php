<?php

class A
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        self::who();
    }
}

class B extends A
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

B::test(); // A

class C
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        static::who();
    }
}

class D extends C
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

D::test(); // D

class E
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
    public static function test()
    {
        self::who();
        static::who();
    }
}

class F extends E
{
    public static function who()
    {
        echo __CLASS__, PHP_EOL;
    }
}

class G extends F
{
    public static function who()
    {
        parent::who();
        echo __CLASS__, PHP_EOL;
    }
}

G::test();

// E
// F
// G

class H
{
    public static function who()
    {
        echo __CLASS__ . ':' . join(',', func_get_args()), PHP_EOL;
    }
    public static function test()
    {
        echo get_called_class(), PHP_EOL;
        forward_static_call('who', 'a', 'b'); // xxx:a,b
        forward_static_call(['I', 'who'], 'c', 'd'); // I:c,d
        forward_static_call_array(['H', 'who'], ['e', 'f']); // H:e,f
    }
}

class I extends H
{
    public static function who()
    {
        echo __CLASS__ . ':' . join(',', func_get_args()), PHP_EOL;
    }
}

function who()
{
    echo 'xxx:' . join(',', func_get_args()), PHP_EOL;
}

H::test(); // H
// xxx:a,b
// I:c,d
// H:e,f
I::test(); // I
// xxx:a,b
// I:c,d
// H:e,f