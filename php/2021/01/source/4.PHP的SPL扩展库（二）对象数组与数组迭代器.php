<?php

// 数组对象
$ao = new ArrayObject(['a' => 'one', 'b' => 'two', 'c' => 'three']);
var_dump($ao);
// object(ArrayObject)#1 (1) {
//     ["storage":"ArrayObject":private]=>
//     array(3) {
//       ["a"]=>
//       string(3) "one"
//       ["b"]=>
//       string(3) "two"
//       ["c"]=>
//       string(5) "three"
//     }
//   }
foreach ($ao as $k => $element) {
    echo $k, ': ', $element, PHP_EOL;
}
// a: one
// b: two
// c: three


// 空对象，赋值
$ao = new ArrayObject();
$ao->a = 'one';
$ao['b'] = 'two';
$ao->append('three');
var_dump($ao);
// object(ArrayObject)#3 (2) {
//     ["a"]=>
//     string(3) "one"
//     ["storage":"ArrayObject":private]=>
//     array(2) {
//       ["b"]=>
//       string(3) "two"
//       [0]=>
//       string(5) "three"
//     }
//   }

foreach ($ao as $k => $element) {
    echo $k, ': ', $element, PHP_EOL; // two three
}
// b: two
// 0: three


// 设置属性标签
$ao->setFlags(ArrayObject::ARRAY_AS_PROPS);
$ao->d = 'four';
var_dump($ao);
// object(ArrayObject)#3 (2) {
//     ["a"]=>
//     string(3) "one"
//     ["storage":"ArrayObject":private]=>
//     array(3) {
//       ["b"]=>
//       string(3) "two"
//       [0]=>
//       string(5) "three"
//       ["d"]=>
//       string(4) "four"
//     }
//   }

foreach ($ao as $k => $element) {
    echo $k, ': ', $element, PHP_EOL; // two three
}
// b: two
// 0: three
// d: four


// 偏移下标操作
var_dump($ao->offsetExists('b')); // bool(true)
var_dump($ao->offsetGet('b')); // string(3) "two"

$ao->offsetSet('b', 'new two');
var_dump($ao->offsetGet('b')); // string(7) "new two"

$ao->offsetSet('e', 'five');
var_dump($ao->offsetGet('e')); // string(4) "five"

$ao->offsetUnset('e');
var_dump($ao->offsetGet('e')); // NULL
var_dump($ao->offsetExists('e')); // bool(false)

// 排序
$ao->asort();
var_dump($ao);
// object(ArrayObject)#3 (2) {
//     ["a"]=>
//     string(3) "one"
//     ["storage":"ArrayObject":private]=>
//     array(3) {
//       ["d"]=>
//       string(4) "four"
//       ["b"]=>
//       string(7) "new two"
//       [0]=>
//       string(5) "three"
//     }
//   }

$ao->ksort();
var_dump($ao);
// object(ArrayObject)#3 (2) {
//     ["a"]=>
//     string(3) "one"
//     ["storage":"ArrayObject":private]=>
//     array(3) {
//       [0]=>
//       string(5) "three"
//       ["b"]=>
//       string(7) "new two"
//       ["d"]=>
//       string(4) "four"
//     }
//   }


// 切换数组内容
$ao->exchangeArray(['a' => 'one', 'b' => 'two', 'c' => 'three', 'd' => 4, 0 => 'a']);
var_dump($ao);
// object(ArrayObject)#3 (2) {
//     ["a"]=>
//     string(3) "one"
//     ["storage":"ArrayObject":private]=>
//     array(5) {
//       ["a"]=>
//       string(3) "one"
//       ["b"]=>
//       string(3) "two"
//       ["c"]=>
//       string(5) "three"
//       ["d"]=>
//       int(4)
//       [0]=>
//       string(1) "a"
//     }
//   }

// 属性
var_dump($ao->count()); // int(5)
var_dump($ao->serialize()); // string(119) "x:i:2;a:5:{s:1:"a";s:3:"one";s:1:"b";s:3:"two";s:1:"c";s:5:"three";s:1:"d";i:4;i:0;s:1:"a";};m:a:1:{s:1:"a";s:3:"one";}"

var_dump($ao->getArrayCopy());
// array(5) {
//     ["a"]=>
//     string(3) "one"
//     ["b"]=>
//     string(3) "two"
//     ["c"]=>
//     string(5) "three"
//     ["d"]=>
//     int(4)
//     [0]=>
//     string(1) "a"
//   }

var_dump($ao->getIterator());
// object(ArrayIterator)#1 (1) {
//     ["storage":"ArrayIterator":private]=>
//     object(ArrayObject)#3 (2) {
//       ["a"]=>
//       string(3) "one"
//       ["storage":"ArrayObject":private]=>
//       array(5) {
//         ["a"]=>
//         string(3) "one"
//         ["b"]=>
//         string(3) "two"
//         ["c"]=>
//         string(5) "three"
//         ["d"]=>
//         int(4)
//         [0]=>
//         string(1) "a"
//       }
//     }
//   }
var_dump($ao->getIteratorClass()); // string(13) "ArrayIterator"


// ArrayIterator
$ai = new ArrayIterator(['a' => 'one', 'b' => 'two', 'c' => 'three', 'd' => 4, 0 => 'a']);
var_dump($ai);


$ai->rewind();

while($ai->valid()){
    echo $ai->key(), ': ', $ai->current(), PHP_EOL;
    $ai->next();
}
// a: one
// b: two
// c: three
// d: 4
// 0: a

// 游标定位
$ai->seek(1);
while($ai->valid()){
    echo $ai->key(), ': ', $ai->current(), PHP_EOL;
    $ai->next();
}
// b: two
// c: three
// d: 4
// 0: a

// foreach遍历
foreach($ai as $k=>$v){
    echo $k, ': ', $v, PHP_EOL;
}
// a: one
// b: two
// c: three
// d: 4
// 0: a


// RecursiveArrayIterator
$ai = new ArrayIterator(['a' => 'one', 'b' => 'two', 'c' => 'three', 'd' => 4, 0 => 'a', 'more'=>['e'=>'five', 'f'=>'six', 1=>7]]);
var_dump($ai);
// object(ArrayIterator)#1 (1) {
//     ["storage":"ArrayIterator":private]=>
//     array(6) {
//       ["a"]=>
//       string(3) "one"
//       ["b"]=>
//       string(3) "two"
//       ["c"]=>
//       string(5) "three"
//       ["d"]=>
//       int(4)
//       [0]=>
//       string(1) "a"
//       ["more"]=>
//       array(3) {
//         ["e"]=>
//         string(4) "five"
//         ["f"]=>
//         string(3) "six"
//         [1]=>
//         int(7)
//       }
//     }
//   }

$rai = new RecursiveArrayIterator($ai->getArrayCopy());
var_dump($rai);
// object(RecursiveArrayIterator)#1 (1) {
//     ["storage":"ArrayIterator":private]=>
//     array(6) {
//       ["a"]=>
//       string(3) "one"
//       ["b"]=>
//       string(3) "two"
//       ["c"]=>
//       string(5) "three"
//       ["d"]=>
//       int(4)
//       [0]=>
//       string(1) "a"
//       ["more"]=>
//       array(3) {
//         ["e"]=>
//         string(4) "five"
//         ["f"]=>
//         string(3) "six"
//         [1]=>
//         int(7)
//       }
//     }
//   }

while($rai->valid()){
    echo $rai->key(), ': ', $rai->current() ;
    if($rai->hasChildren()){
        echo ' has child ', PHP_EOL;
        foreach($rai->getChildren() as $k=>$v){
            echo '    ',$k, ': ', $v, PHP_EOL;
        }
    }else{
        echo ' No Children.', PHP_EOL;
    }
    $rai->next();
}
// a: one No Children.
// b: two No Children.
// c: three No Children.
// d: 4 No Children.
// 0: a No Children.
// more: Array has child 
//     e: five
//     f: six
//     1: 7

// class User {
//     public IList<User> userList = new ArrayList()<User>;

//     public function getUserList(){
//         // 查询数据库
//         // .....
//         for(){
//             $u = new User();
//             //xxxxx
//             // 添加到集合中
//             userList.add($u);
//         }
//     }
// }

class User extends ArrayObject{
    public function getUserList(){
        $this->append(new User());
        $this->append(new User());
        $this->append(new User());
    }
}

$u = new User();
$u->getUserList();
var_dump($u);
// object(User)#5 (1) {
//     ["storage":"ArrayObject":private]=>
//     array(3) {
//       [0]=>
//       object(User)#4 (1) {
//         ["storage":"ArrayObject":private]=>
//         array(0) {
//         }
//       }
//       [1]=>
//       object(User)#6 (1) {
//         ["storage":"ArrayObject":private]=>
//         array(0) {
//         }
//       }
//       [2]=>
//       object(User)#7 (1) {
//         ["storage":"ArrayObject":private]=>
//         array(0) {
//         }
//       }
//     }
//   }

foreach($u as $v){
    var_dump($v);
}
// object(User)#4 (1) {
//     ["storage":"ArrayObject":private]=>
//     array(0) {
//     }
//   }
//   object(User)#6 (1) {
//     ["storage":"ArrayObject":private]=>
//     array(0) {
//     }
//   }
//   object(User)#7 (1) {
//     ["storage":"ArrayObject":private]=>
//     array(0) {
//     }
//   }


