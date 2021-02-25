<?php
// 栈
$stack = new \Ds\Stack();
var_dump($stack);
// object(Ds\Stack)#1 (0) {
// }

$stack = new \Ds\Stack([1, 2, 3]);
var_dump($stack);
// object(Ds\Stack)#2 (3) {
//     [0]=>
//     int(3)
//     [1]=>
//     int(2)
//     [2]=>
//     int(1)
//   }

$stack->push(4);
$stack->push(5);
var_dump($stack);
// object(Ds\Stack)#2 (5) {
//     [0]=>
//     int(5)
//     [1]=>
//     int(4)
//     [2]=>
//     int(3)
//     [3]=>
//     int(2)
//     [4]=>
//     int(1)
//   }

var_dump($stack->pop()); // int(5)
var_dump($stack->pop()); // int(4)
var_dump($stack);
// object(Ds\Stack)#2 (3) {
//     [0]=>
//     int(3)
//     [1]=>
//     int(2)
//     [2]=>
//     int(1)
//   }

var_dump($stack->peek()); // int(3)
// object(Ds\Stack)#2 (3) {
//     [0]=>
//     int(3)
//     [1]=>
//     int(2)
//     [2]=>
//     int(1)
//   }

var_dump($stack->count()); // int(3)
var_dump($stack->isEmpty()); // bool(false)
var_dump($stack->toArray());
// array(3) {
//     [0]=>
//     int(3)
//     [1]=>
//     int(2)
//     [2]=>
//     int(1)
//   }

$stack->clear();
var_dump($stack);
// object(Ds\Stack)#2 (0) {
// }

$a = $stack;
$a->push(4);
var_dump($stack);
// object(Ds\Stack)#2 (1) {
//     [0]=>
//     int(4)
//   }

$b = $stack->copy();
$b->push(5);

var_dump($stack);
// object(Ds\Stack)#2 (1) {
//     [0]=>
//     int(4)
//   }

var_dump($b);
// object(Ds\Stack)#1 (2) {
//     [0]=>
//     int(5)
//     [1]=>
//     int(4)
//   }

// 队列
$queue = new \Ds\Queue();
var_dump($queue);
// object(Ds\Queue)#3 (0) {
// }

$queue = new \Ds\Queue([1, 2, 3]);
var_dump($queue);
// object(Ds\Queue)#4 (3) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//   }

$queue->push(4);
$queue->push(5);
var_dump($queue);
// object(Ds\Queue)#4 (5) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//     [4]=>
//     int(5)
//   }

var_dump($queue->pop()); // int(1)
var_dump($queue->pop()); // int(2)
var_dump($queue);
// object(Ds\Queue)#4 (3) {
//     [0]=>
//     int(3)
//     [1]=>
//     int(4)
//     [2]=>
//     int(5)
//   }

// 优先队列
$pQueue = new \Ds\PriorityQueue();

$pQueue->push(1, 100);
$pQueue->push(2, 101);
$pQueue->push(3, 99);

var_dump($pQueue);
// object(Ds\PriorityQueue)#3 (3) {
//     [0]=>
//     int(2)
//     [1]=>
//     int(1)
//     [2]=>
//     int(3)
//   }

var_dump($pQueue->pop()); // int(2)
var_dump($pQueue->pop()); // int(1)
var_dump($pQueue->pop()); // int(3)

// Map

$map = new \Ds\Map(['a'=>1, 2, 5=>3]);
var_dump($map);
// object(Ds\Map)#5 (3) {
//     [0]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//     [1]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//   }


var_dump($map->get(0)); // int(2)
var_dump($map->get(5)); // int(3)

$map->put('b', '4');
$map->put('c', [1, 2, 3]);
$map->put('d', new class{public $t = 't';});

var_dump($map);
// object(Ds\Map)#5 (6) {
//     [0]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//     [1]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#9 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [3]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//     [4]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       string(1) "c"
//       ["value"]=>
//       array(3) {
//         [0]=>
//         int(1)
//         [1]=>
//         int(2)
//         [2]=>
//         int(3)
//       }
//     }
//     [5]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       string(1) "d"
//       ["value"]=>
//       object(class@anonymous)#8 (1) {
//         ["t"]=>
//         string(1) "t"
//       }
//     }
//   }

$map->remove('d');
$map->remove('c');

var_dump($map);
// object(Ds\Map)#5 (4) {
//     [0]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//     [1]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [3]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//   }

var_dump($map->first());
// object(Ds\Pair)#8 (2) {
//     ["key"]=>
//     string(1) "a"
//     ["value"]=>
//     int(1)
//   }

var_dump($map->last());
// object(Ds\Pair)#8 (2) {
//     ["key"]=>
//     int(5)
//     ["value"]=>
//     int(3)
//   }

var_dump($map->sum()); // int(10)

var_dump($map->hasKey('b')); // bool(true)
var_dump($map->haskey('bb')); // bool(false)

var_dump($map->hasValue('4')); // bool(true)
var_dump($map->hasValue(4)); // bool(false)

var_dump($map->keys());
// object(Ds\Set)#10 (4) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     int(0)
//     [2]=>
//     int(5)
//     [3]=>
//     string(1) "b"
//   }

var_dump($map->values());
// object(Ds\Vector)#10 (4) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     string(1) "4"
//   }

var_dump($map->pairs());
// object(Ds\Vector)#9 (4) {
//     [0]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//     [1]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [3]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//   }

$map->ksort();
var_dump($map);
// object(Ds\Map)#5 (4) {
//     [0]=>
//     object(Ds\Pair)#9 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//     [1]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//     [3]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//   }

$map->reverse();
var_dump($map);
// object(Ds\Map)#5 (4) {
//     [0]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [1]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//     [2]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [3]=>
//     object(Ds\Pair)#9 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//   }

$newMap = new \Ds\Map();
$newMap->put('a', 'a');
$newMap->put('b', 'b');
$newMap->put('e', 'e');

var_dump($map->diff($newMap));
// object(Ds\Map)#8 (2) {
//     [0]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [1]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//   }

var_dump($map->union($newMap));
// object(Ds\Map)#8 (5) {
//     [0]=>
//     object(Ds\Pair)#11 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [1]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "b"
//     }
//     [2]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [3]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       string(1) "a"
//     }
//     [4]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       string(1) "e"
//       ["value"]=>
//       string(1) "e"
//     }
//   }

var_dump($map->xor($newMap));
// object(Ds\Map)#8 (3) {
//     [0]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [1]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [2]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       string(1) "e"
//       ["value"]=>
//       string(1) "e"
//     }
//   }

var_dump($map->intersect($newMap));
// object(Ds\Map)#8 (2) {
//     [0]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "4"
//     }
//     [1]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       int(1)
//     }
//   }

$map->putAll($newMap);
var_dump($map);
// object(Ds\Map)#5 (5) {
//     [0]=>
//     object(Ds\Pair)#8 (2) {
//       ["key"]=>
//       int(5)
//       ["value"]=>
//       int(3)
//     }
//     [1]=>
//     object(Ds\Pair)#6 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "b"
//     }
//     [2]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//     [3]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       string(1) "a"
//       ["value"]=>
//       string(1) "a"
//     }
//     [4]=>
//     object(Ds\Pair)#12 (2) {
//       ["key"]=>
//       string(1) "e"
//       ["value"]=>
//       string(1) "e"
//     }
//   }

var_dump($map->slice(1, 2));
// object(Ds\Map)#12 (2) {
//     [0]=>
//     object(Ds\Pair)#7 (2) {
//       ["key"]=>
//       string(1) "b"
//       ["value"]=>
//       string(1) "b"
//     }
//     [1]=>
//     object(Ds\Pair)#10 (2) {
//       ["key"]=>
//       int(0)
//       ["value"]=>
//       int(2)
//     }
//   }

var_dump($map->skip(2));
// object(Ds\Pair)#12 (2) {
//     ["key"]=>
//     int(0)
//     ["value"]=>
//     int(2)
//   }