# PHP中的对象比较

在之前的文章中，我们讲过[PHP中比较数组的时候发生了什么？](https://mp.weixin.qq.com/s/FMfjNarP7_xFiYgderph-g)。这次，我们来讲讲在对象比较的时候PHP是怎样进行比较的。

首先，我们先根据PHP文档来定义对象比较的方式：

- 同一个类的实例，比较属性大小，根据顺序，遇到不同的属性值后比较返回，后续的不会再比较
- 不同类的实例，比较属性值
- ===，必须是同一个实例

我们通过一个例子来看下：

```php
function bool2str($bool)
{
    if ($bool === false) {
        return 'FALSE';
    } else {
        return 'TRUE';
    }
}

function compareObjects(&$o1, &$o2)
{
    echo 'o1 == o2 : ' . bool2str($o1 == $o2) . "\n";
    echo 'o1 === o2 : ' . bool2str($o1 === $o2) . "\n";
}

class A {
    private $t = true;
    public function setT($t){
        $this->t = $t;
    }
}

class B {
    protected $t = true;
    public function setT1($t){
        $this->t = $t;
    }
}

class C {
    private $t = true;
    public function setT($t){
        $this->t = $t;
    }
}

$a1 = new A();
$a2 = new A();

compareObjects($a1, $a2); // 相同的类
// o1 == o2 : TRUE
// o1 === o2 : FALSE

$a11 = $a1;

compareObjects($a1, $a11); // 相同的实例
// o1 == o2 : TRUE
// o1 === o2 : TRUE

$a11->setT(false);

compareObjects($a1, $a11); // 相同实例属性值不同
// o1 == o2 : TRUE
// o1 === o2 : TRUE

$b = new B();

compareObjects($a1, $b); // 不同的类
// o1 == o2 : FALSE
// o1 === o2 : FALSE

$c = new C();

compareObjects($a1, $b); // 相同属性不同的类
// o1 == o2 : FALSE
// o1 === o2 : FALSE
```

从例子中，我们可以看出基本都是符合上述三个条件的，不过需要注意的是，在===的情况下，如果是同一个实例对象，属性值不同也会返回TRUE。我们再通过一个更复杂的例子来观察：

```php
$c = new stdClass();
$d = new stdClass();

$c->t1 = 'c';
$c->t2 = 10;
$c->t3 = 50;

$d->t1 = 'c';
$d->t2 = 11;
$d->t3 = 40;

echo 'c > d:', $c > $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c < d:', $c < $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE

$d->t2 = 10; // $t2属性改成相等的
echo 'c > d:', $c > $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c < d:', $c < $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$d->t3 = 50; // $c、$d属性都相等了
echo 'c >= d:', $c >= $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c <= d:', $c <= $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c == d:', $c == $d ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c === d:', $c === $d ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$c1 = clone $c; // 复制同一个对象
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

$c1->t4 = 'f'; // 增加了一个属性
echo 'c > c1:', $c > $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // TRUE
echo 'c < c1:', $c < $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE

unset($c1->t4);
$c1->t1 = 'd';  // 修改了一个值
echo 'c == c1:', $c == $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
echo 'c === c1:', $c === $c1 ? 'TRUE' : 'FALSE', PHP_EOL; // FALSE
```

这个例子中，我们进行了<、>的对比，在这种对比中，都是根据属性值来进行比对的，而对比的顺序也是属性值的英文排序。当$t2有了不相等的比较结果时，$t3就不会再进行比对了。此外，clone之后的对象并不是原来的实例对象了，所以clone后的对象和原对象是无法用===来获得相等的结果的。当一个对象的属性比另一个对象多时，这个对象也会比属性少的对象大。

对象的比较其实和数组是有些类似的，但它们又有着些许的不同。一个重要的方面就是把握住它们都会进行属性比较，另外还有就是===的差别，数组中===必须是所有属性的类型都相同，而对象中则必须是同一个实例，而且对象只要是同一个实例，使用===就不会在乎它属性值的不同了。

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/language.oop5.object-comparison.php](https://www.php.net/manual/zh/language.oop5.object-comparison.php)
