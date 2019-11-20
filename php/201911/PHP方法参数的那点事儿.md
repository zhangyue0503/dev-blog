# PHP方法参数的那点事儿

在所有的编程语言中，方法或者函数，都可以传递一些参数进来进行业务逻辑的处理或者计算。这没什么可说的，但是在PHP中，方法的参数还有许多非常有意思的能力，下面我们就来说说这方面的内容。

> 引用参数

涉及到值传递和引用传递的问题。在正常情况下，我们使用值传递的时候，变量是进行了拷贝，方法内外的变量不会共享内存。也就是说，在方法体中修改了变量的值，方法外部的变量不会产生变化。而引用传递则是传递的变量的内存地值。方法内外的变量可以看做是同一个变量，比如：

```php

$a = 1;
function test(&$arg){
    $arg++;
}
test($a);
echo $a; // 2

```

为参数加上&标识，就表明这个参数是引用传递的参数。如果没有加这个标识，则所有的基本类型参数都会以值的方式进行传递。为什么要强调基本类型呢？下面我们用类当参数来测试一下：

```php

class A
{
    public $a = 1;
}
function testA($obj)
{
    $obj->a++;
}

$o = new A();
testA($o);
echo $o->a; // 2

```

在这个例子中，我们并没有使用&标识来表明参数$obj是引用类型的，但如果传递的参数是对象的话，那么它默认就是进行的引用传递。如果想让对象也是值传递呢？抱歉，在方法参数中是没办法实现的，只能在方法体中使用clone方式对对象参数进行克隆。

```php

class A
{
    public $a = 1;
}
function testA($obj)
{
    $o = clone $obj;
    $o->a++;
}
$o = new A();
testA($o);
echo $o->a; // 1

```

关于值和引用的问题，可以参考设计模式中原型模式的讲解：
[PHP设计模式之原型模式](https://mp.weixin.qq.com/s/KO4TuT2t5Xh_3BG3UrfN1w)

> 默认参数

参数是可以有默认值的，这个我想大家都应该很清楚了。但是在使用的时候也需要注意，那就是默认参数不要放在前面，否则很容易出错，比如：

```php

function testArgsA($a = 1, $b){
    echo $a+$b;
}

testArgs(); // error

function testArgsB($a = 1, $b = 2){
    echo $a+$b;
}

testArgsB(); // 3

function testArgsC($a, $b = 2){
    echo $a+$b;
}

testArgsC(1); // 3

```

在复杂的函数或者紧急的业务开发中，很有可能一个不小心就会漏写参数，这时候testArgsA就会返回错误了。当然，这种粗心类的错误是我们应该尽量避免的。

当指定默认值的时候，我们应该根据参数的类型进行指定，比如字符串就指定为''，数字就指定为数字类型。当不确定参数是什么类型时，建议使用NULL做为默认参数。

```php

function testArgsD($a = NULL)
{
    if ($a) {
        echo $a;
    }
}

testArgsD(1);
testArgsD('a');

```

> 类型声明

类型声明是在PHP5之后添加的功能，就像java一样，参数前面加上参数的类型，比如：

```php

function testAssignA(int $a = 0)
{
    echo $a;
}

testAssignA(1);
testAssignA("a"); // error

```

如果参数的类型不对，直接就会报错。在PHP7以前，只支持类、数组和匿名方法的类型声明。在PHP7之后，支持所有的普通类型，但是这里要注意的是，只支持普通类型的固定写法。

- Class/interface name
- self
- array
- callable
- bool
- float
- int
- string

固定写法是什么意思呢？

```php

function testAssignB(integer $a = 0) // error
{
    echo $a;
}

```

也就是说，int只能写int，不能使用integer，bool也不能使用boolean。只能是上面列出的类型关键字。

类型声明的好处是什么呢？其实就是Java这种静态语言和PHP这种动态语言之间的差别。动态类型语言的好处就是变量灵活，不用指定类型，方便快速开发迭代。但问题也在于灵活，为了灵活，动态语言往往会在比较或者计算时对变量进行自动类型转换。如果你对变量类型转换的理解不清晰的话，很容易就会出现各种类型的BUG。同时，静态类型的语言一般都会有编译打包，而动态类型则是在执行时确定变量类型，所以很少会进行编译打包，相对来说运行效率也就不如Java之类的编译后语言了。

关于PHP的类型转换问题，可以参考此前的文章：
[PHP中的强制类型转换]()

Tips一个小技巧，如果声明了参数类型，是不能传递NULL值的，比如：

```php

function testAssignC(string $a = '')
{
    if ($a) {
        echo __FUNCTION__ . ':' . $a;
    }
}

testAssignC(NULL); // TypeError

```

这时有两种方式可以解决，一是指定默认值=NULL，二是使用?操作符：

```php


function testAssignD(string $a = NULL)
{
    if ($a == NULL) {
        echo 'null';
    }
}

testAssignD(NULL); // null


function testAssignE(?string $a)
{
    if ($a == NULL) {
        echo 'null';
    }
}
testAssignE(NULL); // null

```

> 可变数量参数

php中的方法可以接收可变数量的参数，比如：

```php

function testMultiArgsA($a)
{
    var_dump(func_get_arg(2));
    var_dump(func_get_args());
    var_dump(func_num_args());
    echo $a;
}

testMultiArgsA(1, 2, 3, 4);

```

我们只定义了一个参数$a，但是传进去了四个参数，这时我们可以使用三个方法来获取所有的参数：

- func_get_arg(int $arg_num)，获取参数列表中的某个指定位置的参数
- func_get_args()，获取参数列表
- func_num_args()，获取参数数量

此外，php还提供了...操作符，用于将可变长度的参数定义到一个参数变量中，如：

```php

function testMultiArgsB($a, ...$b)
{
    var_dump(func_get_arg(2));
    var_dump(func_get_args());
    var_dump(func_num_args());
    echo $a;
    var_dump($b); // 除$a以外的
}

testMultiArgsB(1, 2, 3, 4);

```

和参数默认值一样，有多个参数的情况下，...$b也不要放在前面，这样后面的参数并不会有值，所有的参数都会在$b中。不过PHP默认已经帮我们解决了这个问题，如果...参数后面还有参数的话，会直接报错。

利用这个操作符，我们还可以很方便的解包一些数组或可迭代的对象给方法参数，例如：

```php

function testMultiArgsC($a, $b){
    echo $a, $b;
}

testMultiArgsC(...[1, 2]);

```

是不是很有意思，那么我们利用这个特性来合并一个数组会是什么效果呢？

```php

$array1 = [[1],[2],[3]];
$array2 = [4];
$array3 = [[5],[6],[7]];

$result = array_merge(...$array1); // Legal, of course: $result == [1,2,3];
print_r($result);
$result = array_merge($array2, ...$array1); // $result == [4,1,2,3]
print_r($result);
$result = array_merge(...$array1, $array2); // Fatal error: Cannot use positional argument after argument unpacking.
$result = array_merge(...$array1, ...$array3); // Legal! $result == [1,2,3,5,6,7]
print_r($result);

```

和方法声明参数时一样，在外部使用...操作符给方法传递参数时，也不能在...后面再有其他参数，所以array_merge(...$array1, $array2)的操作会报错。

测试代码：[]()

参考文档：
[https://www.php.net/manual/zh/functions.arguments.php](https://www.php.net/manual/zh/functions.arguments.php)
[https://www.php.net/manual/zh/functions.arguments.php#121579](https://www.php.net/manual/zh/functions.arguments.php#121579)
[https://www.php.net/manual/zh/functions.arguments.php#120580](https://www.php.net/manual/zh/functions.arguments.php#120580)