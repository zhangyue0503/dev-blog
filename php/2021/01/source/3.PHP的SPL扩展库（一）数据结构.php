<?php
// 双向链表
$dll = new SplDoublyLinkedList();

var_dump($dll->isEmpty()); // bool(true)

$dll->push(200);
$dll->push(300);
$dll->unshift("五号");
$dll->add(2, "六号");

var_dump($dll->isEmpty()); // bool(false)

var_dump($dll);
// object(SplDoublyLinkedList)#1 (2) {
//     ["flags":"SplDoublyLinkedList":private]=>
//     int(0)
//     ["dllist":"SplDoublyLinkedList":private]=>
//     array(4) {
//       [0]=>
//       string(6) "五号"
//       [1]=>
//       int(200)
//       [2]=>
//       string(6) "六号"
//       [3]=>
//       int(300)
//     }
//   }

var_dump($dll->top()); // int(300)
var_dump($dll->bottom()); // string(6) "五号"

var_dump($dll->pop()); // int(300)
var_dump($dll->shift()); // string(6) "五号"

var_dump($dll->serialize()); // string(25) "i:0;:i:200;:s:6:"六号";"
var_dump($dll->count()); // int(2)

$dll->offsetSet(1, '修改成新六号');
var_dump($dll->offsetGet(1)); // string(18) "修改成新六号"
var_dump($dll->offsetExists(1)); // bool(true)
$dll->offsetUnset(1);
var_dump($dll->offsetExists(1)); // bool(false)

for($i=1;$i<5;$i++){
    $dll->push($i);
}

var_dump($dll->getIteratorMode()); // int(0)
$dll->rewind();
while($dll->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $dll->key(), PHP_EOL;
    echo '    current:', $dll->current(), PHP_EOL;
    $dll->next();
}
// ============
// key:0
//     current:200
// ============
// key:1
//     current:1
// ============
// key:2
//     current:2
// ============
// key:3
//     current:3
// ============
// key:4
//     current:4

$dll->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
$dll->rewind();
while($dll->valid()){
    echo 'IT_MODE_LIFO============', PHP_EOL;
    echo 'key:', $dll->key(), PHP_EOL;
    echo '    current:', $dll->current(), PHP_EOL;
    $dll->next();
}
// IT_MODE_LIFO============
// key:4
//     current:4
// IT_MODE_LIFO============
// key:3
//     current:3
// IT_MODE_LIFO============
// key:2
//     current:2
// IT_MODE_LIFO============
// key:1
//     current:1
// IT_MODE_LIFO============
// key:0
//     current:200


$dll->setIteratorMode(SplDoublyLinkedList::IT_MODE_KEEP);
$dll->rewind();
while($dll->valid()){
    echo 'IT_MODE_KEEP============', PHP_EOL;
    echo 'key:', $dll->key(), PHP_EOL;
    echo '    current:', $dll->current(), PHP_EOL;
    $dll->next();
}

$dll->setIteratorMode(SplDoublyLinkedList::IT_MODE_DELETE);
$dll->rewind();
while($dll->valid()){
    echo 'IT_MODE_DELETE============', PHP_EOL;
    echo 'key:', $dll->key(), PHP_EOL;
    echo '    current:', $dll->current(), PHP_EOL;
    $dll->next();
}
var_dump($dll);
// object(SplDoublyLinkedList)#1 (2) {
//     ["flags":"SplDoublyLinkedList":private]=>
//     int(1)
//     ["dllist":"SplDoublyLinkedList":private]=>
//     array(0) {
//     }
//   }


// 栈
$stack = new SplStack();
for($i=1;$i<5;$i++){
    $stack->push($i);
}
var_dump($stack->getIteratorMode()); // int(6)
var_dump($stack);
// object(SplStack)#2 (2) {
//     ["flags":"SplDoublyLinkedList":private]=>
//     int(6)
//     ["dllist":"SplDoublyLinkedList":private]=>
//     array(4) {
//       [0]=>
//       int(1)
//       [1]=>
//       int(2)
//       [2]=>
//       int(3)
//       [3]=>
//       int(4)
//     }
//   }

$stack->rewind();
while($stack->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $stack->key(), PHP_EOL;
    echo '    current:', $stack->current(), PHP_EOL;
    $stack->next();
}
// ============
// key:3
//     current:4
// ============
// key:2
//     current:3
// ============
// key:1
//     current:2
// ============
// key:0
//     current:1


// 队列
$queue = new SplQueue();
for($i=1;$i<5;$i++){
    $queue->enqueue($i);
}
var_dump($queue->getIteratorMode()); // int(4)
var_dump($queue);
// object(SplQueue)#3 (2) {
//     ["flags":"SplDoublyLinkedList":private]=>
//     int(4)
//     ["dllist":"SplDoublyLinkedList":private]=>
//     array(4) {
//       [0]=>
//       int(1)
//       [1]=>
//       int(2)
//       [2]=>
//       int(3)
//       [3]=>
//       int(4)
//     }
//   }

$queue->rewind();
while($queue->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $queue->key(), PHP_EOL;
    echo '    current:', $queue->current(), PHP_EOL;
    echo '    info:', $queue->dequeue(), PHP_EOL;
    $queue->next();
}
// ============
// key:0
//     current:1
//     info:1
// ============
// key:1
//     current:2
//     info:2
// ============
// key:2
//     current:3
//     info:3
// ============
// key:3
//     current:4
//     info:4

// 堆
$maxHeap = new SplMaxHeap();
for($i=1;$i<5;$i++){
    $maxHeap->insert($i);
}

var_dump($maxHeap);
// object(SplMaxHeap)#4 (3) {
//     ["flags":"SplHeap":private]=>
//     int(0)
//     ["isCorrupted":"SplHeap":private]=>
//     bool(false)
//     ["heap":"SplHeap":private]=>
//     array(4) {
//       [0]=>
//       int(4)
//       [1]=>
//       int(3)
//       [2]=>
//       int(2)
//       [3]=>
//       int(1)
//     }
//   }

var_dump($maxHeap->count()); // int(4)
var_dump($maxHeap->top()); // int(4)

var_dump($maxHeap->extract()); // int(4)

var_dump($maxHeap->count()); // int(3)
var_dump($maxHeap->top()); // int(3)

var_dump($maxHeap);
// object(SplMaxHeap)#4 (3) {
//     ["flags":"SplHeap":private]=>
//     int(0)
//     ["isCorrupted":"SplHeap":private]=>
//     bool(false)
//     ["heap":"SplHeap":private]=>
//     array(3) {
//       [0]=>
//       int(3)
//       [1]=>
//       int(1)
//       [2]=>
//       int(2)
//     }
//   }

$maxHeap->rewind();
while($maxHeap->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $maxHeap->key(), PHP_EOL;
    echo '    current:', $maxHeap->current(), PHP_EOL;
    $maxHeap->next();
}
// ============
// key:2
//     current:3
// ============
// key:1
//     current:2
// ============
// key:0
//     current:1


var_dump($maxHeap->isCorrupted()); // bool(false)
$maxHeap->recoverFromCorruption(); 

// 小顶堆
$minHeap = new SplMinHeap();
for($i=1;$i<5;$i++){
    $minHeap->insert($i);
}
var_dump($minHeap);
// object(SplMinHeap)#5 (3) {
//     ["flags":"SplHeap":private]=>
//     int(0)
//     ["isCorrupted":"SplHeap":private]=>
//     bool(false)
//     ["heap":"SplHeap":private]=>
//     array(4) {
//       [0]=>
//       int(1)
//       [1]=>
//       int(2)
//       [2]=>
//       int(3)
//       [3]=>
//       int(4)
//     }
//   }

var_dump($minHeap->top()); // int(1)

// 大顶堆优先队列
$pQueue = new SplPriorityQueue();
for($i=1;$i<5;$i++){
    $pQueue->insert($i, random_int(1,10));
}
var_dump($pQueue);
// object(SplPriorityQueue)#6 (3) {
//     ["flags":"SplPriorityQueue":private]=>
//     int(1)
//     ["isCorrupted":"SplPriorityQueue":private]=>
//     bool(false)
//     ["heap":"SplPriorityQueue":private]=>
//     array(4) {
//       [0]=>
//       array(2) {
//         ["data"]=>
//         int(3)
//         ["priority"]=>
//         int(10)
//       }
//       [1]=>
//       array(2) {
//         ["data"]=>
//         int(4)
//         ["priority"]=>
//         int(7)
//       }
//       [2]=>
//       array(2) {
//         ["data"]=>
//         int(1)
//         ["priority"]=>
//         int(3)
//       }
//       [3]=>
//       array(2) {
//         ["data"]=>
//         int(2)
//         ["priority"]=>
//         int(2)
//       }
//     }
//   }

while($pQueue->valid()){
    var_dump($pQueue->extract());
}
// int(3)
// int(4)
// int(1)
// int(2)


// 数组
$norArr = [];
$norArr[1] = 'b';
$norArr[4] = 'f';

var_dump($norArr);
// array(2) {
//     [1]=>
//     string(1) "b"
//     [4]=>
//     string(1) "f"
//   }

$fArr = new SplFixedArray(5);
$fArr[1] = 'b';
$fArr[4] = 'f';

var_dump($fArr);
// object(SplFixedArray)#7 (5) {
//     [0]=>
//     NULL
//     [1]=>
//     string(1) "b"
//     [2]=>
//     NULL
//     [3]=>
//     NULL
//     [4]=>
//     string(1) "f"
//   }

// $fArr[6] = 'h'; // Fatal error: Uncaught RuntimeException: Index invalid or out of range 
$fArr->setSize(7);
$fArr[6] = 'h';

var_dump($fArr->getSize()); // int(7)

$fArr2 = SplFixedArray::fromArray(range(1,3));
var_dump($fArr2);
// object(SplFixedArray)#8 (3) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//   }

// $fArr3 = SplFixedArray::fromArray(['new'=>1, 'old'=>2]);
// var_dump($fArr3);
// PHP Fatal error:  Uncaught InvalidArgumentException: array must contain only positive integer keys

var_dump($fArr->toArray());
// array(7) {
//     [0]=>
//     NULL
//     [1]=>
//     string(1) "b"
//     [2]=>
//     NULL
//     [3]=>
//     NULL
//     [4]=>
//     string(1) "f"
//     [5]=>
//     NULL
//     [6]=>
//     string(1) "h"
//   }

var_dump($fArr->count()); // int(7)

var_dump($fArr->offsetGet(2)); // NULL
$fArr->offsetSet(2, 'new'); 
var_dump($fArr->offsetGet(2)); // string(3) "new"
var_dump($fArr->offsetExists(2)); // bool(true)
$fArr->offsetUnset(2);
var_dump($fArr->offsetExists(2)); // bool(false)


$fArr->rewind();
while($fArr->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $fArr->key(), PHP_EOL;
    echo '    current:', $fArr->current(), PHP_EOL;
    $fArr->next();
}
// ============
// key:0
//     current:
// ============
// key:1
//     current:b
// ============
// key:2
//     current:
// ============
// key:3
//     current:
// ============
// key:4
//     current:f
// ============
// key:5
//     current:
// ============
// key:6
//     current:h

foreach($fArr as $f){
    var_dump($f);
}
for($i=0;$i<count($fArr);$i++){
    var_dump($fArr[$i]);
}


// 对象集

$os = new SplObjectStorage();

$o1 = new stdClass;
$o2 = new stdClass;
$o3 = new stdClass;
$o4 = new stdClass;
$o5 = new stdClass;

$os->attach($o1);
$os->attach($o2);
$os->attach($o3);
$os->attach($o4, 'd4');
$os->attach($o5, 'd5');

var_dump($os);
// object(SplObjectStorage)#9 (1) {
//     ["storage":"SplObjectStorage":private]=>
//     array(5) {
//       ["00000000736a0aba000000002f97228d"]=>
//       array(2) {
//         ["obj"]=>
//         object(stdClass)#10 (0) {
//         }
//         ["inf"]=>
//         NULL
//       }
//       ["00000000736a0abb000000002f97228d"]=>
//       array(2) {
//         ["obj"]=>
//         object(stdClass)#11 (0) {
//         }
//         ["inf"]=>
//         NULL
//       }
//       ["00000000736a0abc000000002f97228d"]=>
//       array(2) {
//         ["obj"]=>
//         object(stdClass)#12 (0) {
//         }
//         ["inf"]=>
//         NULL
//       }
//       ["00000000736a0abd000000002f97228d"]=>
//       array(2) {
//         ["obj"]=>
//         object(stdClass)#13 (0) {
//         }
//         ["inf"]=>
//         string(2) "d4"
//       }
//       ["00000000736a0abe000000002f97228d"]=>
//       array(2) {
//         ["obj"]=>
//         object(stdClass)#14 (0) {
//         }
//         ["inf"]=>
//         string(2) "d5"
//       }
//     }
//   }

var_dump($os->count()); // int(5)
$os->detach($o2);
var_dump($os->count()); // int(4)

var_dump($os->contains($o2)); // bool(false)
var_dump($os->contains($o3)); // bool(true)

var_dump($os->getHash($o4)); // string(32) "000000003e67a2330000000040e598c9"

var_dump($os->offsetGet($o4)); // string(2) "d4"
$os->offsetSet($o4, 'new d4'); 
var_dump($os->offsetGet($o4)); // string(6) "new d4"
var_dump($os->offsetExists($o4)); // bool(true)
$os->offsetUnset($o4);
var_dump($os->offsetExists($o4)); // bool(false)

$os->rewind();
$os[$o1] = 'new d1';
while($os->valid()){
    echo '============', PHP_EOL;
    echo 'key:', $os->key(), PHP_EOL;
    if($os->getInfo() === NULL){
        $os->setInfo('new iter info');
    }
    echo '    info:', $os->getInfo(), PHP_EOL;
    echo '    current:', PHP_EOL;
    var_dump($os->current());
    
    $os->next();
}
// ============
// key:0
//     info:new d1
//     current:
// object(stdClass)#10 (0) {
// }
// ============
// key:1
//     info:new iter info
//     current:
// object(stdClass)#12 (0) {
// }
// ============
// key:2
//     info:d5
//     current:
// object(stdClass)#14 (0) {
// }

