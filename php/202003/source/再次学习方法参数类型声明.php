<?php

declare (strict_types = 1);

function testInt(int $a)
{
    echo $a, PHP_EOL;
}

testInt(1);
// testInt(1.1); // Fatal error: Uncaught TypeError: Argument 1 passed to testInt() must be of the type int
// testInt('52AABB'); // Fatal error: Uncaught TypeError: Argument 1 passed to testInt() must be of the type int
// testInt(true); // Fatal error: Uncaught TypeError: Argument 1 passed to testInt() must be of the type int

function testFloat(float $a)
{
    echo $a, PHP_EOL;
}

testFloat(1);
testFloat(1.1);
// testFloat('52AABB'); // Fatal error: Uncaught TypeError: Argument 1 passed to testInt() must be of the type int
testInt(true); // Fatal error: Uncaught TypeError: Argument 1 passed to testInt() must be of the type int

function testString(string $a)
{
    echo $a, PHP_EOL;
}

// testString(1);  // Fatal error: Uncaught TypeError: Argument 1 passed to testString() must be of the type string
// testString(1.1);  // Fatal error: Uncaught TypeError: Argument 1 passed to testString() must be of the type string
testString('52AABB');
// testString(true); // Fatal error: Uncaught TypeError: Argument 1 passed to testString() must be of the type string

function testBool(bool $a)
{
    var_dump($a);
}
testBool(true);
testBool(false);
// testBool('52AABB'); // Fatal error: Uncaught TypeError: Argument 1 passed to testBool() must be of the type bool
// testBool(1); // Fatal error: Uncaught TypeError: Argument 1 passed to testBool() must be of the type bool

function testIterable(iterable $iterator)
{
    echo gettype($iterator), ':', PHP_EOL;
    foreach ($iterator as $it) {
        echo $it, PHP_EOL;
    }
}

testIterable([1, 2, 3]);
testIterable(new ArrayIterator([1, 2, 3]));
// Generator对象
testIterable((function () {
    yield 1;
    yield 2;
    yield 3;
})());
// testIterable(1); // Fatal error: Uncaught TypeError: Argument 1 passed to testIterable() must be iterable

