<?php

class A implements Serializable {
    private $data;
    public function __construct(){
        echo '__construct', PHP_EOL;
        $this->data = "This is Class A";
    }

    public function serialize(){
        echo 'serialize', PHP_EOL;
        return serialize($this->data);
    }

    public function unserialize($data){
        echo 'unserialize', PHP_EOL;
        $this->data = unserialize($data);
    }

    public function __destruct(){
        echo '__destruct', PHP_EOL;
    }

    public function __weakup(){
        echo '__weakup', PHP_EOL;
    }

    public function __sleep(){
        echo '__destruct', PHP_EOL;
    }
    
}

$a = new A();
$aSerialize = serialize($a);

var_dump($aSerialize);
// "C:1:"A":23:{s:15:"This is Class A";}"
$a1 = unserialize($aSerialize);
var_dump($a1);

// object(A)#2 (1) {
//     ["data":"A":private]=>string(15) "This is Class A"
// }

// 各种类型序列化的结果
$int = 110;
$string = '110';
$bool = FALSE;
$null = NULL;
$array = [1,2,3];

var_dump(serialize($int)); // "i:110;"
var_dump(serialize($string)); // "s:3:"110";"
var_dump(serialize($bool)); // "b:0;"
var_dump(serialize($null)); // "N;"
var_dump(serialize($array)); // "a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}"

// 正常对象类型序列化的结果
class B {
    private $data = "This is Class B";

}
$b = new B();
$bSerialize = serialize($b);

var_dump ($bSerialize); // "O:1:"B":1:{s:7:"Bdata";s:15:"This is Class B";}"

var_dump(unserialize("O:1:\"B\":1:{s:7:\"\0B\0data\";s:15:\"This is Class B\";}"));

// object(B)#4 (1) {
//     ["data":"B":private]=>string(15) "This is Class B"
// }


// 模拟一个未定义的D类
var_dump(unserialize("O:1:\"D\":2:{s:7:\"\0D\0data\";s:15:\"This is Class D\";s:3:\"int\";i:220;}"));

// object(__PHP_Incomplete_Class)#4 (3) {
//     ["__PHP_Incomplete_Class_Name"]=>string(1) "D"
//     ["data":"D":private]=>string(15) "This is Class D"
//     ["int"]=>int(220)
// }

// 把O:替换成C:
var_dump(unserialize(str_replace('O:', 'C:', $bSerialize))); // false
// 把未定义类的O:替换成C:
var_dump(unserialize(str_replace('O:', 'C:', "O:1:\"D\":2:{s:7:\"\0D\0data\";s:15:\"This is Class D\";s:3:\"int\";i:220;}"))); // false

// Warning: Erroneous data format for unserializing 'A'
var_dump(unserialize(str_replace('C:', 'O:', $aSerialize))); // false
