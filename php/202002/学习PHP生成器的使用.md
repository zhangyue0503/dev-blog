# 学习PHP生成器的使用

## 什么是生成器？

听着高大上的名字，感觉像是创造什么东西的一个功能，实际上，生成器是一个用于迭代的迭代器。它提供了一种更容易的方式来实现简单的对象迭代，相比较定义类实现Iterator接口的方式，性能开销和复杂性大大降低。

说了半天不如直接看看代码更直观。

```php
function test1()
{
    for ($i = 0; $i < 3; $i++) {
        yield $i + 1;
    }
    yield 1000;
    yield 1001;
}

foreach (test1() as $t) {
    echo $t, PHP_EOL;
}

// 1
// 2
// 3
// 1000
// 1001
```

就是这么简单的一段代码。首先，生成器必须在方法中并使用 yield 关键字；其次，每一个 yield 可以看作是一次 return ；最后，外部循环时，一次循环取一个 yield 的返回值。在这个例子，循环三次返回了1、2、3这三个数字。然后在循环外部又写了两行 yield 分别输出了1000和1001。因此，外部的 foreach 一共循环输出了五次。

很神奇吧，明明是一个方法，为什么能够循环它而且还是很奇怪的一种返回循环体的格式。我们直接打印这个 test() 方法看看打印的是什么：

```php
// 是一个生成器对象
var_dump(test1());

// Generator Object
// (
// )
```

当使用了 yield 进行内容返回后，返回的是一个 Generator 对象。这个对象就叫作生成器对象，它不能直接被 new 实例化，只能通过生成器函数这种方式返回。这个类包含 current() 、 key() 等方法，而且最主要的这个类实现了 Iterator 接口，所以，它就是一个特殊的迭代器类。

```php
Generator implements Iterator {
    /* 方法 */
    public current ( void ) : mixed
    public key ( void ) : mixed
    public next ( void ) : void
    public rewind ( void ) : void
    public send ( mixed $value ) : mixed
    public throw ( Exception $exception ) : void
    public valid ( void ) : bool
    public __wakeup ( void ) : void
}
```

## 生成器有什么用？

搞了半天不就是个迭代器嘛？搞这么麻烦干嘛，直接用迭代器或者在方法中直接返回一个数组不就好了吗？没错，正常情况下真的没有这么麻烦，但是如果是在数据量特别大的情况下，这个生成器就能发挥它的强大威力了。生成器最最强大的部分就在于，它不需要一个数组或者任何的数据结构来保存这一系列数据。每次迭代都是代码执行到 yield 时动态返回的。因此，生成器能够极大的节约内存。

```php
// 内存占用测试
$start_time = microtime(true);
function test2($clear = false)
{
    $arr = [];
    if($clear){
        $arr = null;
        return;
    }
    for ($i = 0; $i < 1000000; $i++) {
        $arr[] = $i + 1;
    }
    return $arr;
}
$array = test2();
foreach ($array as $val) {
}
$end_time = microtime(true);

echo "time: ", bcsub($end_time, $start_time, 4), PHP_EOL;
echo "memory (byte): ", memory_get_usage(true), PHP_EOL;

// time: 0.0513
// memory (byte): 35655680

$start_time = microtime(true);
function test3()
{
    for ($i = 0; $i < 1000000; $i++) {
        yield $i + 1;
    }
}
$array = test3();
foreach ($array as $val) {

}
$end_time = microtime(true);

echo "time: ", bcsub($end_time, $start_time, 4), PHP_EOL;
echo "memory (byte): ", memory_get_usage(true), PHP_EOL;

// time: 0.0517
// memory (byte): 2097152
```

上述代码只是简单的进行 1000000 个循环后获取结果，不过也可以直观地看出。使用生成器的版本仅仅消耗了 2M 的内存，而未使用生成器的版本则消耗了 35M 的内存，直接已经10多倍的差距了，而且越大的量差距超明显。因此，有大神将生成器说成是PHP中最被低估了的一个特性。

## 生成器的应用

接下来我们来看看生成器的一些基本的应用方式。

### 返回空值以及中断

生成器当然也可以返回空值，直接 yield; 不带任何值就可以返回一个空值了。而在方法中直接使用 return; 也可以用来中断生成器的继续执行。下面的代码我们在 \\$i = 4; 的时候返回的是个空值，也就是不会输出 5 （因为我们返回的是 $i + 1 ）。然后在 $i == 7 的时候使用 return; 中断生成器的继续执行，也就是循环最多只会输出到 7 就结束了。

```php
// 返回空值以及中断
function test4()
{
    for ($i = 0; $i < 10; $i++) {
        if ($i == 4) {
            yield; // 返回null值
        }
        if ($i == 7) {
            return; // 中断生成器执行
        }
        yield $i + 1;
    }
}

foreach (test4() as $t) {
    echo $t, PHP_EOL;
}


// 1
// 2
// 3
// 4

// 5
// 6
// 7
```

### 返回键值对形式

不要惊讶，生成器真的是可以返回键值对形式的可遍历对象供 foreach 使用的，而且语法非常好记： yield key => value; 是不是和数组项的定义形式一模一样，非常直观好理解。

```php
function test5()
{
    for ($i = 0; $i < 10; $i++) {
        yield 'key.' . $i => $i + 1;
    }
}

foreach (test5() as $k=>$t) {
    echo $k . ':' . $t, PHP_EOL;
}

// key.0:1
// key.1:2
// key.2:3
// key.3:4
// key.4:5
// key.5:6
// key.6:7
// key.7:8
// key.8:9
// key.9:10
```

### 外部传递数据

我们可以通过 Generator::send 方法来向生成器中传入一个值。传入的这个值将会被当做生成器当前 yield 的返回值。然后我们根据这个值可以做一些判断，比如根据外部条件中断生成器的执行。

```php
function test6()
{
    for ($i = 0; $i < 10; $i++) {
        // 正常获取循环值，当外部send过来值后，yield获取到的就是外部传来的值了
        $data = (yield $i + 1);
        if($data == 'stop'){
            return;
        }
    }
}
$t6 = test6();
foreach($t6 as $t){
    if($t == 3){
        $t6->send('stop');
    }
    echo $t, PHP_EOL;
}

// 1
// 2
// 3
```

上述代码理解起来可能比较绕，但是注意记住注释的那行话就行了（正常获取循环值，当外部send过来值后，yield获取到的就是外部传来的值了）。另外，变量获取 yield 的值，必须要用括号括起来。

### yield from 语法

yield from 语法其实就是指的从另一个可迭代对象中一个一个的获取数据并形成生成器返回。直接看代码。

```php
function test7()
{
    yield from [1, 2, 3, 4];
    yield from new ArrayIterator([5, 6]);
    yield from test1();
}
foreach (test7() as $t) {
    echo 'test7：', $t, PHP_EOL;
}

// test7：1
// test7：2
// test7：3
// test7：4
// test7：5
// test7：6
// test7：1
// test7：2
// test7：3
// test7：1000
```

在 test7() 方法中，我们使用 yield from 分别从普通数组、迭代器对象、另一个生成器中获取数据并做为当前生成器的内容进行返回。

## 小惊喜

### 生成器可以用count获取数量吗？

抱歉，生成器是不能用count来获取它的数量的。

```php
$c = count(test1()); // Warning: count(): Parameter must be an array or an object that implements Countable
// echo $c, PHP_EOL;
```

使用 count 来获取生成器的数量将直接报 Warning 警告。直接输出将会一直显示是 1 ，因为 count 的特性（强制转换成数组都会显示 1 ）。

### 使用生产器来获取斐波那契数列

```php
// 利用生成器生成斐波那契数列
function fibonacci($item)
{
    $a = 0;
    $b = 1;
    for ($i = 0; $i < $item; $i++) {
        yield $a;
        $a = $b - $a;
        $b = $a + $b;
    }
}

$fibo = fibonacci(10);
foreach ($fibo as $value) {
    echo "$value\n";
}
```

这段代码就不多解释了，非常直观的一段代码了。

## 总结

生成器绝对是PHP中的一个隐藏的宝藏，不仅是对于内存节约来说，而且语法其实也非常的简洁明了。我们不需要在方法内部再多定义一个数组去存储返回值，直接 yield 一项一项的返回就可以了。在实际的项目中完全值得尝试一把，但是尝试完了别忘了和小伙伴们分享，大部分人可能真的没有接触过这个特性哦！！

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E5%AD%A6%E4%B9%A0PHP%E7%94%9F%E6%88%90%E5%99%A8%E7%9A%84%E4%BD%BF%E7%94%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E5%AD%A6%E4%B9%A0PHP%E7%94%9F%E6%88%90%E5%99%A8%E7%9A%84%E4%BD%BF%E7%94%A8.php)

参考文档：
[https://www.php.net/manual/zh/language.generators.overview.php](https://www.php.net/manual/zh/language.generators.overview.php)
[https://www.php.net/manual/zh/class.generator.php](https://www.php.net/manual/zh/class.generator.php)
