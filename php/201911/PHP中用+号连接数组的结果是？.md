# PHP中用+号连接数组的结果是？

我们在开发中，有时候会将两个数组合并连接起来，这个时候要注意了，千万不要偷懒直接使用+号哦，为什么呢？我们看看以下代码：

```php

$a = [1, 2];
$b = [4, 5, 6];

$c = $a + $b;
print_r($c);

```

请用第一直接告诉我它的结果是什么？或许我这么问你应该能猜到，它的结果是：

```php

Array
(
    [0] => 1
    [1] => 2
    [2] => 6
)

```

看出来了吧，用+号操作符连接的数组，结果取的是并集。也就是根据键，相同键的不会覆盖，没有键加入进来形成一个新数组。并不是将两个数组真的加起来。

如果我们用$b+$a呢？那么结果就是$b的内容。

```php

$c = $b + $a;
print_r($c);

Array
(
    [0] => 4
    [1] => 5
    [2] => 6
)

```

那么我们要获得1,2,4,5,6这样一个数组要怎么办呢？没错，使用array_merge()函数，请注意数组Key的位置：

```php

$c = array_merge($a, $b);
print_r($c);

Array
(
    [0] => 1
    [1] => 2
    [2] => 4
    [3] => 5
    [4] => 6
)

$c = array_merge($b, $a);
print_r($c);

Array
(
    [0] => 4
    [1] => 5
    [2] => 6
    [3] => 1
    [4] => 2
)

```

如果是key/value形式的Hash数组呢？结果也是一样的，$a中没有键将合并过来，相同的键将不处理。

```php

$a = ['a' => 1, 'b' => 2];
$b = ['a' => 4, 'b' => 5, 'c' => 6];

print_r($a+$b);

Array
(
    [a] => 1
    [b] => 2
    [c] => 6
)

$c = array_merge($a, $b);
print_r($c);

$c = array_merge($b, $a);
print_r($c);

Array
(
    [a] => 1
    [b] => 2
    [c] => 6
)
Array
(
    [a] => 4
    [b] => 5
    [c] => 6
)
Array
(
    [a] => 1
    [b] => 2
    [c] => 6
)

```

上述Hash数组，使用array_merge()函数的结果和使用+号的结果是一样的，这是因为他们还是进行了键的对比。所以合并后的数组不会增加内容，如果是未定义下标的则会直接以数字下标添加进去。

最后，我们再试试.操作符的连接：

```php

$c = $a . $b;
print_r($c);

ArrayArray

```

好吧，强转成string类型的字符串再拼接起来了，并无特别的意义。

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E4%B8%AD%E7%94%A8%2B%E5%8F%B7%E8%BF%9E%E6%8E%A5%E6%95%B0%E7%BB%84%E7%9A%84%E7%BB%93%E6%9E%9C%E6%98%AF%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E4%B8%AD%E7%94%A8%2B%E5%8F%B7%E8%BF%9E%E6%8E%A5%E6%95%B0%E7%BB%84%E7%9A%84%E7%BB%93%E6%9E%9C%E6%98%AF%EF%BC%9F.php)

参考文档：[https://www.php.net/manual/zh/language.operators.array.php](https://www.php.net/manual/zh/language.operators.array.php)