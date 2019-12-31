# PHP的可变变量与可变函数

什么叫可变。在程序世界中，可变的当然是变量。常量在定义之后都是不可变的，在程序执行过程中，这个常量都是不能修改的。但是变量却不同，它们可以修改。那么可变变量和可变函数又是什么意思呢？很明显，就是用另一个变量来定义他们，这个变量是可变的呀！

> 可变变量

```php

$a = 'hello';

$$a = 'world';

echo $a, ' ', $hello;

```

咦，我们没有定义$hello这个变量呀。嗯，从表面上看我们确实没有定义这个变量，但请注意这个$$符号。$符号的意思就是定义变量，当我们在一个$符号后面跟上一个已经定义的变量名，那么这个变量的内容就成为了新的变量名。也就是说，$a的内容hello成为了一个新的变量名叫$hello，然后给它赋值为world。是不是感觉不太好理解，也不便于我们查看代码，这个问题我们最后再说。

当然，以下的用法要注意：

```php

$a = 1;
$$a = 2;

echo $1; // Parse error: syntax error, unexpected '1'
echo ${1}; // ok

$a = ['b', 'c', 'd'];
$$a = 'f';

echo $b, $c, $d;

```

- 数字类型不是合法的变量名，不能作为可变变量被定义
- 但是利用{}，是可以输出的，{}会获取{}内部的值并作为一个变量来解析，这里的{1}我们利用可变变量赋值成为了一个变量，直接输出是非常的，但放在{1}中就成为了一个可解析的变量名，我们可以简单的理解为{1}转换成了$'1'，成为了一个正式的变量名
- 数组当然是不行啦
- 它们这样写都是不会报错的

使用对象就不行了，直接就会报错了，对象是不能进行可变变量的操作的。

```php

class A {}
class B extends A {}

$a = new A();
$$a = new B(); // Catchable fatal error: Object of class A could not be converted to string 

```

> 可变函数

可变函数其实也大同小异，当我们在一个变量的后面加上()时，PHP就会尝试将这个变量当做函数来解析。

```php

function testA()
{
    echo "testA";
}

$a = 'testA';
$a(); // testA

```

可变变量是将一个字符串转换成了一个变量名，而可变函数则是将一个字符串当做函数名来调用。比如类中的方法，我们可以这样来调用：

```php

class C
{
    public function testA()
    {
        echo "C:testA";
    }
    public function testB()
    {
        echo "C:testB";
    }
    public function testC()
    {
        echo "C:testC";
    }
}

$funcs = ['testA', 'testB', 'testC'];

$c = new C();
foreach ($funcs as $func) {
    $c->$func();
}

```

可变函数的这种特性和另外两个系统函数的关系非常紧密，它们是：call_user_func()和call_user_func_array()，Laravel中服务容器的核心实现就是使用了call_user_func_array()来实现依赖注入与控制反转的，这个等我们将来学习到的时候再说。

> 总结

看似很美好很灵活的可变变量与可变函数在我们实际的开发中却很少使用。究其原因当然是可读性不好，代码不仅是写给机器的，也是写给人看的，团队中人员的水平不齐的话过多的使用这两种特性会产生非常多的混乱情况。但是，很多框架代码中会使用这些特性，所以，这也是我们向更高层次迈进所必须要掌握的东西。不管怎么样，学就是了，能在业务场合中使用可变变量或者函数大大节约代码量写出精致易读的代码更能彰显我们的技术实力。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E7%9A%84%E5%8F%AF%E5%8F%98%E5%8F%98%E9%87%8F%E4%B8%8E%E5%8F%AF%E5%8F%98%E5%87%BD%E6%95%B0.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E7%9A%84%E5%8F%AF%E5%8F%98%E5%8F%98%E9%87%8F%E4%B8%8E%E5%8F%AF%E5%8F%98%E5%87%BD%E6%95%B0.php)

参考链接：
[https://www.php.net/manual/zh/language.variables.variable.php](https://www.php.net/manual/zh/language.variables.variable.php)
[https://www.php.net/manual/zh/functions.variable-functions.php](https://www.php.net/manual/zh/functions.variable-functions.php)