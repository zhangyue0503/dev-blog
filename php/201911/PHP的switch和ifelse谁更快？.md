# PHP的switch和ifelse谁更快？

对于多个if条件判断的情况下，我们使用switch来代替ifelse对于代码来说会更加的清晰明了，那么他们的效率对比呢？从PHP手册中发现有人已经对比过了，自己也用他的代码进行了实验：

```php

$s = time();
for ($i = 0; $i < 1000000000; ++$i) {
    $x = $i % 10;
    if ($x == 1) {
        $y = $x * 1;
    } elseif ($x == 2) {
        $y = $x * 2;
    } elseif ($x == 3) {
        $y = $x * 3;
    } elseif ($x == 4) {
        $y = $x * 4;
    } elseif ($x == 5) {
        $y = $x * 5;
    } elseif ($x == 6) {
        $y = $x * 6;
    } elseif ($x == 7) {
        $y = $x * 7;
    } elseif ($x == 8) {
        $y = $x * 8;
    } elseif ($x == 9) {
        $y = $x * 9;
    } else {
        $y = $x * 10;
    }
}
print("if: " . (time() - $s) . "sec\n");

$s = time();
for ($i = 0; $i < 1000000000; ++$i) {
    $x = $i % 10;
    switch ($x) {
        case 1:
            $y = $x * 1;
            break;
        case 2:
            $y = $x * 2;
            break;
        case 3:
            $y = $x * 3;
            break;
        case 4:
            $y = $x * 4;
            break;
        case 5:
            $y = $x * 5;
            break;
        case 6:
            $y = $x * 6;
            break;
        case 7:
            $y = $x * 7;
            break;
        case 8:
            $y = $x * 8;
            break;
        case 9:
            $y = $x * 9;
            break;
        default:
            $y = $x * 10;
    }
}
print("switch: " . (time() - $s) . "sec\n");

```

通过1000000000次的循环并在每个判断条件中都加入了运算操作后，我们发现结果是switch的效率更高，运行速度更快，在我的电脑上的结果是：

```php

// if: 301sec
// switch: 255sec

```

虽然switch的效率更高一些，但也有需要注意的地方，首先，判断值只能是数字、浮点数或者是字符串。其次，每个判断都是普通的==判断，也就是说，下面的判断结果并不一定是你相像的结果：

```php

$string = "2string";

switch ($string) {
    case 1:
        echo "this is 1";
        break;
    case 2:
        echo "this is 2";
        break;
    case '2string':
        echo "this is a string";
        break;
}

// this is 2

```

没错，依然是==比较时的类型强转问题，string和int值比较时强转为了int类型，"2string"强转的结果正是2。因此，在使用switch的时候，应该保证比较值和每个case的类型一致，否则就可能出现不可预计的错误。另外

参考代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E7%9A%84switch%E5%92%8Cifelse%E8%B0%81%E6%9B%B4%E5%BF%AB%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E7%9A%84switch%E5%92%8Cifelse%E8%B0%81%E6%9B%B4%E5%BF%AB%EF%BC%9F.php)

参考手册：[https://www.php.net/manual/zh/control-structures.switch.php](https://www.php.net/manual/zh/control-structures.switch.php)