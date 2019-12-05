<?php

class A
{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
        echo "A：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        echo "A：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

$a = new A('$a');
echo '-----', PHP_EOL;

class B extends A
{
    public function __construct($name)
    {
        $this->name = $name;
        parent::__construct($name);
        echo "B：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        parent::__destruct();
        echo "B：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

class C extends A
{
    public function __construct($name)
    {
        $this->name = $name;
        echo "C：构造函数被调用，{$this->name}", PHP_EOL;
    }

    public function __destruct()
    {
        echo "C：析构函数被调用，{$this->name}", PHP_EOL;
    }
}

class D extends A
{

}
// unset($a); // $a的析构提前
// $a = null; // $a的析构提前
$b = new B('$b');

$c = new C('$c');

$d = new D('$d');

echo '-----', PHP_EOL;

// A：构造函数被调用，$a
// -----
// A：构造函数被调用，$b
// B：构造函数被调用，$b
// C：构造函数被调用，$c
// A：构造函数被调用，$d
// -----
// A：析构函数被调用，$d
// C：析构函数被调用，$c
// A：析构函数被调用，$b
// B：析构函数被调用，$b
// A：析构函数被调用，$a

class E
{
    public $name;
    public $obj;
    public function __destruct()
    {
        echo "E：析构函数被调用，" . $this->name, PHP_EOL;
        echo '-----', PHP_EOL;
    }
}

$e1 = new E();
$e1->name = 'e1';
$e2 = new E();
$e2->name = 'e2';

$e1->obj = $e2;
$e2->obj = $e1;
$e1 = null;
$e2 = null;
// gc_collect_cycles();
// 使用gc回收后结果
// E：析构函数被调用，e1
// -----
// E：析构函数被调用，e2
// -----
// E destory
// E：析构函数被调用，e3
// -----
// E：析构函数被调用，e4
// -----

$e3 = new E();
$e3->name = 'e3';
$e4 = new E();
$e4->name = 'e4';

$e3->obj = $e4;
$e4->obj = $e3;
$e3 = null;
$e4 = null;

echo 'E destory', PHP_EOL;

// 不使用gc回收的结果
// E destory
// E：析构函数被调用，e1
// -----
// E：析构函数被调用，e2
// -----
// E：析构函数被调用，e3
// -----
// E：析构函数被调用，e4
// -----

class F
{
    public function f() 
    {
        // Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP; F has a deprecated constructor 
        echo "F：这也是构造函数，与类同名，不区分大小写", PHP_EOL;
    }
    // function F(){
    //     // Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP; F has a deprecated constructor 
    //     echo "F：这也是构造函数，与类同名", PHP_EOL;
    // }
    // function __construct(){
    //     echo "F：这是构造函数，__construct()", PHP_EOL;
    // }
}
$f = new F();

class Singleton
{
    private static $instance;
    public static function getInstance()
    {
        return self::$instance == null ? self::$instance = new Singleton() : self::$instance;
    }

    private function __construct()
    {

    }
}

$s1 = Singleton::getInstance();
$s2 = Singleton::getInstance();
echo $s1 === $s2 ? 's1 === s2' : 's1 !== s2', PHP_EOL;

// $s3 = new Singleton(); // Fatal error: Uncaught Error: Call to private Singleton::__construct() from invalid context

class R
{
    private $a;
    private $b;
    public function __construct()
    {
        echo '默认构造函数', PHP_EOL;
        $argNums = func_num_args();
        $args = func_get_args();
        if ($argNums == 1) {
            $this->constructA(...$args);
        } elseif ($argNums == 2) {
            $this->constructB(...$args);
        }
    }
    public function constructA($a)
    {
        echo '一个参数的构造函数重载，' . $a, PHP_EOL;
        $this->a = $a;
    }
    public function constructB($a, $b)
    {
        echo '两个参数的构造函数重载，' . $a . '，' . $b, PHP_EOL;
        $this->a = $a;
        $this->b = $b;
    }
}
$r1 = new R(); // 默认构造函数
$r2 = new R('arg1'); // 默认构造函数 一个参数的构造函数重载，arg1
$r3 = new R('arg1', 'arg2'); // 默认构造函数 两个参数的构造函数重载，arg1，arg2
