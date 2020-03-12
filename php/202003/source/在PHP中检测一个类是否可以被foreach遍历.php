<?php

class Obj1
{
    public $v = 'V:Obj1';
    private $prv = 'prv:Obj1';
}

$obj1 = new Obj1();
echo $obj1 instanceof Traversable ? 'yes' : 'no', PHP_EOL; // no

class Obj2 implements IteratorAggregate
{
    public $v = 'V:Obj2';
    private $prv = 'prv:Obj2';
    public function getIterator()
    {
        return new ArrayIterator([
            'v' => $this->v,
            'prv' => $this->prv,
        ]);
    }
}

$obj2 = new Obj2();
echo $obj2 instanceof Traversable ? 'yes' : 'no', PHP_EOL; // yes

// Fatal error: Class ImplTraversable must implement interface Traversable as part of either Iterator or IteratorAggregate in Unknown 
// class ImplTraversable implements Traversable{

// }

// foreach
foreach ($obj1 as $o1) {
    echo $o1, PHP_EOL;
}

foreach ($obj2 as $o2) {
    echo $o2, PHP_EOL;
}

// V:Obj1
// V:Obj2
// prv:Obj2


$arr = [1, 2, 3, 4];
$obj3 = (object) $arr;
echo $obj3 instanceof Traversable ? 'yes' : 'no', PHP_EOL; // no

foreach ($obj3 as $o3) {
    echo $o3, PHP_EOL;
}
