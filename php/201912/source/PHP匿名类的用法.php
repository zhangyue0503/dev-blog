<?php
// 直接定义
$objA = new class{
    public function getName(){
        echo "I'm objA";
    }
};
$objA->getName();

// 方法中返回
function testA(){
    return new class{
        public function getName(){
            echo "I'm testA's obj"; 
        }
    };
}

$objB = testA();
$objB->getName();

// 作为参数
function testB($testBobj){
    echo $testBobj->getName();
}
testB(new class{
    public function getName(){
        echo "I'm testB's obj"; 
    }
});

// 继承、接口、访问控制等

class A{
    public $propA = 'A';
    public function getProp(){
        echo $this->propA;
    }
}
trait B{
    public function getName(){
        echo 'trait B';
    }
}
interface C{
    function show();
}
$p4 = 'b4';
$objC = new class($p4) extends A implements C{
    use B;
    private $prop1 = 'b1';
    protected $prop2 = 'b2';
    public $prop3 = 'b3';

    public function __construct($prop4){
        echo $prop4;
    }

    public function getProp(){
        parent::getProp();
        echo $this->prop1, '===',$this->prop2, '===',$this->prop3, '===',$this->propA;
        $this->getName();
        $this->show();
    }
    public function show(){
        echo 'show';
    }
};

$objC->getProp();

// 匿名类的名称是通过引擎赋予的
var_dump(get_class($objC));

// 声明的同一个匿名类，所创建的对象都是这个类的实例
var_dump(get_class(testA()) == get_class(testA()));

// 静态变量
function testD(){
    return new class{
        public static $name;
    };
}
$objD1 = testD();
$objD1::$name = 'objD1';

$objD2 = testD();
$objD2::$name = 'objD2';

echo $objD1::$name;



