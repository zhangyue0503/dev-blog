# PHP怎么遍历对象？

对于php来说，foreach是非常方便好用的一个语法，几乎对于每一个PHPer它都是日常接触最多的请求之一。那么对象是否能通过foreach来遍历呢？

答案是肯定的，但是有个条件，那就是对象的遍历只能获得它的公共属性。

```php
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
```

不管是方法还是受保护或者私有的变量，都无法遍历出来。只有公共的属性才能被遍历出来。其实，我们之前在讲设计模式时讲过的**迭代器模式**就是专门用来进行对象遍历的，而且PHP已经为我们准备好了相关的接口，我们只需要去实现这个接口就可以完成迭代器模式的创建了。具体的内容可以参考之前的设计模式系列文章：[PHP设计模式之迭代器模式](https://mp.weixin.qq.com/s/uycac0OXYYjAG1BlzTUjsw)

```php
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
```

假如今天的文章只是讲之前讲过的迭代器模式，那就太没意思了，所以，咱们还要来学习一个更有意思的应用。那就是让对象可以像数组一样进行操作。这个其实也是使用PHP早已为我们准备好的一个接口：ArrayAccess。

```php
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
```

这个接口需要我们实现四个方法：

- offsetSet($offset, $value)，根据偏移量设置值
- offsetExists($offset)，根据偏移量确定是否存在内容
- offsetUnset($offset)，根据偏移量删除内容
- offsetGet($offset)，根据依稀量获取内容

这里的偏移量就是我们常说的下标。通过实现这四个方法，我们就可以像操作数组一样的操作对象。当然，日常开发中我们可能并不会很经常的使用包括迭代器在内的这些对象遍历的能力。通常我们会直接去将对象转换成数组 (array) obj 来进行下一步的操作。不过，在java中，特别是JavaBean中会经常在类的内部有一个 List<T> 为自己的对象来表示自身的集合状态。通过对比，我们发现PHP也完全可以实现这样的能力，而且使用迭代器和 ArrayAccess 接口还能够更方便的实现类似的能力。这是非常有用的一种知识扩展，或许下一个项目中你就能运用上这些能力哦！

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E6%80%8E%E4%B9%88%E9%81%8D%E5%8E%86%E5%AF%B9%E8%B1%A1%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E6%80%8E%E4%B9%88%E9%81%8D%E5%8E%86%E5%AF%B9%E8%B1%A1%EF%BC%9F.php)

参考文档：
(https://www.php.net/manual/zh/language.oop5.iterations.php)[https://www.php.net/manual/zh/language.oop5.iterations.php]