<?php

// IteratorIterator
$iterator = new IteratorIterator(new ArrayIterator([1, 2, 3]));
$iterator->rewind();
while ($iterator->valid()) {
    echo $iterator->key(), ": ", $iterator->current(), PHP_EOL;
    $iterator->next();
}
// 0: 1
// 1: 2
// 2: 3

class OutIterator extends IteratorIterator
{
    public function rewind()
    {
        echo __METHOD__, PHP_EOL;
        return parent::rewind();
    }

    public function valid()
    {
        echo __METHOD__, PHP_EOL;
        return parent::valid();
    }

    public function current()
    {
        echo __METHOD__, PHP_EOL;
        return parent::current() . '_suffix';
    }

    public function key()
    {
        echo __METHOD__, PHP_EOL;
        return parent::key();
    }

    public function next()
    {
        echo __METHOD__, PHP_EOL;
        return parent::next();
    }

    public function getInnerIterator()
    {
        echo __METHOD__, PHP_EOL;
        return parent::getInnerIterator();
    }
}
$iterator = new OutIterator(new ArrayIterator([1, 2, 3]));
foreach ($iterator as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
}
// OutIterator::rewind
// OutIterator::valid
// OutIterator::current
// OutIterator::key
// 0: 1_suffix
// OutIterator::next
// OutIterator::valid
// OutIterator::current
// OutIterator::key
// 1: 2_suffix
// OutIterator::next
// OutIterator::valid
// OutIterator::current
// OutIterator::key
// 2: 3_suffix
// OutIterator::next
// OutIterator::valid

var_dump($iterator->getInnerIterator());
// object(ArrayIterator)#5 (1) {
//     ["storage":"ArrayIterator":private]=>
//     array(3) {
//       [0]=>
//       int(1)
//       [1]=>
//       int(2)
//       [2]=>
//       int(3)
//     }
//   }

// AppendIterator
$appendIterator = new AppendIterator();
$appendIterator->append(new ArrayIterator([1, 2, 3]));
$appendIterator->append(new ArrayIterator(['a' => 'a1', 'b' => 'b1', 'c' => 'c1']));
var_dump($appendIterator->getIteratorIndex()); // int(0)
foreach ($appendIterator as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
    echo 'iterator index: ', $appendIterator->getIteratorIndex(), PHP_EOL;
}
// 0: 1
// iterator index: 0
// 1: 2
// iterator index: 0
// 2: 3
// iterator index: 0
// a: a1
// iterator index: 1
// b: b1
// iterator index: 1
// c: c1
// iterator index: 1

var_dump($appendIterator->getIteratorIndex()); // NULL

var_dump($appendIterator->getArrayIterator());
// object(ArrayIterator)#2 (1) {
//     ["storage":"ArrayIterator":private]=>
//     array(2) {
//       [0]=>
//       object(ArrayIterator)#7 (1) {
//         ["storage":"ArrayIterator":private]=>
//         array(3) {
//           [0]=>
//           int(1)
//           [1]=>
//           int(2)
//           [2]=>
//           int(3)
//         }
//       }
//       [1]=>
//       object(ArrayIterator)#9 (1) {
//         ["storage":"ArrayIterator":private]=>
//         array(3) {
//           ["a"]=>
//           string(2) "a1"
//           ["b"]=>
//           string(2) "b1"
//           ["c"]=>
//           string(2) "c1"
//         }
//       }
//     }
//   }

// CachingIterator
$cachingIterator = new CachingIterator(new ArrayIterator([1, 2, 3]), CachingIterator::FULL_CACHE);
var_dump($cachingIterator->getCache());
// array(0) {
// }
foreach ($cachingIterator as $c) {

}
var_dump($cachingIterator->getCache());
// array(3) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//   }

// FilterIterator
$callbackFilterIterator = new CallbackFilterIterator(new ArrayIterator([1, 2, 3, 4]), function ($current, $key, $iterator) {
    echo $key, ': ', $current, PHP_EOL;
    if ($key == 0) {
        var_dump($iterator);
    }
    if ($current % 2 == 0) {
        return true;
    }
    return false;
});
foreach ($callbackFilterIterator as $c) {
    echo 'foreach: ', $c, PHP_EOL;
}
// 0: 1
// object(ArrayIterator)#13 (1) {
//   ["storage":"ArrayIterator":private]=>
//   array(4) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//   }
// }
// 1: 2
// foreach: 2
// 2: 3
// 3: 4
// foreach: 4

$regexIterator = new RegexIterator(new ArrayIterator(['test1', 'test2', 'opp1', 'test3']), '/^(test)(\d+)/', RegexIterator::MATCH);

var_dump(iterator_to_array($regexIterator));
// array(3) {
//     [0]=>
//     string(5) "test1"
//     [1]=>
//     string(5) "test2"
//     [3]=>
//     string(5) "test3"
//   }

$regexIterator = new RegexIterator(new ArrayIterator(['test1', 'test2', 'opp1', 'test3']), '/^(test)(\d+)/', RegexIterator::REPLACE);
$regexIterator->replacement = 'new $2$1'; 
var_dump(iterator_to_array($regexIterator));
// array(3) {
//     [0]=>
//     string(9) "new 1test"
//     [1]=>
//     string(9) "new 2test"
//     [3]=>
//     string(9) "new 3test"
//   }

class MyFilterIterator extends FilterIterator{
    public function accept(){
        echo  __METHOD__, PHP_EOL;
        if($this->current()%2==0){
            return true;
        }
        return false;
    }
}
$myFilterIterator = new MyFilterIterator(new ArrayIterator([1,2,3,4]));
var_dump(iterator_to_array($myFilterIterator));
// MyFilterIterator::accept
// MyFilterIterator::accept
// MyFilterIterator::accept
// MyFilterIterator::accept
// array(2) {
//   [1]=>
//   int(2)
//   [3]=>
//   int(4)
// }

// InfiniteIterator
$infinateIterator = new InfiniteIterator(new ArrayIterator([1,2,3,4]));
$i = 20;
foreach($infinateIterator as $k=>$v){
    echo $k, ': ', $v, PHP_EOL;
    $i--;
    if($i <= 0){
        break;
    }
}
// 0: 1
// 1: 2
// 2: 3
// 3: 4
// 0: 1
// 1: 2
// 2: 3
// ………………
// ………………

// LimitIterator
$limitIterator = new LimitIterator(new ArrayIterator([1,2,3,4]),0,2);
var_dump(iterator_to_array($limitIterator));
// array(2) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//   }

$limitIterator = new LimitIterator(new ArrayIterator([1,2,3,4]),1,3);
var_dump(iterator_to_array($limitIterator));
// array(3) {
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//   }

// NoRewindIterator
$noRewindIterator = new NoRewindIterator(new ArrayIterator([1,2,3,4]));
var_dump(iterator_to_array($noRewindIterator));
// array(4) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//   }
$noRewindIterator->rewind();
var_dump(iterator_to_array($noRewindIterator));
// array(0) {
// }


// 多个并行迭代器
$multipleIterator = new MultipleIterator();
$multipleIterator->attachIterator(new ArrayIterator([1,2,3,4]));
$multipleIterator->attachIterator(new ArrayIterator(['a' => 'a1', 'b' => 'b1', 'c' => 'c1']));
$arr1 = new ArrayIterator(['a', 'b', 'c']);
$arr2 = new ArrayIterator(['d', 'e', 'f', 'g', 'h']);
$multipleIterator->attachIterator($arr1);
$multipleIterator->attachIterator($arr2);

var_dump($multipleIterator->containsIterator($arr1)); // bool(true)
$multipleIterator->detachIterator($arr1);
var_dump($multipleIterator->containsIterator($arr1)); // bool(false)

// iterator_to_array($multipleIterator);
foreach($multipleIterator as $k=>$v){
    var_dump($k);
    var_dump($v);
}
// array(3) {
//     [0]=>
//     int(0)
//     [1]=>
//     string(1) "a"
//     [2]=>
//     int(0)
//   }
//   array(3) {
//     [0]=>
//     int(1)
//     [1]=>
//     string(2) "a1"
//     [2]=>
//     string(1) "a"
//   }
//   array(3) {
//     [0]=>
//     int(1)
//     [1]=>
//     string(1) "b"
//     [2]=>
//     int(1)
//   }
//   array(3) {
//     [0]=>
//     int(2)
//     [1]=>
//     string(2) "b1"
//     [2]=>
//     string(1) "b"
//   }
//   array(3) {
//     [0]=>
//     int(2)
//     [1]=>
//     string(1) "c"
//     [2]=>
//     int(2)
//   }
//   array(3) {
//     [0]=>
//     int(3)
//     [1]=>
//     string(2) "c1"
//     [2]=>
//     string(1) "e"
//   }


// 自定义一个类，可以直接使用 count 、foreach 之类的迭代类
class NewIterator implements Countable, RecursiveIterator, SeekableIterator {
    private $array = [];

    public function __construct($arr = []){
        $this->array = $arr;
    }

    // Countable
    public function count(){
        return count($this->array);
    }

    // RecursiveIterator
    public function hasChildren(){
        if(is_array($this->current())){
            return true;
        }
        return false;
    }

    // RecursiveIterator
    public function getChildren(){
        
        if(is_array($this->current())){
            return new ArrayIterator($this->current());
        }
        return null;
    }

    // Seekable
    public function seek($position) {
        if (!isset($this->array[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }

        $this->position = $position;
    }
      
      public function rewind() {
          $this->position = 0;
      }
  
      public function current() {
          return $this->array[$this->position];
      }
  
      public function key() {
          return $this->position;
      }
  
      public function next() {
          ++$this->position;
      }
  
      public function valid() {
          return isset($this->array[$this->position]);
      }
}

$newIterator = new NewIterator([1,2,3,4, [5,6,7]]);
var_dump(iterator_to_array($newIterator));
// array(5) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//     [4]=>
//     array(3) {
//       [0]=>
//       int(5)
//       [1]=>
//       int(6)
//       [2]=>
//       int(7)
//     }
//   }

var_dump(count($newIterator));
// int(5)

$newIterator->rewind();
while($newIterator->valid()){
    if($newIterator->hasChildren()){
        var_dump($newIterator->getChildren());
    }
    $newIterator->next();
}
// object(ArrayIterator)#37 (1) {
//     ["storage":"ArrayIterator":private]=>
//     array(3) {
//       [0]=>
//       int(5)
//       [1]=>
//       int(6)
//       [2]=>
//       int(7)
//     }
//   }

$newIterator->seek(2);
while($newIterator->valid()){
    var_dump($newIterator->current());
    $newIterator->next();
}
// int(3)
// int(4)
// array(3) {
//   [0]=>
//   int(5)
//   [1]=>
//   int(6)
//   [2]=>
//   int(7)
// }