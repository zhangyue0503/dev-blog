# PHP的变量赋值

这个标题估计很多人会不屑一顾，变量赋值？excuse me？我们学开发的第一课就会了好不好。但是，就是这样基础的东西，反而会让很多人蒙圈，比如，值和引用的关系。今天，我们就来具体讲讲。

首先，定义变量和赋值这个不用多说了吧

```php

$a = 1;
$b = '2';
$c = [4, 5, 6];
$d = new stdClass();

```

四个变量，分别定义了整型、字符串、数组的对象。这也是我们天天要打交道的四种类型。

然后，变量给变量赋值。

```php

$a1 = $a;
$b1 = $b;
$c1 = $c;
$d1 = $d;

```

请注意，前三个的赋值都是正常的赋值，也就是对具体内容的拷贝。当我们修改$a1的时候$a不会有变化。$a1是新开的内存空间保存了我们的值。也就是说，他们的值是一样的，但内存地址不一样。是两个没啥关系的长得很像的人而已。

但是$d1和$d就不是了，这两货不仅值是一样的，内存地址也是一样的。这种情况就是我们所说的引用赋值。当$d1发生变化时，$d2也会产生变化。

可以这么说：**引用赋值就是为原变量建立了一个Windows下的快捷方式或者Linux中的软链接。**

用具体的例子来说明，首先是普通值的赋值：

```php

// 普通赋值
$v = '1';
$c = $v;
$c = '2';
echo $v, PHP_EOL; // '1'

// 数组也是普通赋值
$arr1 = [1,2,3];
$arr2 = $arr1;
$arr2[1] = 5;
print_r($arr1); // [1, 2, 3]

```

$c不会对$v的值产生影响。$arr2修改了下标1，也就是第二个数字为5，当然也不会对$arr1产生影响。

那么对象形式的引用赋值呢？

```php

// 对象都是引用赋值
class A {
    public $name = '我是A';
}

$a = new A();
$b = $a;

echo $a->name, PHP_EOL; // '我是A'
echo $b->name, PHP_EOL; // '我是A'

$b->name = '我是B';
echo $a->name, PHP_EOL; // '我是B'

```

果然不出所料，$b修改了name属性的内容后，$a里面的name也变成了$b所修改的内容。

在这种情况下，如果对象想要不是引用传递的，一是使用__clone()，也就是原型模式来进行自己的拷贝。二是从外面重新new一个呗。

```php

// 使用克隆解决引用传递问题
class Child{
    public $name = '我是A1的下级';
}
class A1 {
    public $name = '我是A';
    public $child;

    function __construct(){
        $this->child = new Child();
    }

    function __clone(){
        $this->name = $this->name;
        // new 或者用Child的克隆都可以
        // $this->child = new Child();
        $this->child = clone $this->child;
    }
}

$a1 = new A1();

echo $a1->name, PHP_EOL; // 输出a1原始的内容
echo $a1->child->name, PHP_EOL;

$b1 = $a1;
echo $b1->name, PHP_EOL; // b1现在也是a1的内容
echo $b1->child->name, PHP_EOL;

$b1->name = '我是B1'; // b1修改内容
$b1->child->name = '我是B1的下级';
echo $a1->name, PHP_EOL; // a1变成b1的内容了
echo $a1->child->name, PHP_EOL;

// 使用__clone
$b2 = clone $b1; // b2克隆b1
$b2->name = '我是B2'; // b2修改内容
$b2->child->name = '我是B2的下级';
echo $b1->name, PHP_EOL; // b1不会变成b2修改的内容
echo $b1->child->name, PHP_EOL;
echo $b2->name, PHP_EOL; // b2修改的内容没问题，b1、b2不是一个货了
echo $b2->child->name, PHP_EOL;

```

对象的引用这一块确实会容易让人蒙圈。特别是更加复杂的对象，内部的属性还有各种引用其他对象的时候。这种情况下一定要仔细确认引用赋值会不会带来问题，如果有问题，就使用新对象或者克隆技术进行引用问题的处理。

最后，轻松一下，引用变量的赋值就和我们给方法传引用参数一样的，使用一个&符号就可以啦！

```php

// 引用赋值
$b = &$v;
$b = '3';
echo $v, PHP_EOL;

```

今天我们更深入的学习和了解了一下PHP中的赋值问题，特别是普通赋值和引用赋值的问题。下回看代码和框架的时候可以注意注意别人是怎么灵活使用这两种赋值的哈，自己也能试试能不能运用这两种方式改造下自己曾经写过的BUG哦！