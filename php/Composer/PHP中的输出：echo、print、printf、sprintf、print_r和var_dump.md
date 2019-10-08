大家在面试中，经常会被问到的问题：

> 请简要说明PHP的打印方式都有哪些？

或者直接点问：

> 请说明echo、print、print_r的区别

看着很简单，一般会出现在初中级的笔试题中。但是要真正说明白这些语言结构或者函数也不是那么简单的事情。今天我们就来好好看看这些打印输出相关的内容。

## echo

最基础的输出语句，不是函数是语言结构，不需要括号。可以使用参数列表，用逗号分隔。但如果加了括号就不能用逗号分隔着输出了。没有返回值。

```php 
echo 'fullstackpm'; // 正常输出：fullstackpm
echo 'fullstackpm', ' is ', 'Good!'; // 正常输出：fullstackpm is Good!
echo ('fullstackpm'); // 正常输出：fullstackpm
echo ('fullstackpm', ' is ', 'Good!'); // 报错了
```

## print

基本和echo一样，但是不支持参数列表，有返回值。返回值永远是1。

***因为有返回值，所以相对来说效率不如echo***

```php 
print 'fullstackpm'; // 正常输出：fullstackpm
print 'fullstackpm', ' is ', 'Good!'; // 错误
$r = print ('fullstackpm'); // 正常输出：fullstackpm
print $r; // 输出1
```

## printf和sprintf

两个很高大上的函数，可以格式化输出字符串。用%标明占位符，后面的参数对应进行占位符的替换。printf和sprintf的区别就是前者直接进行了输出，而后者是将字符串进行了函数返回。请看实例。

```php 
$str = 'My name is %s, I\'m %d years old.';
printf($str, 'fullstackpm', 1002); // 直接输出：My name is fullstackpm, I'm 1002 years old.

$s = sprintf($str, 'WoW', 12); // 这里不会输出
print $s; // 输出：My name is WoW, I'm 12 years old.
```

你最少要记住的，%s代表字符串，%d代表数字，%f是浮点数，%%是输出%本身，其他还有许多类型可以查看相关文档。另外还有类似的几个：
- vprintf，他的第二个参数是一个数组，不是可变长度的参数。
- sscanf，对于一些特殊字符处理方式不同。
- fscanf，从文档中读取并进行格式化。

## print\_r

非常常用的一个函数，可以格式化的输出数组或对象。注意第二个参数设置为true，可以不直接输出而是进行函数返回。

```php
$str = [
    "a",
    1 => "b",
    "3" => "c",
    "show"=>'d'
];

print_r($str)
// 输出
/**
    Array
    (
        [0] => a
        [1] => b
        [3] => c
        [show] => d
    )
*/

$s = print_r($str, true); // 此处不会输出
echo $s;
// 输出
// 注意，输出流不在ob_start()中，测试本段请不要有其他任何输出
/**
    Array
    (
        [0] => a
        [1] => b
        [3] => c
        [show] => d
    )
*/
```

## var\_dump和var\_exports

var\_dump也是非常常用的一个函数，用来显示结构信息，包括类型与值，数组对象都会展开，用缩进表示层次。var\_exports与之不同的地方在于var\_exports返回的内容是正常的PHP代码，可以直接使用，并且有和print\_r类似的第二个return参数，作用也类似。

```php
$str = [
    "a",
    1 => "b",
    "3" => "c",
    "show"=>'d'
];

var_dump($str);
// 输出
/**
    array(4) {
      [0] =>
      string(1) "a"
      [1] =>
      string(1) "b"
      [3] =>
      string(1) "c"
      'show' =>
      string(1) "d"
    }
*/

var_export($str);
// 输出
/**
    array (
      0 => 'a',
      1 => 'b',
      3 => 'c',
      'show' => 'd',
    )
*/
```