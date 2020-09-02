# PHP中的数组分页实现（非数据库）

在日常开发的业务环境中，我们一般都会使用 MySQL 语句来实现分页的功能。但是，往往也有些数据并不多，或者只是获取 PHP 中定义的一些数组数据时需要分页的功能，这时，我们其实不需要每次都去查询数据库，可以在一次查询中把所有的数据取出来，然后在 PHP 的代码层面进行分页功能的实现。今天，我们就来学习一下可以实现这个能力的一些函数技巧。

首先，我们还是准备好测试数据。

```php
$data = [
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
];

// $p = $_GET['p'];
$p = 2;
$currentPage = $p <= 1 ? 0 : $p - 1;
$pageSize = 3;
$offset = $currentPage * $pageSize;
```

假设 $data 就是从数据库中取出的全部数据，或者就是我们写死在 PHP 代码中的数据。然后我们设定 $p 为接收到的请求参数，当前访问的是第二页。$currentPage 是用于查询偏移量的修正，在代码开发的世界中，下标索引都是从0开始的，所以我们需要对接收到的参数进行减一的操作。当然，你也可以设定前端传递的参数就是以 0 为第一页的。这个就不多解释了，相信大家只要正式的学习或者参与过开发项目都会明白它的意思。

然后我们定义了当前页面所显示的信息条数 $pageSize ，也就是只获取 3 条数据。最后，我们计算了一下偏移量，也就是类似于 MySQL 的 LIMIT 中的那个参数。它的作用就是告诉我们从第几条开始查询，然后配合 $pageSize 查询几条。这样我们就可以获得当前页面对应的数据了。（貌似把分页的原理都讲了一下）

## array_slice

第一个也是最基础和最常见的分页方式，就是使用 array_slice() 函数来实现。它的作用是从数组中截取出一段内容来并返回这段内容的数组。

```php
var_dump(array_slice($data, $offset, $pageSize));
// array(3) {
//     [0]=>
//     string(1) "D"
//     [1]=>
//     string(1) "E"
//     [2]=>
//     string(1) "F"
//   }
```

array_slice() 函数需要三个参数，第二个参数就是偏移量，第三个参数是查询几条数据。其中，第三个参数是可选的，不填的话就会把当前设定的偏移量之后的数据全部显示出来。是不是和我们的 MySQL 查询语句一模一样。没错，他们本身就是类似的操作。

## array_chunk

array_chunk() 函数则是根据一个数值参数将一个数组进行分组，也就是将数组分割成一段一段的子数组。我们就可以根据分割后的数组来获取指定下标的子数组内容，这些内容就是当前的页面需要展示的数据了。

```php
$pages = array_chunk($data, $pageSize);
var_dump($pages);
// array(4) {
//     [0]=>
//     array(3) {
//       [0]=>
//       string(1) "A"
//       [1]=>
//       string(1) "B"
//       [2]=>
//       string(1) "C"
//     }
//     [1]=>
//     array(3) {
//       [0]=>
//       string(1) "D"
//       [1]=>
//       string(1) "E"
//       [2]=>
//       string(1) "F"
//     }
//     [2]=>
//     array(3) {
//       [0]=>
//       string(1) "G"
//       [1]=>
//       string(1) "H"
//       [2]=>
//       string(1) "I"
//     }
//     [3]=>
//     array(2) {
//       [0]=>
//       string(1) "J"
//       [1]=>
//       string(1) "K"
//     }
//   }

var_dump($pages[$currentPage]);
// array(3) {
//     [0]=>
//     string(1) "A"
//     [1]=>
//     string(1) "B"
//     [2]=>
//     string(1) "C"
//   }
```

这段代码我们输出了分割后的数组内容，然后需要的是第二页也就是下标为 1 的数据，直接通过分割后的数组就可以方便地获取到所需要的内容了。使用这个函数来做数组分页的功能非常地简单直观，而且它不需要去计算偏移量，直接就是使用当前页 $currentPage 和 $pageSize 就可以完成对于数据的分组了，非常推荐大家使用这个函数来进行类似的操作。

## LimitIterator

最后我们要学习到的是使用一个迭代器类来实现数组分页的能力，这个使用的就比较少了，估计都没什么人知道，但其实 LimitIterator 类在 PHP5.1 时就已经提供了。它的作用是允许遍历一个 Iterator 的限定子集的元素。也就是说，如果我们的代码中使用了迭代器模式，实现了迭代器接口，那么这些迭代器类都可以使用这个类进行分页操作。

```php
foreach (new LimitIterator(new ArrayIterator($data), $offset, $pageSize) as $d) {
    var_dump($d);
}
// string(1) "D"
// string(1) "E"
// string(1) "F"
```

它需要的实例化构造参数包含3个，第一个是一个迭代器对象，由于数组不是迭代器对象，所以我们使用 ArrayIterator 实例将我们的数组数据转化为一个迭代器对象。后面两个参数就是偏移量和数据数量了，这个和 array_slice() 函数是类似的，不过不同的是，它的偏移量参数也是可以选的。如果我们不给后面的可选参数的话，那么它将遍历所有的数据。

```php
foreach (new LimitIterator(new ArrayIterator($data)) as $d) {
    var_dump($d);
}
// string(1) "A"
// string(1) "B"
// string(1) "C"
// string(1) "D"
// string(1) "E"
// string(1) "F"
// string(1) "G"
// string(1) "H"
// string(1) "I"
// string(1) "J"
// string(1) "K"
```

## 参数错误时的表现

接下来，我们看看如果参数错误，也就是偏移量或者所需的数据量大小有问题的话，这些操作将会有什么样的表现。

```php
var_dump(array_slice($data, $offset, 150));
// array(8) {
//     [0]=>
//     string(1) "D"
//     [1]=>
//     string(1) "E"
//     [2]=>
//     string(1) "F"
//     [3]=>
//     string(1) "G"
//     [4]=>
//     string(1) "H"
//     [5]=>
//     string(1) "I"
//     [6]=>
//     string(1) "J"
//     [7]=>
//     string(1) "K"
//   }
var_dump(array_slice($data, 15, $pageSize));
// array(0) {
// }
```

array_slice() 函数对于偏移量错误的兼容就是展示一个空的数组。而数据量超标的话则会展示所有偏移量之后的数据。

```php
var_dump($pages[15]);
// NULL
```

array_chunk() 对于下标不存在的数据当然就是返回一个 NULL 值啦。

```php
foreach (new LimitIterator(new ArrayIterator($data), $offset, 150) as $d) {
    var_dump($d);
}
// string(1) "D"
// string(1) "E"
// string(1) "F"
// string(1) "G"
// string(1) "H"
// string(1) "I"
// string(1) "J"
// string(1) "K"

foreach (new LimitIterator(new ArrayIterator($data), 15, $pageSize) as $d) {
    var_dump($d);
}
// Fatal error: Uncaught OutOfBoundsException: Seek position 15 is out of range
```

LimitIterator 则是对于偏移量错误的数据直接返回错误异常信息了。这也是类模式处理的好处，有错误都会以异常的形式进行返回，方便我们对异常进行后续的处理。

其它的测试大家还可以自行检测，比如偏移是 0 或者是负数的情况，数据量是 0 或者是负数的情况。这些我就不多写了，大家可以根据已有的知识先猜想一下结果会是什么样的，然后再自己写代码验证一下结果是符合自己的预期，这样学习的效果会非常高哦！（在下方测试代码链接中有测试，结果里面是有坑的哦）

## 总结

一个功能使用了三种方式来实现，这就是代码的魅力。至于哪个好哪个坏我们不多做评价，一切都是以业务为核心来进行选取。类似的功能虽说并不常见，但很多项目里都会遇到，比如说后台用户组管理就会非常常见，一般来说后台用户分组如果不是特别大型的 ERP 项目都不会很多，但有时候也会达到需要分页的程度，这时候，我们就可以考虑考虑使用今天所学的知识来做咯！

测试代码：

参考文档：

[https://www.php.net/manual/zh/function.array-slice.php](https://www.php.net/manual/zh/function.array-slice.php)

[https://www.php.net/manual/zh/function.array-chunk.php](https://www.php.net/manual/zh/function.array-chunk.php)

[https://www.php.net/limititerator](https://www.php.net/limititerator)