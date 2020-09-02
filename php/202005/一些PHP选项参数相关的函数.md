# 一些PHP选项参数相关的函数

关于 PHP 的配置，我们大多数情况下都是去查看 php.ini 文件或者通过命令行来查询某些信息，其实，PHP 的一些内置函数也可以帮助我们去查看或操作这些配置参数。比如之前我们学习过的 [关于php的ini文件相关操作函数浅析](https://mp.weixin.qq.com/s/htAk7a3GlmS956fxMVxZdQ) 。修改方面的函数就只有 ini_set() ，其他大部分的函数其实都是帮助我们进行查询的，今天，我们就来一一讲解这些函数。

## get_defined_constants()

返回所有常量的关联数组，键是常量名，值是常量值。

```php
define("MY_CONSTANT", 1);
print_r(get_defined_constants(true));
// array(
//     ……
//     [user] => array(
//         [MY_CONSTANT] => 1
//     )
// )
```

这个函数会输出所有的常量，因为返回的内容很多，所以用 ...... 表示有很多系统或扩展的定义常量，而我们在代码中自己定义的常量则会全部进入到 [user] 这个键名下。

这个函数有一个参数，当它为 true 时，让此函数返回一个多维数组，分类为第一维的键名，常量和它们的值位于第二维。而默认情况下是 false ，返回的是一个一维数组，就是常量名作为键名，它们的值作为键值。

## get_extension_funcs()

这个函数返回的是扩展模块所包含的所有方法名称。

```php
print_r(get_extension_funcs("swoole"));
// Array
// (
//     [0] => swoole_version
//     [1] => swoole_cpu_num
//     [2] => swoole_last_error
//     [3] => swoole_async_dns_lookup_coro
//     [4] => swoole_async_set
//     [5] => swoole_coroutine_create
//     ……
//     [35] => swoole_timer_clear
//     [36] => swoole_timer_clear_all
// )
```

它的参数就是要查询的扩展名称，这里我们直接查看本机安装的 Swoole 里面都包含那些方法。可以看到，Swoole4.4 中一共包含有37个方法函数。

## get_loaded_extensions()

这个函数是返回所有已加载的扩展模块列表。

```php
print_r(get_loaded_extensions());  // php -m
// Array
// (
//     [0] => Core
//     [1] => phpdbg_webhelper
//     [2] => date
//     [3] => libxml
//     [4] => openssl
//     [5] => pcre
//     [6] => sqlite3
//     ……
//     [65] => imagick
//     [66] => swoole
//     [67] => vld
//     [68] => Zend OPcache
// )
```

这个函数的作用是不是和我们在命令行使用 -m 来查看当前系统已安装的扩展一样。没错，它们就是相同的功能，都是返回的这样一个扩展安装情况的列表。在一些开源 cms 系统中，需要检查当前的安装环境是否符合要求时，就可以用这个函数进行检测。

## get_include_path() 和 get_included_files()

这两个函数一个是返回当前 include_path 的配置信息，一个是返回已经被 include 或 require 进来的文件列表。

```php
echo get_include_path(), PHP_EOL; // .:/usr/local/Cellar/php/7.3.0/share/php/pear
echo ini_get('include_path'), PHP_EOL; // .:/usr/local/Cellar/php/7.3.0/share/php/pear
```

get_include_path() 很简单，它的效果其实就和 echo ini_get('include_path') 是一样的，都是去读取 php.ini 文件中 include_path 的配置值。PHP 在 include 或 require 时，如果没有给定路径，那么它就会先在当前目录中查找，如果没有找到，则会进入这个 include_path 中进行查找。如果依然没有找到指定的文件，才会报错。这就是 include_path 目录的作用，当然，我们在日常开发中基本不会用到它，所以这里了解了解即可。

```php
include "动态查看及加载PHP扩展.php";
print_r(get_included_files());
// Array
// (
//     [0] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202005/source/一些PHP选项参数相关的函数（一）.php
//     [1] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202005/source/动态查看及加载PHP扩展.php
// )
```

get_included_files() 也是非常简洁直观的一个函数，它就是返回我们当前加载了哪些文件。当前运行时的文件总会在第一条，也就是说，这个函数至少会返回一个自身的文件路径。我们可以试试在 Laravel 或其他框架的入口文件或者控制器中使用这个函数打印一下它们的加载文件数量，这样其实也能帮我们理解这个框架的加载执行情况。

## get_resources()

```php
var_dump(get_resources());
// array(3) {
//   [1]=>
//   resource(1) of type (stream)
//   [2]=>
//   resource(2) of type (stream)
//   [3]=>
//   resource(3) of type (stream)
// }

$fp = fopen('1.txt','r');
var_dump(get_resources());
// array(4) {
//   [1]=>
//   resource(1) of type (stream)
//   [2]=>
//   resource(2) of type (stream)
//   [3]=>
//   resource(3) of type (stream)
//   [5]=>
//   resource(5) of type (stream-context)
// }
```

这个函数返回的是活动资源的情况。比如上面例子中，我们先打印了这个函数的内容，只有3条数据，然后我们用 fopen() 加载了一个文件资源，获得了一个资源句柄。这时候再打印这个函数的内容，就会发现多了一条，而且类型是 stream-context 类型的资源句柄。这个函数可以帮我们在调试的时候查看是否有没有释放的资源操作。

## 总结

今天先简单的学习了几个函数，其实他们并不是非常常用的函数，但是通过学习之后，竟然发现有不少函数还是能帮助我们对系统进行调优或者在迁移系统的时候能够快速检测运行环境的。学习致用才是最成功的学习，让我们继续加油吧！

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E4%B8%80%E4%BA%9BPHP%E9%80%89%E9%A1%B9%E5%8F%82%E6%95%B0%E7%9B%B8%E5%85%B3%E7%9A%84%E5%87%BD%E6%95%B0.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E4%B8%80%E4%BA%9BPHP%E9%80%89%E9%A1%B9%E5%8F%82%E6%95%B0%E7%9B%B8%E5%85%B3%E7%9A%84%E5%87%BD%E6%95%B0.php)
