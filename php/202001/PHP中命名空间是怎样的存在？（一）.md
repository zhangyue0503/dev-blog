# PHP中命名空间是怎样的存在（一）？

命名空间其实早在PHP5.3就已经出现了。不过大部分同学可能在各种框架的使用中才会接触到命名空间的内容，当然，现代化的开发也都离不开这些能够快速产出的框架。这次我们不从框架的角度，仅从简单的代码角度来解析一下命名空间的概念和使用。

首先，我们要定义命名空间是个什么东西。

其实就像操作系统的目录一样，命名空间就是为了解决类似于操作系统中同一个文件夹不能有相同的文件名一样的问题。假设我们只有一个备用，一个目录，那么在这个目录中，是不能有两个完全相同的文件的。如果有这样名称完全相同的文件，那么操作系统也不知道我们到底应该打开的是哪一个文件。同理，在一个PHP文件中，我们也不能起相同名称的函数或者类名，PHP也不知道我们到底要调用的是哪一个函数或者类。

理解了上述内容之后，再来看命名空间的语法，其实非常像我们的目录的定义。

```php

namespace A\B\C;

```

这个命名空间的定义就是指出了当前命名空间是A\B\C。就像是C:\A\B\C这样一个文件夹一样。光说不练假把式，直接上代码来看看：

```php
// file1.php
namespace FILE1;

const CONST_A = 2;
function testA(){
    echo 'FILE1\testA()', PHP_EOL;
}

class objectA{
    function test(){
        echo 'FILE1\ObjectA', PHP_EOL;
    }
}
```

```php
// file2.php
namespace FILE2;

const CONST_A = 3;
function testA(){
    echo 'FILE2\testA()', PHP_EOL;
}

class objectA{
    function test(){
        echo 'FILE2\ObjectA', PHP_EOL;
    }
}
```

我们在namespace目录下创建了这两个php文件，函数和类名都是一样的，但定义了不同的命名空间，一个是FILE1，一个是FILE2。

```php
namespace A;

include 'namespace/file1.php';
include 'namespace/file2.php';

use FILE1, FILE2;
use FILE1\objectA as objectB;

const CONST_A = 1;
function testA(){
    echo 'A\testA()', PHP_EOL;
}

class objectA{
    function test(){
        echo 'A\ObjectA', PHP_EOL;
    }
}

// 当前命名空间
echo CONST_A, PHP_EOL; // 1
testA(); // A\testA()
$oA = new objectA();
$oA->test(); // A\ObjectA

// FILE1
echo FILE1\CONST_A, PHP_EOL; // 2
FILE1\testA(); // FILE1\testA()
$oA = new FILE1\objectA();
$oA->test(); // FILE1\ObjectA

$oB = new objectB();
$oB->test(); // FILE1\ObjectA

// FILE2
echo FILE2\CONST_A, PHP_EOL; // 3
FILE2\testA(); // FILE2\testA()
$oA = new FILE2\objectA();
$oA->test(); // FILE2\ObjectA

```

在测试代码中，我们又定义了当前的命名空间为A。并include了file1.php和file2.php。并在这个文件中同时也定义了与file1.php和file2.php中相同的函数和类名。接下来我们依次调用这些静态变量、函数和类。

- 在默认情况下，静态变量、函数、类调用的是当前命名空间下的内容
- 在使用了FILE1\和FILE2\之后，调用的是就是指定命名空间下的内容
- 需要使用use引入命名空间，否则无法使用命名空间里的内容
- use中可以使用as关键字为命名空间或者其中的类指定别名

命名空间的使用其实就是这么的简单。可以看出我们在不同的命名空间中就可以使用相同的函数或者类名了。这一点正是各类现代化开发框架的基础。同时也是composer能够实现的最主要的原因之一。

接下来，我们尝试一个问题是否符合我们的预期，那就是两个文件定义相同的命名空间是否能够定义相同的类名呢？

```php
// file1-1.php
namespace FILE1;

const CONST_A = 1.1;
function testA(){
    echo 'FILE1-1\testA()', PHP_EOL;
}

class objectA{
    function test(){
        echo 'FILE1-1\ObjectA', PHP_EOL;
    }
}
```

我们定义了一个file1-1.php，并且使用了和file1.php相同的FILE1命名空间。然后和file1.php一起include到测试代码中。

```php
include 'namespace/file1.php';
include 'namespace/file1-1.php'; // Cannot redeclare FILE1\testA()
```

好吧，在运行时直接就报错，不能重复定义同名的函数名。如果注释掉函数，那么会继续报类名不能重复。我们再定义一个file1-2.php，这次还是使用FILE1这个命名空间，但是内容不一样了。

```php
// file1-2.php
namespace FILE1;

const CONST_A = 1.2;
function testA1_2(){
    echo 'FILE1-2\testA()', PHP_EOL;
}

class objectA1_2{
    function test(){
        echo 'FILE1-2\ObjectA', PHP_EOL;
    }
}
```

这样当然就没问题啦。这两个文件在同一个命名空间下，但是却有着不同的能力，这样是完全OK的操作。

```php
include 'namespace/file1.php';
include 'namespace/file1-2.php';
use FILE1;

// FILE1
echo FILE1\CONST_A, PHP_EOL; // 2
FILE1\testA(); // FILE1\testA()
$oA = new FILE1\objectA();
$oA->test(); // FILE1\ObjectA

// FILE1_2
echo FILE1\CONST_A, PHP_EOL; // 3
FILE1\testA1_2(); // FILE1-2\testA()
$oA = new FILE1\objectA1_2();
$oA->test(); // FILE1-2\ObjectA

```

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/PHP%E4%B8%AD%E5%91%BD%E5%90%8D%E7%A9%BA%E9%97%B4%E6%98%AF%E6%80%8E%E6%A0%B7%E7%9A%84%E5%AD%98%E5%9C%A8%EF%BC%9F%EF%BC%88%E4%B8%80%EF%BC%89.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/source/PHP%E4%B8%AD%E5%91%BD%E5%90%8D%E7%A9%BA%E9%97%B4%E6%98%AF%E6%80%8E%E6%A0%B7%E7%9A%84%E5%AD%98%E5%9C%A8%EF%BC%9F%EF%BC%88%E4%B8%80%EF%BC%89.php)

参考文档：
[https://www.php.net/manual/zh/language.namespaces.rationale.php](https://www.php.net/manual/zh/language.namespaces.rationale.php)
[https://www.php.net/manual/zh/language.namespaces.definition.php](https://www.php.net/manual/zh/language.namespaces.definition.php)


