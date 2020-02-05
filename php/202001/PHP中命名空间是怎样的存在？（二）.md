# PHP中命名空间是怎样的存在？（二）

今天带来的依然是命名空间相关的内容，本身命名空间就是PHP中非常重要的一个特性。所以关于它的各种操作和使用还是非常复杂的，光使用方式就有很多种，我们一个一个的来看。

## 子命名空间

命名空间本身就像目录一样，所以命名空间当然也是可以定义子命名空间的，真的就和操作系统的各种目录层级是完全一样的。我们通过简单的例子来看看。首先还是创建三个php文件，其中3-2和3-2-1是使用的相同的二级命名空间，3-2-1在FILE32的基础上继续向下扩展了第三级的命名空间FILE321。他们都是MyProject命名空间的子命名空间。

```php
// file3-1.php

namespace MyProject\FILE31;

function testA31(){
    echo 'FILE31\testA()', PHP_EOL;
}


// file3-2.php
namespace MyProject\FILE32;

const CONST_A32 = "file3-2";
function testA32(){
    echo 'FILE32\testA()', PHP_EOL;
}

class objectA32{
    function test(){
        echo 'FILE32\ObjectA', PHP_EOL;
    }
}

// file3-2-1.php

namespace MyProject\FILE32\FILE321;

function testA321(){
    echo 'FILE321\testA()', PHP_EOL;
}
```

接下来的使用就很简单了，和使用一级命名空间一样，直接使用use进行导入就可以了。

```php
// 子命名空间
require 'namespace/file3-1.php';
require 'namespace/file3-2.php';
require 'namespace/file3-2-1.php';

use MyProject\FILE31;
use MyProject\FILE32;
use MyProject\FILE32\FILE321;

FILE31\testA31(); // FILE31\testA()
FILE32\testA32(); // FILE32\testA()
FILE32\FILE321\testA321(); // FILE321\testA()
FILE321\testA321(); // FILE321\testA()

```

## 同一文件中定义多个命名空间

PHP是允许在一个文件中定义多个命名空间的，但是并不推荐这么做，因为这样可能会带来各种未知的混乱。在这里，我们只要了解到可以这样使用就行了，在日常的开发中还是尽量要避免。

```php
// file4.php
namespace FILE41;

function testA41(){
    echo 'FILE41\testA()', PHP_EOL;
}

namespace FILE42;

function testA42(){
    echo 'FILE42\testA()', PHP_EOL;
}
```

在使用中当然也和其他命名空间的使用没什么两样，直接use使用即可。

```php
// 一个文件中多个命名空间
require 'namespace/file4.php';

use FILE41, FILE42;

FILE41\testA41(); // FILE41\testA()
FILE42\testA42(); // FILE42\testA()
```

## 非限定名称、限定名称、完全限定名称

不要被术语吓到，这三个术语其实非常好理解。

- 非限定名称，名称中不包含命名空间分隔符的标识符，例如 Foo 。
- 限定名称，名称中含有命名空间分隔符的标识符，例如 Foo\Bar 。
- 名称中包含命名空间分隔符，并以命名空间分隔符开始的标识符，例如 \Foo\Bar。 namespace\Foo 也是一个完全限定名称。

直接用例子来说就非常清晰了。

```php
// 非限定名称、限定名称、完全限定名称
use MyProject\FILE32\objectA32 as obj32;

$o = new obj32(); // 非限定名称
$o->test(); // FILE32\ObjectA

$o = new FILE32\objectA32(); // 限定名称
$o->test(); // FILE32\ObjectA

$o = new \MyProject\FILE32\objectA32(); // 完全限定名称
$o->test(); // FILE32\ObjectA

```

## namespace关键字和__NAMESPACE__常量

- namesapce，显式访问当前命名空间或子命名空间中的元素。它等价于类中的 self 操作符。
- __NAMESPACE__，包含当前命名空间名称的字符串。在全局的，不包括在任何命名空间中的代码，它包含一个空的字符串。

也是很简单的内容吧，直接来看例子。

```php
// file5.php
namespace FILE5;

function test(){
    echo __NAMESPACE__ . ': test()', PHP_EOL;
}

// test.php
namespace Pro;
// namespace与__NAMESPACE__
require 'namespace/file5.php';

function test(){
    echo __NAMESPACE__ . ': test()', PHP_EOL;
}

namespace\test(); // Pro: test()

\FILE5\test(); // FILE5: test()
```

我们给当前命名空间定义为Pro，引入了file5文件。这两个文件中都有一个test()方法，test()方法内都输出了__NAMESPACE__来打印当前的命名空间名称。然后在test.php中，通过namespace关键字调用的就是当前文件的Pro命名空间中的test()方法，输出的是 Pro: test() 。直接使用完全限定名称调用FILE5的test()方法，输出了 FILE5: test() 。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/PHP%E4%B8%AD%E5%91%BD%E5%90%8D%E7%A9%BA%E9%97%B4%E6%98%AF%E6%80%8E%E6%A0%B7%E7%9A%84%E5%AD%98%E5%9C%A8%EF%BC%9F%EF%BC%88%E4%BA%8C%EF%BC%89%20.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/PHP%E4%B8%AD%E5%91%BD%E5%90%8D%E7%A9%BA%E9%97%B4%E6%98%AF%E6%80%8E%E6%A0%B7%E7%9A%84%E5%AD%98%E5%9C%A8%EF%BC%9F%EF%BC%88%E4%BA%8C%EF%BC%89%20.php)

参考文档：
[https://www.php.net/manual/zh/language.namespaces.nsconstants.php](https://www.php.net/manual/zh/language.namespaces.nsconstants.php)
[https://www.php.net/manual/zh/language.namespaces.rules.php](https://www.php.net/manual/zh/language.namespaces.rules.php)
[https://www.php.net/manual/zh/language.namespaces.nested.php](https://www.php.net/manual/zh/language.namespaces.nested.php)
[https://www.php.net/manual/zh/language.namespaces.definitionmultiple.php](https://www.php.net/manual/zh/language.namespaces.definitionmultiple.php)