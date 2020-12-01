<?php


// // 普通变量引用计数
// $a = "I am a String";

// xdebug_debug_zval('a');
// // a: (refcount=1, is_ref=0)='I am a String'

// $b = $a;
// xdebug_debug_zval('a');
// // a: (refcount=1, is_ref=0)='I am a String'

// $b = &$a;
// xdebug_debug_zval('a');
// // a: (refcount=2, is_ref=1)='I am a String'

// $c = &$a;
// xdebug_debug_zval('a');
// // a: (refcount=3, is_ref=1)='I am a String'

// unset($c, $b);
// xdebug_debug_zval('a');
// // a: (refcount=1, is_ref=1)='I am a String'

// $b = &$a;
// $c = &$a;
// $b = "I am a String new";
// xdebug_debug_zval('a');
// // a: (refcount=3, is_ref=1)='I am a String new'

// unset($a);
// xdebug_debug_zval('a');
// // a: no such symbol

// // 对象引用计数
// class A{

// }
// $objA = new A();

// xdebug_debug_zval('objA');
// // objA: (refcount=1, is_ref=0)=class A {  }

// $objB = $objA;
// xdebug_debug_zval('objA');
// // objA: (refcount=2, is_ref=0)=class A {  }

// $objC = $objA;
// xdebug_debug_zval('objA');
// // objA: (refcount=3, is_ref=0)=class A {  }

// unset($objB);
// class C{

// }
// $objC = new C;
// xdebug_debug_zval('objA');
// // objA: (refcount=1, is_ref=0)=class A {  }
// // 和变量不同，对象引用是引用的符号表，$objC修改内容后切断了引用指向，不会改变$objA

// // 数组引用计数
// $arrA = [
//     'a'=>1,
//     'b'=>2,
// ];
// xdebug_debug_zval('arrA');
// // arrA: (refcount=2, is_ref=0)=array (
// //     'a' => (refcount=0, is_ref=0)=1, 
// //     'b' => (refcount=0, is_ref=0)=2
// // )

// $arrB = $arrA;
// $arrC = $arrA;
// xdebug_debug_zval('arrA');
// // arrA: (refcount=4, is_ref=0)=array (
// //     'a' => (refcount=0, is_ref=0)=1, 
// //     'b' => (refcount=0, is_ref=0)=2
// // )

// unset($arrB);
// $arrC = ['c'=>3];
// xdebug_debug_zval('arrA');
// // arrA: (refcount=2, is_ref=0)=array (
// //     'a' => (refcount=0, is_ref=0)=1, 
// //     'b' => (refcount=0, is_ref=0)=2
// // )

// // 添加一个已经存在的元素
// $arrA['c'] = &$arrA['a'];
// xdebug_debug_zval('arrA');
// // arrA: (refcount=1, is_ref=0)=array (
// //     'a' => (refcount=2, is_ref=1)=1, 
// //     'b' => (refcount=0, is_ref=0)=2, 
// //     'c' => (refcount=2, is_ref=1)=1
// // )




// 对象循环引用
class D{
    public $d;
}
$d = new D;
$d->d = $d;
xdebug_debug_zval('d');
// d: (refcount=2, is_ref=0)=class D { 
//     public $d = (refcount=2, is_ref=0)=... 
// }

// 数组循环引用
$arrA['arrA'] = &$arrA;
xdebug_debug_zval('arrA');
// arrA: (refcount=2, is_ref=1)=array (
//     'a' => (refcount=0, is_ref=0)=1, 
//     'b' => (refcount=0, is_ref=0)=2, 
//     'arrA' => (refcount=2, is_ref=1)=...
// )