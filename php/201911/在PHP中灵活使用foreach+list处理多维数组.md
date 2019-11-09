# 在PHP中灵活使用foreach+list处理多维数组

先抛出问题，有时候我们接收到的参数是多维数组，我们需要将他们转成普通的数组，比如：

```php

$arr = [
    [1, 2, [3, 4]],
    [5, 6, [7, 8]],
];

```

我们需要的结果是元素1变成1,2,3,4，元素2变成5,6,7,8，这时候，我们就可以用foreach配合list来实现，而且非常简单：

```php

foreach ($arr as list($a, $b, list($c, $d))) {
    echo $a, ',', $b, ',', $c, ',', $d, PHP_EOL;
}

```

是不是非常的简单。但是要注意哦，list拆解键值对形式的Hash数组时要指定键名，并且只有在7.1以后的版本才可以使用哦

```php

$arr = [
    ["a" => 1, "b" => 2],
    ["a" => 3, "b" => 4],
];

foreach ($arr as list("a" => $a, "b" => $b)) {
    echo $a, ',', $b, PHP_EOL;
}

foreach ($arr as ["a" => $a, "b" => $b]) {
    echo $a, ',', $b, PHP_EOL;
}

```

注意：如果没有写键名，会输出空而不会报错，这是个BUG点，千万要注意。

上述代码中第二个写法更简单直观，由此发现我们还可以这样来拆解数组。并且指定键值了就不用在乎他们的顺序了：

```php

["b" => $b, "a" => $a] = $arr[0];
echo $a, ',', $b, PHP_EOL;

```

原来list()还有这样的语法糖，果然还是要不断的学习，一直使用却从未深入了解过的方法竟然能有这么多的用处。不多说了，接着研究手册中其他好玩的东西去咯！

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/%E5%9C%A8PHP%E4%B8%AD%E7%81%B5%E6%B4%BB%E4%BD%BF%E7%94%A8foreach%2Blist%E5%A4%84%E7%90%86%E5%A4%9A%E7%BB%B4%E6%95%B0%E7%BB%84.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/%E5%9C%A8PHP%E4%B8%AD%E7%81%B5%E6%B4%BB%E4%BD%BF%E7%94%A8foreach%2Blist%E5%A4%84%E7%90%86%E5%A4%9A%E7%BB%B4%E6%95%B0%E7%BB%84.php)
