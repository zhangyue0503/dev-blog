<?php

// 普通遍历
class A
{
    public $a1 = '1';
    public $a2 = '2';
    public $a3 = '3';

    private $a4 = '4';
    protected $a5 = '5';

    public $a6 = '6';

    public function test()
    {
        echo 'test';
    }
}
$a = new A();
foreach ($a as $k => $v) {
    echo $k, '===', $v, PHP_EOL;
}

// a1===1
// a2===2
// a3===3
// a6===6

// 实现迭代器接口
class B implements Iterator
{
    private $var = [];

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->var = $array;
        }
    }

    public function rewind()
    {
        echo "rewinding\n";
        reset($this->var);
    }

    public function current()
    {
        $var = current($this->var);
        echo "current: $var\n";
        return $var;
    }

    public function key()
    {
        $var = key($this->var);
        echo "key: $var\n";
        return $var;
    }

    public function next()
    {
        $var = next($this->var);
        echo "next: $var\n";
        return $var;
    }

    public function valid()
    {
        $var = $this->current() !== false;
        echo "valid: {$var}\n";
        return $var;
    }
}

$b = new B([1, 2, 3, 4]);

foreach ($b as $k => $v) {
    echo $k, '===', $v, PHP_EOL;
}

// rewinding
// current: 1
// valid: 1
// current: 1
// key: 0
// 0===1
// next: 2
// current: 2
// valid: 1
// current: 2
// key: 1
// 1===2
// next: 3
// current: 3
// valid: 1
// current: 3
// key: 2
// 2===3
// next: 4
// current: 4
// valid: 1
// current: 4
// key: 3
// 3===4
// next:
// current:
// valid:

// 让类可以像数组一样操作
class C implements ArrayAccess, IteratorAggregate
{
    private $container = [];
    public function __construct()
    {
        $this->container = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
        ];
    }
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function getIterator() {
        return new B($this->container);
    }
}

$c = new C();
var_dump($c);

$c['four'] = 4;
var_dump($c);

$c[] = 5;
$c[] = 6;
var_dump($c);

foreach($c as $k=>$v){
    echo $k, '===', $v, PHP_EOL;
}

// rewinding
// current: 1
// valid: 1
// current: 1
// key: one
// one===1
// next: 2
// current: 2
// valid: 1
// current: 2
// key: two
// two===2
// next: 3
// current: 3
// valid: 1
// current: 3
// key: three
// three===3
// next: 4
// current: 4
// valid: 1
// current: 4
// key: four
// four===4
// next: 5
// current: 5
// valid: 1
// current: 5
// key: 0
// 0===5
// next: 6
// current: 6
// valid: 1
// current: 6
// key: 1
// 1===6
// next: 
// current: 
// valid: 