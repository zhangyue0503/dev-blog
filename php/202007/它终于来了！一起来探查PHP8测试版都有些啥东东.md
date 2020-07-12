# 它终于来了！一起来探查PHP8测试版都有些啥东东

其实 PHP8 的这个第一版测试版 （php-8.0.0alpha1） 在2020年6月底就已经上线了，不过也是近两天去官网的时候才看到。这个版本是第一个公开的测试版，也就是说，它是不能用于生产环境的，毕竟改动很多还不会特别的稳定。而今天，我们主要就是来看看 PHP8 带来的那些改变。

首先，我们先说说 JIT 。说着都在等 JIT ，但其实使用 JIT 还是有很多限制的，比如说它是配合 Opcache 使用的。如果你的应用并不需要开启 Opcache 的话，比如说流量很小的一些后台管理系统，这个 JIT 对你来说也并没有太大的作用。具体的 JIT 原理也就不说了，因为自己也看不懂！！所以各位大佬可以直接移步鸟哥的博客看看鸟哥对 JIT 的说明：[https://www.laruence.com/2020/06/27/5963.html](https://www.laruence.com/2020/06/27/5963.html)

接下来，主要说一些语法和函数扩展方面的变化，这些变化可能会导致你需要修改现有的项目代码才能在 PHP8 运行，当然，也有很多功能可能会为你的代码质量或者速度带来质的飞跃。（以下内容摘抄官方文档说明）。当然，并不是所有的内容都照搬翻译了一遍，有些不常用的内容就没有写在这里了，具体的内容大家可以看官方源码文档。

关于性能提升的内容在文章最后哦！！

## 核心及扩展的一些不向后兼容的修改

- 构造函数不能用和类型同名的方法来命名了，必须使用 __construct 了，这个我们之前的文章介绍过，包括现在的 PHP7 ，可以用一个与类名相同的方法名作为类的构造函数的，但在 PHP8 之后就不行了

- 强制转换 (unset) 类型没有了，估计大家也没用过

- 删除了 ini 文件中的 track_errors 指令，也就是说 $php_errormsg 全局变量没有了，使用 error_get_last() 吧

- 删除了定义常量的时候可以不区分大小写的功能，常量还是尽量大写吧

- 访问未定义的常量会报异常，不再是警告了

- 删除了 __autoload() ，乖乖使用 spl_autoload_register() 吧

- 自定义错误处理中删除了 $errcontext 参数

- 删除了 create_function() 函数，使用匿名函数来替代

- 删除了 each() 函数，使用 foreach 或者 ArrayIterator 接口来替代

- 删除了从方法创建的闭包中取消 $this 绑定 (unbind) 的功能，使用 Closure::fromCallable() 或者 ReflectionMethod::getClosure()

- 删除了从包含 $this 用法的闭包函数中解绑 $this 的能力

- 删除了使用 array_key_exists() 来获取对象的属性键是否存在的能力，使用 isset() 或者 property_exists() 来替代

- 使 array_key_exists() 关键键参数类型的判断行为与 isset() 或者普通数据的访问行为一致。所有键类型都使用默认的强制转换规则，否则抛出 TypeError

- 所有以数字 n 作为第一个数字键的数组将使用 n+1 作为下一个隐式的键，即使 n 是负数也一样

- 默认的 error_reporting 修改为 E_ALL ，之前默认值是 E_OTICE & E_DEPRECATED

- display_startup_errors 选项默认开启

- 在没有父类的类中使用 "parent" 将导致 compile-time error 编译时错误

- 错误抑制符 @ ，将不再消除 E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR, E_PARSE 这些错误，如果希望使用 @ 报错后进入的错误处理函数对于上面的这些错误信息依然返回 0 ，可以使用掩码处理

```php
// Replace
function my_error_handler($err_no, $err_msg, $filename, $linenum) {
    if (error_reporting() == 0) {
        return; // Silenced
    }
    // ...
}

// With
function my_error_handler($err_no, $err_msg, $filename, $linenum) {
    if (!(error_reporting() & $err_no)) {
        return; // Silenced
    }
    // ...
}
```

- 由于不兼容的方法签名导致的继承错误将始终生成致命错误，之前在某些情况下是警告

- 串联运算符 （连接字符串那个 . ） 的优先级相对于位移、加法和减法发生了变化

- 在运行时解析为 null 的默认参数将不再隐式地将参数类型标记为可为 null 。要么使用显式的可为 null 的类型，要么改为用显式 null 默认值

```php
// Replace
function test(int $arg = CONST_RESOLVING_TO_NULL) {}
// With
function test(?int $arg = CONST_RESOLVING_TO_NULL) {}
// Or
function test(int $arg = null) {}
```

- 许多警告转换成了异常：
    * 给非对象写入属性
    * 将元素追加到 PHP_INT_MAX 键的数组中
    * 将无效类型（数组或䭴）用作数组键或字符串偏移量
    * 写入标量值的数组索引
    * 解压缩不可遍历的数组

- 许多通知转换成了警告：
    * 读取未定义的变量、属性、非对象的属性、非数组的索引 
    * 将数组转换为字符串
    * 将资源作为数组键
    * 使用 null 、 boolean 或 float 作为字符串偏移量
    * 读取越界字符串
    * 将空字符串分配给字符串偏移量

- 将字符串偏移量分配给多个字节产生警告

- 源文件中的意外字符（如字符串外的空字节）将导致 ParseError 异常

- 未捕获的异常要经过 "clear shutdown" ，意味着将在未捕获异常之后进行析构

- 编译时的致命错误 "Only variables can be passed by reference" 延迟到运行时，并转换为 "Cannot pass parameter by reference" 的错误异常

- 一些 "Only variables should be passed by reference" 相关的警告转换为 "Cannot pass parameter by reference" 错误异常

- 匿名类的生成名称已更改。它现在将包括第一个父级或接口的名称

```php
new class extends ParentClass {};
// -> ParentClass@anonymous
new class implements FirstInterface, SecondInterface {};
// -> FirstInterface@anonymous
new class {};
// -> class@anonymous
```

- 不推荐在可选参数之后声明必须参数。作为一个例外，允许在居委会参数之前声明 "Type $param = null" 这种形式的参数，因为在旧的 PHP 版本中，此模式有时用于实现可以为 null 的类型

```php
function test($a = [], $b) {}       // Deprecated
function test(Foo $a = null, $b) {} // Allowed
```

- trait 中的别名引用必须要明确。下面例子在之前的版本中是会调用 T1::func() ，但在 PHP8 中会产生致命错误，需要显式地写明引用哪一个 trait 的 func()

```php
class X {
    use T1, T2 {
        func as otherFunc;
    }
    function func() {}
}
```

- trait 中定义的抽象方法的参数签名会对照实现类中的方法进行检查（必须保持一致）

```php
trait MyTrait {
    abstract private function neededByTrait(): string;
}

class MyClass {
    use MyTrait;

    // Error, because of return type mismatch.
    private function neededByTrait(): int { return 42; }
}
```

- 被 ini 中的 disable_functions 禁用的函数将被视为不存在的函数，并且可以自己定义去实现这些被禁用的函数了

- 关于数据的流包装器将不再是可写的了

- 算术和位运算符不能操作数组、资源或非重载对象了，会抛出 TypeError ，除了数组的合并操作，如 $array1 + $array2 ，它将保留原来的操作方式

- 浮点数到字符串的转换将始终独立于区域设置

- 删除了对不推荐使用的大括号进行偏移访问的支持，如 $arr{1}

---

- mktime() 和gmmktime() 至少需要一个参数了

- 从ext/dom中删除没有行为且包含测试数据的一些未实现类：DOMNameList、DomImplementationList、DOMConfiguration、DomError、DomErrorHandler、DOMImplementationSource、DOMLocator、DOMUserDataHandler、DOMTypeInfo

- Exif 扩展删除了 read_exif_data() 函数，使用 exif_read_data() 函数来替代

- GD 扩展使用对象作为图像的底层数据结构，而不是资源句柄了，这些对象不透明，也就是它们没有任何方法

- image2wbmp() 、 png2wbmp() 函数移除

- imagecropauto() 的默认 $mode 参数不再接受 -1 ，应改用 IMG_CROP_DEFAULT

- 不再支持在出现错误时未正确设置 errno 的 iconv() 的实现

- 如果不指定结果数组，则无法再使用 mb_parse_str()

- MB 扩展中许多不推荐使用的mbregex别名已被删除：
     * mbregex_encoding()      -> mb_regex_encoding()
     * mbereg()                -> mb_ereg()
     * mberegi()               -> mb_eregi()
     * mbereg_replace()        -> mb_ereg_replace()
     * mberegi_replace()       -> mb_eregi_replace()
     * mbsplit()               -> mb_split()
     * mbereg_match()          -> mb_ereg_match()
     * mbereg_search()         -> mb_ereg_search()
     * mbereg_search_pos()     -> mb_ereg_search_pos()
     * mbereg_search_regs()    -> mb_ereg_search_regs()
     * mbereg_search_init()    -> mb_ereg_search_init()
     * mbereg_search_getregs() -> mb_ereg_search_getregs()
     * mbereg_search_getpos()  -> mb_ereg_search_getpos()
     * mbereg_search_setpos()  -> mb_ereg_search_setpos()

- 'e' 格式写法从 mb_ereg_replace() 中移除，使用 mb_ereg_replace_callback() 代替

- 带查找值 (needle) 的函数参数可以为空，mb_strpos(), mb_strrpos(), mb_stripos(), mb_strripos(), mb_strstr(), mb_stristr(), mb_strrchr(), mb_strrichr()

- 将编码作为第三个参数而不是函数的偏移量传递的传统行为已被删除，请提供显式的0偏移量，而将编码作为第四个参数，如 mb_starpos()

- PDO 默认的错误处理已经改为异常

- Reflection 反射类的一些函数参数改变为支持多参数

- Reflection 的 export() 方法被移除

- Reflection 的 __toString() 方法将返回该类型的完事调试表示形式，不再被弃用。这个功能可能在 PHP 版本之间会发生变化

- Reflection 的 isConstructor() 和 isDestructor() 也可以应用于接口了，之前只适用于类或 trait

- SplFileObject::fgetss() 被移除

- SplHeap::compare($a, $b) 指定了一个方法签名，继承实现的类必须使用兼容的方法签名

- SplDoublyLinkedList::push() 、SplDoublyLinkedList::unshift() 、SplDoublyLinkedList::enqueue() 现在返回 void 代替之前的 true

- spl_autoload_register() 现在始终对无效参数抛出 TypeError ，之前第二个参数将被忽略，如果设置为 false ，则会发出通知

- asset() 不再计算字符串参数，如 assert('$a==$b')，应该使用 assert($a == $b)

- 不指定数组的话将无法使用 parse_str() ，fgetss() 被移除

- string.strip_tags 过滤器语法被移除

- 带查找值 (needle) 的函数参数可以为空，strpos(), strrpos(), stripos(), strripos(), strstr(), strchr(), strrchr(), stristr()，并且始终被解释为字符串

- 带长度参数的字符串函数可以为空，substr(), substr_count(), substr_compare(), iconv_substr()

- array_splice() 的长度偏移量参数可以为空

- vsprintf()、vfprintf() 和 vprintf() 的args参数现在必须是数组。以前接受任何类型

- password_hash() 的 "salt" 选项不再支持，如果使用会产生警告

- hebrevc() 、 convert_cyr_string() 、 money_format() 、 ezmlm_hash() 、 restore_include_path() 、 get_magic_quotes_gpc() 、 get_magic_quotes_gpc_runtime() 、 FILTER_SANITIZE_MAGIC_QUOTES 被移除

- 不再支持使用相反顺序的参数调用 implode()

- parse_url() 现在将区分不存在和空的查询和片段：

```php
http://example.com/foo   => query = null, fragment = null
http://example.com/foo?  => query = "",   fragment = null
http://example.com/foo#  => query = null, fragment = ""
http://example.com/foo?# => query = "",   fragment = ""
```

- var_dump() 和 debug_zval_dump() 将使用序列化后的精度来打印浮点数字，也就是使用它们打印的浮点数字是正确的

- 如果使用 __sleep() 操作序列化返回的数组包含不存在的属性，则这些属性被自动忽略，之前它们也将被序列化

- CURL 的 curl_init() 返回 CurlHandle 对象，curl_multi_init() 和 curl_share_init() 也都是返回对应的句柄对象

- JSON 扩展内化为固定内部扩展，无法被禁用，就像日期扩展一样


## 新特性

- 联合类型：参数类型可以这么写 int|float|string 

- WeakMap 弱引用：写过这方面的文章 []()

- 值错误类：ValueError class

- 只要类型兼容，任何数量的函数参数现在都可以替换为可变参数

- 可以使用 return 返回静态类型对象

- 可以使用 “$object::class” 获取对象的类名。结果与 “get_class（$object）” 相同

- new 和 instanceof 可以与任意表达式一起使用，使用 "new（expression）(…$args)" 和 "$obj instanceof (expression)"

- 修复了一些变量就去，如：Foo::BAR::$baz

- 添加了 Stringable 接口，如果类定义了一个 __toString() 方法，则会自动实现该接口

- traits 可以定义抽象的私有方法

- "throw" 可以用于表达式

- 参数列表中现在允许使用可选的尾随逗号

- 可以编写 "catch (Exception)" 来捕获异常，而不用将它存储到变量中

- 支持混合类型：mixed 类型，比联合类型更宽泛

- 增加支持 "属性" 标签，也就是 Java 中的注解能力（划重点）

- 增加了对构造函数属性提升的支持（在构造函数签名中声明属性）

- 增加 get_resource_id() 获取句柄 id

- 增加 DateTime::createFromInterface() 和 DateTimeImmutable::createFromInterface()

- 增加 str_contains() 、 str_starts_with() 、 str_ends_with() 、 fdiv()、 get_debug_type() 函数

## 性能改进

- JNI ，大家最关心的，在 Opcache 扩展中体现

- array_slice() 将不在扫描整个数组以找到起始偏移量

- strtolower() 使用 SIMD 实现，使用 C 语言的 LC_CTYPE 区域设置

## 总结

这些就是 PHP8 带给我们的惊喜了。可以看出，这次的大改版修改或移除了很多函数，也对不少的核心扩展进行了升级。当然，大家最关心的还是 JIT 的引进会对我们的性能产生怎样的影响，不过除了 JIT 之外，我认为注解能力的引入也是一大亮点。鸟哥在最近更新的关于 PHP8 的文章中，也首先就提到了这两个能力。大家可以在下面的链接中查看原鸟哥讲解的原文。另外，在 CPU 应用脚本的基准测试中，JIT 能力的效率是 PHP5 的 41 倍以上，鸟哥在文章中也做过了这方面的测试。所以说，期待正式版吧，看看丢到服务器上的 PHP8 能为我们带来多少的性能提升。

[https://www.laruence.com/category/php8](https://www.laruence.com/category/php8)



参考文档：

[https://github.com/php/php-src/blob/php-8.0.0alpha1/UPGRADING](https://github.com/php/php-src/blob/php-8.0.0alpha1/UPGRADING)