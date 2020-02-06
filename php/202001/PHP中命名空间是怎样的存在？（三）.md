# PHP中命名空间是怎样的存在？（三）

这是与命名空间有关的最后一篇。最后还是两个比较简单的内容，是关于命名空间和全局相关的一些类、函数、常量的使用对比。当然，最后我们还会总结一下命名空间的名称解析规则做为这三篇系列文章的结束。

## 全局空间

当文件中定义了命名空间，也就是namesapce指定了当前的命名空间后，在调用全局类、函数、常量时，需要添加一个“\”，也就是完全限定访问符号来标明这个类、函数、常量是全局的那个，而不是当前命名空间中的。特别是当前命名空间中包含与全局类、函数、常量同名的内容时。

```php
namespace FILE6;

function show()
{
    echo strtoupper('aaa'), PHP_EOL; // 调用自己的
    echo \strtoupper('aaa'), PHP_EOL; // 调用全局的
}

function strtoupper($str)
{
    return __NAMESPACE__ . '：' . \strtoupper($str);
}

```

在这个FILE6命名空间中，我们定义了一个strtoupper()方法。之间说过，命名空间就是为了解决同名问题而出现的，这个方法和全局php自带的那个方法是完全相同的名称的。所以，在调用的时候我们需要调用的是哪个方法。那么如果当前命名空间中没有定义这个方法呢？别急，接下来的内容就是讲这个问题。

## 后备全局函数/常量

从上个例子中，我们就可以看全局完全限定访问符的作用，当没有使用全局符时，strtoupper()方法会先调用当前命名空间下的方法。那么后备的作用就是如果当前命名空间中没有找到时，会去全局找相关的函数。在文档中的定义是这样的：

当 PHP 遇到一个非限定的类、函数或常量名称时，它使用不同的优先策略来解析该名称。类名称总是解析到当前命名空间中的名称。因此在访问系统内部或不包含在命名空间中的类名称时，必须使用完全限定名称。对于函数和常量来说，如果当前命名空间中不存在该函数或常量，PHP 会退而使用全局空间中的函数或常量。

意思也就是说，函数和常量，会有后备去全局查找的能力。但是类不行！！如果要使用全局类，一定要加全局完全限定符。我们通过一个例子来看：

```php
namespace FILE7;

// 类必须使用完全限定的全局空间
$o1 = new \stdClass();
// $o2 = new stdClass(); // Fatal error: Uncaught Error: Class 'FILE7\stdClass' not found

// 方法会先在本命名空间查找，如果没找到会去全局找
function strlen($str)
{
    return __NAMESPACE__ . '：' . (\strlen($str) - 1);
}
echo strlen('abc'), PHP_EOL; // FILE7：2 ，当前命名空间
echo \strlen('abc'), PHP_EOL; // 3 ， 全局

echo strtoupper('abc'), PHP_EOL; // ABC， 全局

// 常量也是有后备能力的

const E_ERROR = 22; 
echo E_ERROR, PHP_EOL; // 22， 当前命名空间
echo \E_ERROR, PHP_EOL; // 1， 全局

echo INI_ALL, PHP_EOL; // 7， 全局
```

## 名称解析规则

1. 对完全限定名称的函数，类和常量的调用在编译时解析。例如 new \A\B 解析为类 A\B。
2. 所有的非限定名称和限定名称（非完全限定名称）根据当前的导入规则在编译时进行转换。例如，如果命名空间 A\B\C 被导入为 C，那么对 C\D\e() 的调用就会被转换为 A\B\C\D\e()。
3. 在命名空间内部，所有的没有根据导入规则转换的限定名称均会在其前面加上当前的命名空间名称。例如，在命名空间 A\B 内部调用 C\D\e()，则 C\D\e() 会被转换为 A\B\C\D\e() 。
4. 非限定类名根据当前的导入规则在编译时转换（用全名代替短的导入名称）。例如，如果命名空间 A\B\C 导入为C，则 new C() 被转换为 new A\B\C() 。
5. 在命名空间内部（例如A\B），对非限定名称的函数调用是在运行时解析的。例如对函数 foo() 的调用是这样解析的：
    - 在当前命名空间中查找名为 A\B\foo() 的函数
    - 尝试查找并调用 全局(global) 空间中的函数 foo()。
6. 在命名空间（例如A\B）内部对非限定名称或限定名称类（非完全限定名称）的调用是在运行时解析的。下面是调用 new C() 及 new D\E() 的解析过程： new C()的解析:
    - 在当前命名空间中查找A\B\C类。
    - 尝试自动装载类A\B\C。

new D\E()的解析:
1. 在类名称前面加上当前命名空间名称变成：A\B\D\E，然后查找该类。
2. 尝试自动装载类 A\B\D\E。

为了引用全局命名空间中的全局类，必须使用完全限定名称 new \C()。

测试代码：


参考文档：
[https://www.php.net/manual/zh/language.namespaces.global.php](https://www.php.net/manual/zh/language.namespaces.global.php)
[https://www.php.net/manual/zh/language.namespaces.fallback.php](https://www.php.net/manual/zh/language.namespaces.fallback.php)
[https://www.php.net/manual/zh/language.namespaces.rules.php](https://www.php.net/manual/zh/language.namespaces.rules.php)
