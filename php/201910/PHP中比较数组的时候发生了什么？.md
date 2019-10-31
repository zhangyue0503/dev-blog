# PHP中比较数组的时候发生了什么？

首先还是从代码来看，我们通过比较运算符号来对两个数组进行比较：

```php

var_dump([1, 2] == [2, 1]); // false

var_dump([1, 2, 3] > [3, 2, 1]); // false

var_dump([5, 6, 7] > [1, 2, 3, 4]); // false

```

第一组：仔细看，从一眼看过去的正常角度来说，代码中对比的数组其实是一样的数组，[1, 2]和[2, 1]都是两个包含两个元素的数组，元素内容也是一样的，但是，他们的位置不一样。
第二组：同样是位置不一样，[1, 2, 3]是小于[3, 2, 1]的
第三组：[5, 6, 7]每个元素都大于[1, 2, 3, 4]，但结果是没有后一个数组大。

相信不少同学已经看出一些端倪了。数组之间的操作符比较是先进行元素数量对比，然后再对比每个键值。官方文档上的解释为：

> 具有较少成员的数组较小，如果运算数 1 中的键不存在于运算数 2 中则数组无法比较，否则挨个值比较

```php

<?php
// 数组是用标准比较运算符这样比较的
function standard_array_compare($op1, $op2)
{
    if (count($op1) < count($op2)) {
        return -1; // $op1 < $op2
    } elseif (count($op1) > count($op2)) {
        return 1; // $op1 > $op2
    }
    foreach ($op1 as $key => $val) {
        if (!array_key_exists($key, $op2)) {
            return null; // uncomparable
        } elseif ($val < $op2[$key]) {
            return -1;
        } elseif ($val > $op2[$key]) {
            return 1;
        }
    }
    return 0; // $op1 == $op2
}

```

上述代码就是php中使用比较操作符进行数组比较时的代码，首先是count数组的元素数量，如果数组1大于数组2就返回1，否则返回-1。如果相等的话，遍历每一个元素进行对比，如果数组1的某个键值不存在在数组2中，返回null，如果数组1的某个键的值大于数组2的这个键的值，返回1，否则返回-1。遍历的元素也都相同的情况下，最后返回0表示相等。

使用普通的比较操作符对比键值对形式的数组效果会好一些，因为是以固定的键来进行比对，不是以数组下标：

```php

var_dump(['a'=>1, 'b'=>2] == ['b'=>2, 'a'=>1]); // ture
var_dump(['a'=>1, 'b'=>2] == ['a'=>2, 'b'=>1]); // false


var_dump(['a' => 1, 'b' => 5] < ['a' => 2, 'b' => 1]); // true

```

注意第三条比较，我们的第一个数组的b元素是大于第二个数组的，但通过上面的数组比较代码可以看出，当第一个元素比较结果已经出现了大于小于的情况时，直接就return返回了结果，后面的元素不会再进行比较了。

那么多维数组呢？

```php

var_dump([['aa' => 1], ['bb' => 1, 'dd'=>2]] == [['aa' => 2], ['bb' => 1]]); // false
var_dump([['aa' => 1], ['bb' => 1, 'dd'=>2]] < [['aa' => 2], ['bb' => 1]]); // true
var_dump([['aa' => 1], ['bb' => 1, 'dd'=>2]] < [['aa' => 1, 'cc' => 1], ['bb' => 1]]); // true

```

子数组会递归进行比较，比较规则依然是按照默认的数组操作符比较方式进行。

弄清楚了数组的比较是如何进行的，那么问题来了，假设前端传给我们的数据是这样的：

```json

[
    'John',
    '178cm',
    '62kg',
]

```

而我们数据库里存的是：

```josn

[
    '62kg',
    'John',
    '178cm',
]

```

这时如果直接比对两个数组内容，或者直接用json字符串比对，他们都是不相同的，这可怎么办呢？试试自定义一个对比方法吧！

```php

function array_equal($a, $b)
{
    return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
}

$arr1 = [
    'John',
    '178cm',
    '62kg',
];
$arr2 = [
    '62kg',
    'John',
    '178cm',
];

var_dump(array_equal($arr1, $arr2)); // true

// 元素不一样的话
$arr2 = [
    '62kg',
    'John Jobs',
    '178cm',
];
var_dump(array_equal($arr1, $arr2)); // false

// 再弄乱一点
$arr1 = [
    [
        '55kg',
        'Bob',
        '172cm',
        [
            'employee',
        ],
    ],
    [
        'John',
        '178cm',
        '62kg',
        [
            'manager',
        ],
    ],
];
$arr2 = [
    [
        '62kg',
        'John',
        '178cm',
        [
            'manager',
        ],
    ],
    [
        [
            'employee',
        ],
        '55kg',
        '172cm',
        'Bob',

    ],
];
var_dump(array_equal($arr1, $arr2)); // true
```

其实就是利用了array_diff()这个函数，它的作用是取两个数组的差集，然后再对比两个数组差集的结果来判断两个数组是否相等。这个方法适用于下标数组的比对，但不适用于键值对数组的比对，array_diff()只是取值的差集结果集，不会比对键，所以对于键值对的数组直接使用比较操作符就好啦！

**对于数组的比较我们只要弄清楚它的原理就可以了，如果原理不清楚很可能就会埋下隐藏的BUG。数组的比较一定要记住这三点：**

1.**先比较元素数量**

2.**再比较每一个元素（多维数组递归比较）**

3.**先后顺序，第一个有比较结果了后面就不会继续比较了，全部都相等才会返回相等**

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201910/source/PHP%E4%B8%AD%E6%AF%94%E8%BE%83%E6%95%B0%E7%BB%84%E7%9A%84%E6%97%B6%E5%80%99%E5%8F%91%E7%94%9F%E4%BA%86%E4%BB%80%E4%B9%88%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201910/source/PHP%E4%B8%AD%E6%AF%94%E8%BE%83%E6%95%B0%E7%BB%84%E7%9A%84%E6%97%B6%E5%80%99%E5%8F%91%E7%94%9F%E4%BA%86%E4%BB%80%E4%B9%88%EF%BC%9F.php)

参考链接：[https://www.php.net/manual/zh/language.operators.comparison.php](https://www.php.net/manual/zh/language.operators.comparison.php)
