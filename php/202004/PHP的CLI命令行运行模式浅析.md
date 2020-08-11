# PHP的CLI命令行运行模式浅析

在做开发的时候，我们不仅仅只是做各种网站或者接口，也经常需要写一些命令行脚本用来处理一些后端的事务。比如对数据进行处理统计等。当然也是为了效率着想，当一个事务有可能会有较长的耗时时，往往会交由服务器的定时器来固定时间调用脚本进行处理，从而让客户端能够有更好的用户体验。我们今天就来了解下 PHP 的命令行运行模式，也就是 PHP CLI 。

## CLI 与 CGI

首先来看一下 CLI 和 CGI 的区别。我们都知道，Nginx 使用的是 FastCgi 来调用 PHP 的服务。 CGI 是通用编程接口，也就是给调用者提供的一种使用本程序的接口。 Nginx 这种类型的服务器并不是直接运行 PHP 程序的，而是通过 FastCgi 来执行 PHP 程序并获得返回结果。

CLI 则是 Command Line Interface，即命令行接口。主要用作 PHP 的开发外壳应用。也就是用 PHP 来进行 shell 脚本的开发。相比 linux 原生的 shell 来说，当然是方便了许多。在命令行状态下，直接使用 php 命令就可以运行某段 PHP 代码或某个 PHP 文件了。

另外，我们在命令行也可以直接使用 phpcgi 来运行一段 PHP 代码或者某个 PHP 文件，它和直接使用 php 命令来运行有什么区别呢？

- CLI 的输出没有任何头信息
- CLI 在运行时，不会把工作目录改为脚本的当前目录
- CLI 出错时输出纯文本的错误信息（非 HTML 格式）
- 强制覆盖了 php.ini 中的某些设置，因为这些设置在外壳环境下是没有意义的

```php
// PHP的CLI命令行运行模式浅析.php
echo getcwd();

//  php-cgi dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// ...../MyDoc/博客文章/dev-blog/php/202004/source

// php dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// ...../MyDoc/博客文章
```

我们选取最典型的一个例子，我们运行的这个文件中，使用 getcwd() 输出当前脚本运行的目录，可以看出两种运行方式输出的结果明显不同。php-cgi 是以文件所在目录为基准输出，而 php 则是以当前运行这个命令的目录为基准输出。

## 直接运行 PHP 代码

在做一些简单的调试的时候，我们可以直接通过 CLI 来运行一段代码。

```php
// php -r "echo 121;"
// 121
```

也就是简单的加个 -r 参数，后面跟上一段代码，这段代码必须用引号括起来。而且这个引号更推荐使用单引号，后面的例子会展示为什么用单引号更好。

## CLI 获取参数

命令行模式下也是可以给脚本传递参数的。

```php
// PHP的CLI命令行运行模式浅析.php
print_r($argv);
// php-cgi dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php 1 2 3
// X-Powered-By: PHP/7.3.0
// Content-type: text/html; charset=UTF-8

// php dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php 1 2 3
// Array
// (
//     [0] => dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
//     [1] => 1
//     [2] => 2
//     [3] => 3
// )
```

在测试文件中，我们打印了 \\$argv 变量。PHP 脚本运行的时候，会将命令行的所有参数保存在 $argv 变量中，并且还有一个 $argc 变量会保存参数的个数。

我们依然是使用 php-cgi 和 php ，两种模式来测试，从这里我们能发现 php-cgi 模式中 $argv 打印的内容竟然是头信息，而不是具体的参数信息。这也没错，毕竟 CGI 模式本来就是为 Web 服务器提供的接口，所以它接收的是 post 、 get 这类的参数而不是命令行的参数。

CLI 模式下我们正常获得了参数内容，并且 $argv[0] 始终保存的是当前运行文件及路径。

## CLI 命令行实用选项

最后，我们再介绍一些命令行中常用的选项。

### -r 直接运行代码时的参数传递

```php
// php -r "var_dump($argv);" app 
// Warning: var_dump() expects at least 1 parameter, 0 given in Command line code on line 1
// 双引号 "，sh/bash 实行了参数替换

// php -r 'var_dump($argv);' app
// array(2) {
//     [0]=>string(19) "Standard input code"
//     [1]=>string(3) "app"
// }

// php -r 'var_dump($argv);' -- -h
// array(2) {
//     [0]=>string(19) "Standard input code"
//     [1]=>string(2) "-h"
// }
```

第一段代码在对双引号运行的 CLI 代码进行参数传递的时候，会直接报警告。其实很好理解，双引号里面的$会让系统的 sh/bash 以为这是个变量从而进行变量参数替换。所以更推荐使用单引号进行日常的简单测试。

第二段代码能够正常打印传递进来的参数内容。第三行代码则是需要传递带 - 符号的内容时，需要先给一个 -- 参数列表分隔符。这是因为 -xxx 的内容会让 php 命令认为这是一个命令选项而不是参数，所以我们添加一个分隔符就可以让分隔符之后的参数内容原样传递进代码中。

### 交互式地运行 PHP

```php
// php -a
// php > $a = 1;
// php > echo $a;
// php > 1
```

添加一个 -a 选项，PHP 就会以交互式地形式运行，我们可以直接在交互状态下写代码或运行任何内容。

### 查看 phpinfo() 及已经安装的模块

这两个应该是大家经常会使用的两个选项。

```php
// 输出 phpinfo()
// php -i

// 输出 PHP 中加载的模块
// php -m

// 查看模块详细信息
// php --ri swoole 
```

另外我们还可以通过 --ri 模块名 这个命令来查看具体某个扩展模块的详细信息。比如这里我们可以查看到 swoole 扩展的版本及相关的配置信息。

### 查看某个文件

```php
// 显示去除了注释和多余空白的源代码
// php -w dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php
// <?php
//  echo getcwd(); print_r($argv);

// 通过 linux 管道读取输入
// cat dev-blog/php/202004/source/PHP的CLI命令行运行模式浅析.php | php -r "print file_get_contents('php://stdin');"
// ......这个文件里面所有的内容
```

最后两个小技巧，一个是通过 -w 选项，我们可以打印这个 php 文件中所有非注释和换行的内容。可以看成是像前端的代码压缩一样的能力。我们这个测试文件中有非常多的注释，通过这个命令后我们打印出来的内容是去除掉所有注释和空白行的结果。

另一个是我们可以用 linux 管道的方式向 PHP CLI 发送数据。这里我们通过 cat 查看我们的测试文件然后通过管道发送给 PHP CLI，在脚本中使用 STDIN 来读取管道发送过来的内容完成了整个文件内容的打印。这里我们没进行任何过滤，所以打印的是整个文件里面的内容，大家可以运行这个命令来测试。

## 总结

其实命令行模式运行的时候还有很多的选项，这里我们只是选取了一部分非常有用的内容进行展示。当然，大部分框架都提供了用于命令行的脚本框架，比如 laravel 中可以通过 php artisan make:command 来创建命令行脚本，然后使用 php artisan 来运行框架中的脚本。这些内容将来我们在学习框架方面知识的内容将会进行详细的讲解。

命令行 CLI 模式的应用非常广泛，几乎任何项目中都会使用到，所以，深入的学习掌握它将会使我们大受裨益。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E7%9A%84CLI%E5%91%BD%E4%BB%A4%E8%A1%8C%E8%BF%90%E8%A1%8C%E6%A8%A1%E5%BC%8F%E6%B5%85%E6%9E%90.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E7%9A%84CLI%E5%91%BD%E4%BB%A4%E8%A1%8C%E8%BF%90%E8%A1%8C%E6%A8%A1%E5%BC%8F%E6%B5%85%E6%9E%90.php)

参考文档：

[https://www.php.net/manual/zh/features.commandline.php](https://www.php.net/manual/zh/features.commandline.php)