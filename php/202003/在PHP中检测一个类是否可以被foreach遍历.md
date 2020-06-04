# 在PHP中检测一个类是否可以被foreach遍历

在PHP中，我们可以非常简单的判断一个变量是什么类型，也可以非常方便的确定一个数组的长度从而决定这个数组是否可以遍历。那么类呢？我们要如何知道这个类是否可以通过 foreach 来进行遍历呢？其实，PHP已经为我们提供了一个现成的接口。

```php
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
```

从上面的例子中可以看出，每一个 \\$obj1 无法通过 Traversable 判断，所以它是不能被遍历的。而第二个 $obj2 则是实现了迭代器接口，这个对象是可以通过 Traversable 判断的。在PHP手册中，Traversable 接口正是用于检测一个类是否可以被 foreach 遍历的接口。

这个接口有几个特点：

1. 实现此接口的内建类可以使用 foreach 进行遍历而无需实现 IteratorAggregate 或 Iterator 接口。
2. 这是一个无法在 PHP 脚本中实现的内部引擎接口。IteratorAggregate 或 Iterator 接口可以用来代替它。

也就是说这个接口不需要我们去手工实现，只需要我们的类实现迭代器相关的接口就可以通过这个接口的验证的判断。如果单独去实现这个接口的话，将会报错并提示我们应该去实现 IteratorAggregate 或 Iterator 接口。

```php
// Fatal error: Class ImplTraversable must implement interface Traversable as part of either Iterator or IteratorAggregate in Unknown 
class ImplTraversable implements Traversable{

}
```

其实之前的文章中，我们已经验证过，对象是可以被遍历的，而且并不需要实现什么迭代器接口就可以被 foreach 遍历。它会输出 所有 public 的属性。

```php
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
```

也就是说这个 Traversable 接口的作用在实际使用中并不明显。相信我们决大部分人也并没有使用过这个接口来判断过类是否可以被遍历。但是从上面的例子中我们可以看出，迭代器能够自定义我们需要输出的内容。相对来说比直接的对象遍历更加的灵活可控。另外，如果是数组强转对象的情况，Traversable 接口同样无法进行判断。

```php
$arr = [1, 2, 3, 4];
$obj3 = (object) $arr;
echo $obj3 instanceof Traversable ? 'yes' : 'no', PHP_EOL; // no

foreach ($obj3 as $o3) {
    echo $o3, PHP_EOL;
}
```

其实，数组本身就是天然的可迭代对象。这里虽然进行了类型强转，但其实应该将数组强转的对象视为默认实现了迭代的器的对象更合适。当然，这类接口更大的意义还是在于代码规范及强制检查方面。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/%E5%9C%A8PHP%E4%B8%AD%E6%A3%80%E6%B5%8B%E4%B8%80%E4%B8%AA%E7%B1%BB%E6%98%AF%E5%90%A6%E5%8F%AF%E4%BB%A5%E8%A2%ABforeach%E9%81%8D%E5%8E%86.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/%E5%9C%A8PHP%E4%B8%AD%E6%A3%80%E6%B5%8B%E4%B8%80%E4%B8%AA%E7%B1%BB%E6%98%AF%E5%90%A6%E5%8F%AF%E4%BB%A5%E8%A2%ABforeach%E9%81%8D%E5%8E%86.php)

参考文档：
[https://www.php.net/manual/zh/class.traversable.php](https://www.php.net/manual/zh/class.traversable.php)
[https://www.php.net/manual/zh/control-structures.foreach.php](https://www.php.net/manual/zh/control-structures.foreach.php)
[https://www.php.net/manual/zh/language.oop5.iterations.php](https://www.php.net/manual/zh/language.oop5.iterations.php)