# PHPDebug互动扩展【phpdbg】功能浅析

对于 PHP 开发者来说，单步的断点 Debug 调试并不是我们的必修课，而 Java 、 C# 、 C++ 这些静态语言则会经常性地进行这种调试。其实，我们 PHP 也是支持这类调试方式的，特别是对于了解一些开源框架，或者有非常深层次的 Bug 跟踪时，断点调试会非常有用。

不少接触过 PHP 断点调试的一定都用过鼎鼎大名的 XDebug 。不过我们今天讲的并不是这款扩展，而是另一个已经集成到 PHP 官方源码中的调试工具，并且，最重要的是，它调试时看到的内容是更为底层的 opcode 执行过程。话不多说，我们直接进入到 phpdbg 这款工具的学习中吧！！

## phpdbg 命令行功能

在我们安装好 PHP 后，默认就有了 phpdbg 这个工具。直接在命令行运行就会进入这个工具。

```shell
% phpdbg
[Welcome to phpdbg, the interactive PHP debugger, v0.5.0]
To get help using phpdbg type "help" and press enter
[Please report bugs to <http://bugs.php.net/report.php>]
```

没错，它就是随 PHP 安装的时候默认自带的，如果你的环境变量中没有这个工具命令的话，可以在 PHP 安装目录的 bin/ 目录下面找到。

在进入 phpdbg 环境后，我们使用 help 就可以查看它的操作说明。

```shell
prompt> help

phpdbg is a lightweight, powerful and easy to use debugging platform for PHP5.4+
It supports the following commands:

Information
  list      list PHP source
  info      displays information on the debug session
  print     show opcodes
  frame     select a stack frame and print a stack frame summary
  generator show active generators or select a generator frame
  back      shows the current backtrace
  help      provide help on a topic
……
```

帮忙文档非常长，大家可以自己查看具体的内容，其中有一个 help 命令可以让我们看到许多简写的命令，我们主要使用这些简写的命令别名就可以。

```shell
prompt> help aliases
Below are the aliased, short versions of all supported commands
 e     exec                  set execution context
 s     step                  step through execution
 c     continue              continue execution
 r     run                   attempt execution
 u     until                 continue past the current l
```

命令的简介和查看都很简单，那么我们要如何来调试 PHP 文件呢？这个才是我们最关心的事情。在调试一个文件的时候，我们需要将它载入到当前的执行环境中。可以在当前 phpdbg 环境中使用 e 命令指定文件进行载入，也可以在运行 phpdbg 的时候通过 -e 来指定需要载入的文件。

```shell
% phpdbg -e PHPDebug互动扩展.php
[Welcome to phpdbg, the interactive PHP debugger, v0.5.0]
To get help using phpdbg type "help" and press enter
[Please report bugs to <http://bugs.php.net/report.php>]
[Successful compilation of /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
prompt> 
```

这里我们使用的是第二种方式，在启动 phpdbg 时使用 -e 参数来指定需要载入的文件。

## 普通断点设置

载入了文件，进入了命令行，我们就可以进行断点调试了。首先，我们使用代码方式来设置断点。在上面的测试文件中，我们使用下面的方式来定义断点。

```php
echo 111;
phpdbg_break_file("PHPDebug互动扩展.php", 3);

echo 222;
phpdbg_break_file("PHPDebug互动扩展.php", 6);
```

phpdbg_break_file() 函数就是来定义断点的，它有两个参数，第一个参数是文件名，这个不能乱填。第二个参数是断点的行号。

接下来，在命令行中，我们运行两次简写的 run 命令 r 。

```shell
prompt> r
111
[Breakpoint #0 added at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:3]
222
[Breakpoint #1 added at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:6]
[Script ended normally]

prompt> r
[Breakpoint #0 at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:3, hits: 1]
>00003: echo 111;
 00004: phpdbg_break_file("PHPDebug互动扩展.php", 3);
 00005: 
prompt> 
```

可以看出，在第一次运行 r 的时候， phpdbg 将整个文件进行了一次扫描并输出了当前的两个断点信息。然后再运行一次 r 则定位到了第3行，也就是第一个断点的位置。接下来，我们就要进行单点调试了，我们直接使用 step 的简写命令 s 。

```shell
prompt> s
[L3          0x10ecae220 ECHO                    111                                                            /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
111
[L4          0x10ecae240 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
>00004: phpdbg_break_file("PHPDebug互动扩展.php", 3);
 00005: 
 00006: echo 222;
prompt> 
```

断点位置向下运行了，果然是符合我们的预期，开始了一行一行的单步运行。在上面输出的内容中，我们看到了 opcode 运行的状态。比如 L3 0x10ecae220 ECHO 这一行指的就是第 3 行执行了 ECHO 操作。是不是感觉非常高大上。

一路 s 下来，走到最后我们就结束了这次断点调试，phpdbg 环境将退出 run 运行时。

```shell
……
prompt> s
[Script ended normally]
prompt> s
[Not running]
prompt> 
```

这样，一趟调试就完成了。当我们在第一个断点不想单步调试，想直接进入下一个断点，就可以使用 continue 的简写命令 c 来直接跳到下一个断点。

```shell
prompt> r
Do you really want to restart execution? (type y or n): y
[Breakpoint #0 at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:3, hits: 1]
>00003: echo 111;
 00004: phpdbg_break_file("PHPDebug互动扩展.php", 3);
 00005: 

prompt> c
111
[Breakpoint at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:3 exists]
[Breakpoint #1 at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:6, hits: 1]
>00006: echo 222;
 00007: phpdbg_break_file("PHPDebug互动扩展.php", 6);
 00008: 
prompt> 
```

另外还有一个命令就是可以直接看到当前载入的文件环境中的所有断点信息的。

```shell
prompt> info break
------------------------------------------------
File Breakpoints:
#0              /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:3
#1              /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:6
```

以上，就是一个简单的行断点设置以及调试步骤。当然，我们只是针对一个简单文件的测试，对于复杂的框架型系统，断点的设置和调试就会复杂很多，不过相应地，我们能够看到底层的 opcode 代码的执行情况，也能让我们对所测试的内容有更加深入的了解。

## 方法断点及运行步骤分析

接下来我们来设置一个方法断点，并一步步观察 opcode 的情况。

```php
$i = 1;
// phpdbg -e PHP\ Debug互动扩展.php
function testFunc(){
    global $i;
    $i += 3;
    echo "This is testFunc! i：" . $i, PHP_EOL;
}

testFunc();
phpdbg_break_function('testFunc');
```

在 PHP 代码中，我们使用 phpdbg_break_function() 来给这个 testFunc() 方法设置一个断点。当代码中调用这个函数的时候，就会进入这个断点中。

```shell
prompt> r
[Breakpoint #0 in testFunc() at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:11, hits: 1]
>00011: function testFunc(){
 00012:     global $i;
 00013:     $i += 3;

prompt> s
[L12         0x109eef620 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
>00012:     global $i;
 00013:     $i += 3;
 00014:     echo "This is testFunc! i：" . $i, PHP_EOL;

prompt> s
[L12         0x109eef640 BIND_GLOBAL             $i                   "i"                                       /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
[L13         0x109eef660 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
>00013:     $i += 3;
 00014:     echo "This is testFunc! i：" . $i, PHP_EOL;
 00015: }
```

直接进行了两次 s 单步，可以看到 global $i 对应的 opcode 操作是 BIND_GLOBAL 。继续向下操作。

```shell
prompt> s
[L13         0x109eef680 ASSIGN_ADD              $i                   3                                         /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
[L14         0x109eef6a0 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
>00014:     echo "This is testFunc! i：" . $i, PHP_EOL;
 00015: }
 00016: 

prompt> s
[L14         0x109eef6c0 CONCAT                  "This is testFunc!"+ $i                   ~1                   /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
[L14         0x109eef6e0 ECHO                    ~1                                                             /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
This is testFunc! i：4
[L14         0x109eef700 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
[L14         0x109eef720 ECHO                    "\n"                                                           /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]

[L15         0x109eef740 EXT_STMT                                                                               /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php]
>00015: }
 00016: 
 00017: testFunc();
```

第 13 行执行的是 $i += 3 的操作，对应的 opcode 操作是 ASSIGN_ADD ，增加的值是 3 。继续 s 后执行了第 14 行，注意这里进行了两步操作。一次是 CONCAT ，一次是 ECHO ，然后代码正常输出了打印出来的语句。

从上面的几步调试可以清晰的看到 PHP 在 opcode 层面的一步步的执行状态，就像 XDebug 一样，每一次的执行都会有相关的变量、操作的信息输出。

## 类函数断点设置

类函数的断点设置其实就和上面的方法断点函数一样，非常的简单方便。

```php
class A{
    function testFuncA(){
        echo "This is class A testFuncA!", PHP_EOL;
    }
}
$a = new A;
$a->testFuncA();
phpdbg_break_method('A', 'testFuncA');
```

这里就不贴出调试的代码了，大家可以自己尝试一下。

## 命令行增加断点

除了在 PHP 代码中给出固定的断点之外，我们还可以在命令行中进行断点的增加，比如我们去掉之前的方法断点函数。然后在命令行中指定在方法中增加一个断点。

```shell
prompt> b testFunc#3
[Breakpoint #1 added at testFunc#3]
```

#2 这是什么意思呢？其实就是说我们在这个方法体内部的第 2 行增加一个断点。也就是说，我们在 $i += 3; 这一行增加了一个断点。行数是从方法定义那一行开始算的并且是从 1 开始，如果不加这个行数，就是直接从方法定义那一行开始。

```shell
prompt> r
[Breakpoint #0 resolved at testFunc#3 (opline 0x1050ef660)]
[Breakpoint #0 resolved at testFunc#3 (opline 0x1050ef660)]
[Breakpoint #0 resolved at testFunc#3 (opline 0x1050ef660)]
[Breakpoint #0 resolved at testFunc#3 (opline 0x1050ef660)]
[Breakpoint #0 in testFunc()#3 at /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source/PHPDebug互动扩展.php:13, hits: 1]
>00013:     $i += 3;
 00014:     echo "This is testFunc! i：" . $i, PHP_EOL;
 00015: }
```

执行 r 后，我们就直接定位到了 testFun() 方法中的第三行。

## 总结

今天我们只是简单的学习了一下 phpdbg 这个工具的使用。从 help 命令中就可以看出，这个工具还有非常多的选项参数，可以帮我们完成许多调试工作。在这里只是跟大家一起入个门，将来在学习的过程中再次接触到的时候我们再继续深入的研究。

测试代码：

参考文档：
[https://www.php.net/manual/zh/intro.phpdbg.php](https://www.php.net/manual/zh/intro.phpdbg.php)