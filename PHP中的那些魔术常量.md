之前我们已经了解了一些常用的魔术方法，除了魔术方法外，PHP还提供一些魔术常量，相信大家在日常的工作中也都使用过，这里给大家做一个总结。

其实PHP还提供了很多常量但都依赖于各类扩展库，而有几个常量是通用并且是跟随它们所在代码的位置来提供一些与位置有关的信息，这些就是***魔术常量***。魔术常量是不分大小写的，\_\_LINE\_\_和\_\_line\_\_是一样的，但对于工程化的开发来说，常量还是尽量以大写为主。

> **\_\_LINE\_\_**

文件中的当前行号。

```php
echo __LINE__ . PHP_EOL; // 3

function testLine()
{
    echo __LINE__ . PHP_EOL; // 7
}

class TestLineClass
{
    function testLine()
    {
        echo __LINE__ . PHP_EOL; // 14
    }
}

testLine();
$test = new TestLineClass();
$test->testLine();
```

> **\_\_FILE\_\_**

文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，\_\_FILE\_\_ 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。

```php
echo __FILE__ . PHP_EOL; // D:\phpproject\php\newblog\php-magic-constant.php
```

> **\_\_DIR\_\_**

文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(\_\_FILE\_\_)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =

```php
echo __DIR__ . PHP_EOL; // D:\phpproject\php\newblog
```

> **\_\_FUNCTION\_\_**

函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。

```php
echo __FUNCTION__ . PHP_EOL; // 啥都没输出
function testFunction()
{
    echo __FUNCTION__ . PHP_EOL; // testFunction
}

class TestFunctionClass
{
    function testFunction1()
    {
        echo __FUNCTION__ . PHP_EOL; // testFunction1
    }
}

testFunction();
$test = new TestFunctionClass();
$test->testFunction1();
```

> **\_\_CLASS\_\_**

类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 Foo\Bar）。注意自 PHP 5.4 起 \_\_CLASS\_\_ 对 trait 也起作用。当用在 trait 方法中时，\_\_CLASS\_\_ 是调用 trait 方法的类的名字。

```php
echo __CLASS__ . PHP_EOL; // 什么也没有
function testClass()
{
    echo __CLASS__ . PHP_EOL; // 什么也没有
}

trait TestClassTrait
{
    function testClass2()
    {
        echo __CLASS__ . PHP_EOL; // TestClassClass
    }
}

class TestClassClass
{
    use TestClassTrait;

    function testClass1()
    {
        echo __CLASS__ . PHP_EOL; // TestClassClass
    }
}

testClass();
$test = new TestClassClass();
$test->testClass1();
$test->testClass2();
```

> **\_\_TRAIT\_\_**

Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 Foo\Bar）。

```php
echo __TRAIT__ . PHP_EOL; // 什么也没有
function testTrait()
{
    echo __TRAIT__ . PHP_EOL; // 什么也没有
}

trait TestTrait
{
    function testTrait2()
    {
        echo __TRAIT__ . PHP_EOL; // TestTrait
    }
}

class TestTraitClass
{
    use TestTrait;

    function testTrait1()
    {
        echo __TRAIT__ . PHP_EOL; // 什么也没有
    }
}

testTrait();
$test = new TestTraitClass();
$test->testTrait1();
$test->testTrait2();
```

> **\_\_METHOD\_\_**

类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。

```php
echo __METHOD__ . PHP_EOL; // 什么也没有
function testMethod()
{
    echo __METHOD__ . PHP_EOL; // testMethod
}

class TestMethodClass
{
    function testMethod1()
    {
        echo __METHOD__ . PHP_EOL; // TestMethodClass::testMethod1
    }
}

testMethod();
$test = new TestMethodClass();
$test->testMethod1();
```

> **\_\_NAMESPACE\_\_**

当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）。

```php
echo __NAMESPACE__ . PHP_EOL; // test\magic\constant
class TestNameSpaceClass
{
    function testNamespace()
    {
        echo __NAMESPACE__ . PHP_EOL; // test\magic\constant
    }
}

$test = new TestNameSpaceClass();
$test->testNamespace();
```

完整代码：[https://github.com/zhangyue0503/php/blob/master/newblog/php-magic-constant.php](https://github.com/zhangyue0503/php/blob/master/newblog/php-magic-constant.php)