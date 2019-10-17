学过静态语言开发的朋友对类型转换不会陌生，比如Java、C#、C++等。静态语言的好处就是变量强制必须指定类型，这也是编译的要求，所以大部分编译型的语言都会有强制变量类型的要求。而PHP据说也会在PHP8中加入JIT实现编译功能，并且在7.4中就会引入变量声明时的类型指定。下面我们先看看目前PHP中的参数类型及返回值类型的使用。

```php

function add(int $a, float $b) : int{
    return (int) $a + $b;
}

```

上述代码中，方法参数中定义了参数的类型，包括一个int类型的$a和一个float类型的$b。然后在方法后面定义了方法的返回值必须是int类型。我们知道，如果计算表达式中出现了float类型，那么计算结果会变成float类型。这个方法需要返回的是一个int类型。因此我们使用了一个强制类型转换(int)。在定义了参数类型和返回值类型后，如果传递或者返回的类型不一致，就会报错。

参数类型和返回值类型最好在7以上的版本使用。基本类型如int、float等的参数类型声明都是7以后才支持的，详情参见文档：[https://www.php.net/manual/zh/functions.arguments.php](https://www.php.net/manual/zh/functions.arguments.php)

我们通过(int)、(float)、(bool)等就可以实现PHP的类型强制转换，和C基本上一样。文档中关于可以强制转换的包括如下类型：

- (int), (integer) - 转换为整形 integer
- (bool), (boolean) - 转换为布尔类型 boolean
- (float), (double), (real) - 转换为浮点型 float
- (string) - 转换为字符串 string
- (array) - 转换为数组 array
- (object) - 转换为对象 object
- (unset) - 转换为 NULL (PHP 5)
- (binary) 转换和 b 前缀转换支持为 PHP 5.2.1 新增

> (int), (integer)

- 如果是布尔值，转换结果为false变成0，true变成1
- 如果是float，向下取整，如7.99会转换为7
- 如果是字符串，字符串从头开始查找，开头第一个是数字会直接变成该转换结果，如果开头没有数字返回0
- 其他类型转换在文档中并没有定义，文档提示为“没有定义从其它类型转换为整型的行为。不要依赖任何现有的行为，因为它会未加通知地改变。”，但我们通过测试，可以发现对于其他类型的转换是通过多次的类型转换达成的，比如数组类型转换为int类型，是根据数组是否包含内容转换为bool类型后再转换为int类型

```php

// (int)(integer)

var_dump((int) true); // 1
var_dump((int) false); // 0

var_dump((int) 7.99); // 7

var_dump((int) "35 ok"); // 35
var_dump((int) "ok 77"); // 0
var_dump((int) "ok yes"); // 0

var_dump((int) []); // 0
var_dump((int) [3,4,5]); // 1

```

> (bool)(boolean)

当转换为 boolean 时，以下值被认为是 FALSE：

- 布尔值 FALSE 本身
- 整型值 0（零）
- 浮点型值 0.0（零）
- 空字符串，以及字符串 "0"
- 不包括任何元素的数组
- 特殊类型 NULL（包括尚未赋值的变量）
- 从空标记生成的 SimpleXML 对象

所有其它值都被认为是 TRUE（包括任何资源 和 NAN）

这里需要注意的是，负数也会是TRUE，只有0是FASLE

```php

// (bool)(boolean)

var_dump((bool) 0); // false
var_dump((bool) 1); // true
var_dump((bool) -1); // true

var_dump((bool) 0.0); // false
var_dump((bool) 1.1); // true
var_dump((bool) -1.1); // true

var_dump((bool) ""); // false
var_dump((bool) "0"); // false
var_dump((bool) "a"); // true

var_dump((bool) []); // false
var_dump((bool) ['a']); // true

$a;
var_dump((bool) $a); // false
var_dump((bool) NULL); // false

```

> (string)

- 布尔值，false转换为空字符串""，true转换为"1"
- int或float类型，转换为字符串形式的字面量，如1转换为"1"
- 数组和对象分别转换为"Array"和"Object"字面量
- 资源类型会被转换为"Resource id #1"形式的字面量
- NULL转换为空字符串""

直接把 array，object 或 resource 转换成 string 不会得到除了其类型之外的任何有用信息。可以使用函数 print_r() 和 var_dump() 列出这些类型的内容

注：测试结果，对象类型需要实现__tostring()魔术函数，否则报错无法转换为string类型

```php

// (string)

var_dump((string) true); // "1"
var_dump((string) false); // ""

var_dump((string) 55); // "55"
var_dump((string) 12.22); // "12.22"

var_dump((string) ['a']); // "Array"
class S{
    function __tostring(){
        return "S";
    }
}
var_dump((string) new S()); // "S"

var_dump((string) NULL); // ""

```

> (array)

对于任意 integer，float，string，boolean 和 resource 类型，如果将一个值转换为数组，将得到一个仅有一个元素的数组，其下标为 0，该元素即为此标量的值。换句话说，(array)$scalarValue 与 array($scalarValue) 完全一样

如果一个 object 类型转换为 array，则结果为一个数组，其单元为该对象的属性。键名将为成员变量名，不过有几点例外：整数属性不可访问；私有变量前会加上类名作前缀；保护变量前会加上一个 '*' 做前缀。这些前缀的前后都各有一个 NULL 字符

将 NULL 转换为 array 会得到一个空的数组

```php

// (array)

var_dump((array) 1);
var_dump((array) 2.2);

var_dump((array) "a");

var_dump((array) true);

class Arr
{
    public $a = 1;
    private $b = 2.2;
    protected $c = "f";
}
class ChildArr extends Arr
{
    public $a = 2;
    private $d = "g";
    private $e = 1;
}
var_dump((array) new Arr());
var_dump((array) new ChildArr());

var_dump((array) null);

```

> (object)

如果将一个对象转换成对象，它将不会有任何变化。如果其它任何类型的值被转换成对象，将会创建一个内置类 stdClass 的实例。如果该值为 NULL，则新的实例为空。 array 转换成 object 将使键名成为属性名并具有相对应的值

注意：使用 PHP 7.2.0 之前的版本，数字键只能通过迭代访问

```php

// (object)

var_dump((object) 1);
var_dump((object) 1.1);
var_dump((object) "string");
var_dump((object) true);
var_dump((object) NULL);

var_dump((object) [1, 2, 3]);
var_dump((object) ["a" => 1, "b" => 2, "c" => 3]);

```

> (unset)

使用 (unset) $var 将一个变量转换为 null 将不会删除该变量或 unset 其值。仅是返回 NULL 值而已

```php

// (unset)

var_dump((unset) 1);
var_dump((unset) 1.1);
var_dump((unset) "string");
var_dump((unset) true);
var_dump((unset) null);

var_dump((unset) [1, 2, 3]);
var_dump((unset) new \stdClass());

```

> (binary)

将所有类型转换为二进制字符串。二进制字符串是区别于传统常用的普通php的Unicode字符串。二进制字符串是字节字符串，没有字符集。具体的区别就类似于数据库中的binary和char类型及blob和text类型

在日常的开发中基本用不到，了解即可

```php

// (binary)

var_dump((binary) 1);
var_dump((binary) 1.1);
var_dump((binary) "string");
var_dump((binary) true);
var_dump((binary) null);

var_dump((binary) [1, 2, 3]);
var_dump((binary) new S());

```

以上就是我们的强制类型转换的所有类型，其中有一些类型的转换中提到了资源类型（Resource），但是并没有资源类型的强制转换。因为资源类型大多是一些句柄操作，如数据库链接、文件读写等，将其它类型强制转换为资源类型没有意义。

本文内容会经常出现在面试题中，而且在实际开发中的很多逻辑判断出现的BUG也常常是由于PHP的自动类型转换所导致的，所以这篇文章好好收藏多拿出来看看绝对会让你有意想不到的收获哦！！

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/language.types.type-juggling.php#language.types.typecasting](https://www.php.net/manual/zh/language.types.type-juggling.php#language.types.typecasting)
