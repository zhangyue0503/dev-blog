# 彻底搞明白PHP的中引用的概念

之前我们其实已经有过几篇文章讲过引用方面的问题，这次我们来全面的梳理一下引用在PHP到底是怎么回事，它和C中的指针有什么不同，在使用的时候要注意些什么。

## 什么是引用？

**在 PHP 中引用意味着用不同的名字访问同一个变量内容。它不是C的指针，保存的并不是内存地址，无法进行指针运算。引用只是符号表的别名。就像 Unix 系统中的硬链接， Windows 系统中的快捷方式。**

上面是官方手册中的原文，怎么说呢，引用其实和我们印象中的C里面的指针并不是相同的概念。指针是针对真实内存的操作，引用是针对指向这个内存的符号表的操作。还是从操作系统的快捷方式来说，快捷方式是可以删的，这就是PHP的引用。而C不仅删了快捷方式，还把原文件也给删了，这就是C的指针操作。

```php
// 引用不是指针
$a = 1;
$b = &$a;
echo $a, '===', $b, PHP_EOL;
unset($b);
echo $a, '===', $b, PHP_EOL;
```

上面的代码是在PHP中，我们把$b变量指向$a，作为$a的引用变量。然后删除$b，对$a没有任何影响。

```php
#include <stdio.h>
#include <stdlib.h>

int main()
{
    // C 中的指针和引用
    int a = 1;
    int* b = &a;
    printf("%i\n", a); // 1
    free(b); // free b
    printf("%i\n", a); //get error: *** error for object 0x7fff6350da08: pointer being freed was not allocated
    return 0;
}
```

而C中的引用指针就不行了，我们把b变量删掉后，再打印a变量就直接报错了。

虽然说PHP的底层也是C写得，但我们都知道C中的指针是出了名的变态，没有一定的功底非常容易出错。所以PHP的开发者没有暴露C的原始指针能力，而是采用了和Java之类的类似的引用能力。这也是现代语言的特性，不需要我们过多的关注过于底层的能力，而将更多的时间放在业务实现上。

## 引用在数组和对象中的使用

**如果具有引用的数组被拷贝，其值不会解除引用。对于数组传值给函数也是如此。**

```php
$arr1 = ["a", "b"];
$t1 = &$arr1[1];
$arr2 = $arr1;
$arr2[1] = "c";
var_dump($arr1);

// array(2) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     &string(1) "c"
// }

$arr1 = ["a", "b"];
$t1 = &$arr1[1];
unset($t1); // unset 掉引用
$arr2 = $arr1;
$arr2[1] = "c";
var_dump($arr1);

// array(2) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     string(1) "b"
// }
```

这个其实挺有意思的，我们对比这两个例子可以看出一个问题，$t变量指向$arr[1]的引用。$arr2直接=这个$arr1，没有使用引用，然后$arr2修改了$arr2[1]的内容，$arr1相应的内容也发生了改变，如果unset掉$t变量，则$arr1相应的内容就不会发生改变。对此，我在文档中找到了下面的解释：

**由于PHP内部工作的特殊性，如果对数组的单个元素进行引用，然后复制数组，无论是通过赋值还是通过函数调用中的值传递，都会将引用复制为数组的一部分。这意味着对任一数组中任何此类元素的更改都将在另一个数组（和其他引用中）中重复，即使数组具有不同的作用域（例如，一个是函数内部的参数，另一个是全局的）！在复制时没有引用的元素，以及在复制数组后分配给其他元素的引用，将正常工作（即独立于其他数组）。**

不仅仅是数组，对象的引用也会有一些好玩的问题。

```php
$o1 = new stdClass();
$o1->a = 'a';
var_dump($o1);
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(1) "a"
// }

$o2 = &$o1;
$o3 = $o1;

$o2->a = 'aa';

var_dump($o1);
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(2) "aa"
// }

var_dump($o3); // $o2修改了$a为'aa'，$o3也变成了'aa'
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(2) "aa"
// }

$o1->a = 'aaa';
$o1 = null;
var_dump($o2); // $o2引用变成了null
// NULL

var_dump($o3); // $o3不仅引用还存在，并且$a变成了'aaa'
// object(stdClass)#1 (1) {
//   ["a"]=>
//   string(3) "aaa"
// }
```

上面例子中有三个对象，$o1、$o2、$o3，其中，$o2是对$o1的引用，$o3是直接赋值为$o1。对$o2属性的操作不仅会反映在$o1中，也会反映到$o3中。其实我们之前专门有一篇文章就讲的这个问题，首先对象默认赋值就是引用，其次这个例子很好地证明了引用就是一个符号表的绑定。删除了快捷方式对原始对象和其他快捷方式没有任何影响。大家可以参考：[对象赋值在PHP中到底是不是引用？](https://mp.weixin.qq.com/s/wKIU83A7u1ENQF32jX5FSQ)

## 引用的传递

关于引用在方法参数上的传递，最重要的是记住两点：一是方法内部修改了变量外部也会变，这是引用的特性嘛；二是只能传递变量、New 语句、从函数中返回的引用三种类型。

```php
error_reporting(E_ALL);
function foo(&$var)
{
    $var++;
    echo 'foo：', $var;
}
function bar() // Note the missing &
{
    $a = 5;
    return $a;
}
foo(bar()); // 自 PHP 5.0.5 起导致致命错误，自 PHP 5.1.1 起导致严格模式错误
            // 自 PHP 7.0 起导致 notice 信息,Notice: Only variables should be passed by reference
foo($a = 5); // 表达式，不是变量, Notice: Only variables should be passed by reference
// foo(5); // 导致致命错误 !5是个常量!

///////////////////////////////
// 正确的传递类型
$a = 5;
foo($a); // 变量

function &baz()
{
    $a = 5;
    return $a;
}
foo(baz()); // 从函数中返回的引用

function foo1(&$var)
{
    print_r($var);
}
foo1(new stdClass()); // new 表达式
```

## 引用的返回

引用的返回并不是经常使用的一个能力。文档中的原文是：**不要用返回引用来增加性能，引擎足够聪明来自己进行优化。仅在有合理的技术原因时才返回引用！**

```php
$a = 1;
function &test(){
    global $a;
    return $a;
}

$b = &test($a);
$b = 2;
echo $a, PHP_EOL;
```

当你想要返回一个引用变量的时候，一定要给方法定义和方法调用的时候都使用&符号。这个是需要注意的点。当其他地方修改原本的变量值或者返回的变量值经过修改后，都会影响到所有调用这个值的地方。所以说，引用的返回是比较危险的，因为你不清楚什么时候在什么地方这个值可能发生了修改，对于bug的排查会非常困难。

## 引用的取消

取消引用其实就是直接unset掉变量就可以了。但是一定要记住，PHP中的引用是指向的符号表，对原始真实的值是不起作用的，所以即使unset掉了最原始的那个变量，对其它引用赋值的变量也不会有影响！！

```php
$a = 1;
$b = &$a;
$c = &$b;
$b = 2;
echo '定义引用后：', $a, '===', $b, '===', $c, PHP_EOL;

unset($b);
$b = 3;
echo '取消$b的引用，不影响$a、$c：', $a, '===', $b, '===', $c, PHP_EOL;

$b = &$a;
unset($a);
echo '取消$a，不影响$b、$c：', $a, '===', $b, '===', $c, PHP_EOL;

// 定义引用后：2===2===2
// 取消$b的引用：2===3===2
// 取消$a，不影响$c：===3===2


$a = 1;
$b = & $a;
$c = & $b; // $a, $b, $c reference the same content '1'

$a = NULL; // All variables $a, $b or $c are unset
echo '所有引用成空：', $a, '===', $b, '===', $c, PHP_EOL;
```

## 总结

这一次算是比较彻底的把引用说了个透。关于PHP的引用只要记住了它的定义就非常好理解了，最直观的就是当成是操作系统的快捷方式就好了，并没有我们想象中的那么难，和C的指针相比真的只是娃娃级别，多多练习多多复习自然就能很好地掌握使用啦！

测试代码：

参考文档：
[https://www.php.net/manual/zh/language.references.whatare.php](https://www.php.net/manual/zh/language.references.whatare.php)
[https://www.php.net/manual/zh/language.references.whatdo.php](https://www.php.net/manual/zh/language.references.whatdo.php)
[https://www.php.net/manual/zh/language.references.arent.php](https://www.php.net/manual/zh/language.references.arent.php)
[https://www.php.net/manual/zh/language.references.pass.php](https://www.php.net/manual/zh/language.references.pass.php)
[https://www.php.net/manual/zh/language.references.return.php](https://www.php.net/manual/zh/language.references.return.php)
[https://www.php.net/manual/zh/language.references.unset.php](https://www.php.net/manual/zh/language.references.unset.php)
[https://www.php.net/manual/zh/language.references.spot.php](https://www.php.net/manual/zh/language.references.spot.php)
