# 关于php的ini文件相关操作函数浅析

在小公司，特别是创业型公司，整个服务器的搭建一般也是我们 PHP 开发工程师的职责之一。其中，最主要的一项就是要配置好服务器的 php.ini 文件。一些参数会对服务器的性能产生深远的影响，而且也有些参数是可以在 PHP 运行时动态指定和获取的。今天，我们就来学习一些和 php.ini 文件有关的操作函数。

## 动态设置ini文件的配置参数

这个函数相信大家不会陌生，基本上做过 PHP 开发的都会使用过。但是，有些参数是无法修改的，这个你知道吗？

```php
ini_set('allow_url_fopen', 0);
echo ini_get('allow_url_fopen'), PHP_EOL; // 1 ，无法修改，PHP_INI_SYSTEM

ini_set('memory_limit', -1);
echo ini_get('memory_limit'), PHP_EOL; // -1，可以修改，PHP_INI_ALL
```

请注意看注释，第一条注释中写了 ，PHP_INI_SYSTEM ，并且这个参数无法修改。没错，相信聪明的你已经看出来了，这些参数是有对应的类型的。，PHP_INI_SYSTEM 的意思就是只能在 php.ini 或者 httpd.conf 中进行修改，无法在语言动态运行时修改。

不同的 php.ini 配置参数对应有四种类型：

- PHP_INI_USER：可在用户脚本（例如 ini_set()）或 Windows 注册表（自 PHP 5.3 起）以及 .user.ini 中设定
- PHP_INI_PERDIR：可在 php.ini，.htaccess 或 httpd.conf 中设定
- PHP_INI_SYSTEM：可在 php.ini 或 httpd.conf 中设定
- PHP_INI_ALL：可在任何地方设定

也就是说，使用 ini_set() 我们可以设定类型为 PHP_INI_USER 和 PHP_INI_ALL 类型的参数，而其它两种只能在 php.ini 或其他配置文件中设置修改。具体的配置参数对应的类型请参考 PHP 相关文档。

[https://www.php.net/manual/zh/ini.list.php](https://www.php.net/manual/zh/ini.list.php)

## 获取ini文件中的配置信息

当然，读取 php.ini 文件中的配置信息就没有什么限制了。直接就可以读取，我们可以使用两个函数来进行读取，它们是：get_cfg_var() 和 ini_get() 。另外，还有一个可以获取数组集合形式的配置信息的函数 ini_get_all() 。我们一个一个来看。

### get_cfg_var() 和 ini_get() 

都是读取单个配置参数信息。

```php
echo get_cfg_var('error_reporting'), PHP_EOL; // 32759
echo ini_get('error_reporting'), PHP_EOL; // 32759

echo get_cfg_var('request_order'), PHP_EOL; // GP
echo ini_get('request_order'), PHP_EOL; // GP

// php.ini A=TEST_A
echo get_cfg_var('A'), PHP_EOL; // TEST_A
echo ini_get('A'), PHP_EOL; // 
```

上面两条不用多解释，我们需要注意到的是，最后一条。我们在 php.ini 文件中定义了一个自定义的配置参数 A 。可以看到，get_cfg_var() 可以正常获取到这条信息，但 ini_get() 无法获取。我们再看另外一个例子。

```php
ini_set('error_reporting', E_WARNING);
echo get_cfg_var('error_reporting'), PHP_EOL; // 32759，只返回.ini的内容
echo ini_get('error_reporting'), PHP_EOL; // 2，返回当前配置运行时的状态
```

使用 ini_set() 动态设置了 error_reporting 参数后，get_cfg_var() 返回是 ini_set() 设置的值，而 ini_get() 获取的依然是 php.ini 文件里面配置的值。

从上面两个例子可以看出这两个函数的区别：

- get_cfg_var()，可以获取自定义的配置参数值，但只以 php.ini 文件为准，无法获得动态修改的参数值
- ini_get()，无法获取自定义的配置参数值，以当前的动态脚本运行时的配置为准，也就是能够获取到 ini_set() 修改后的参数值

### ini_get_all()

它获取的是一组数据，比如我们安装的一些扩展 Swoole 、 xDebug 或者 mysqlnd 这类的配置信息。

```php
print_r(ini_get_all('swoole'));
echo PHP_EOL;
// Array
// (
//     [swoole.display_errors] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_coroutine] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_library] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_preemptive_scheduler] => Array
//         (
//             [global_value] => Off
//             [local_value] => Off
//             [access] => 7
//         )

//     [swoole.unixsock_buffer_size] => Array
//         (
//             [global_value] => 262144
//             [local_value] => 262144
//             [access] => 7
//         )

//     [swoole.use_shortname] => Array
//         (
//             [global_value] => 
//             [local_value] => 
//             [access] => 4
//         )

// )
```

可以看出，我们针对 Swoole 所作的所有配置信息都以数组形式返回了。

## 还原配置信息

当我们使用了 ini_set() 动态设置了参数信息后，想还原为 php.ini 文件中的默认配置的话，直接使用一个 ini_restore() 函数就可以了。

```php
ini_restore('error_reporting');
echo ini_get('error_reporting'), PHP_EOL; // 32759
```

依然是沿用上面的代码， error_reporting 已经被我们修改为了 2 ，这时，我们直接使用 ini_restore() 进行了还原，再使用 ini_get() 就可以看到 error_reporting 参数还原回了 php.ini 文件中定义的原始值。

## 获取当前加载的配置文件路径

当你接手一台服务器的时候，往往第一步就是找到它的相关应用配置文件，比如 mysql 的 my.ini 或者 nginx 的 conf 相关配置文件路径，而 PHP 中我们第一步就是要找到 php.ini 文件在哪里。

```php
echo php_ini_loaded_file(), PHP_EOL;
// /usr/local/etc/php/7.3/php.ini

echo php_ini_scanned_files(), PHP_EOL;
```

我们直接使用 php_ini_loaded_file() 就可以方便的获取到当前运行的脚本环境中加载的 php.ini 文件的路径。而 php_ini_scanned_files() 函数则是会以逗号分隔的形式返回所有可以扫描 php.ini 文件的路径。其实这两个参数在 phpinfo() 中都都有所体现，但很多时候我们并不能直接在生产环境中去使用 phpinfo() 。

其实，相对于这两个函数或 phpinfo() 来说，更好的方案是直接在命令行查找 php.ini 文件的位置。

```shell
php --ini
# Configuration File (php.ini) Path: /usr/local/etc/php/7.3
# Loaded Configuration File:         /usr/local/etc/php/7.3/php.ini
# Scan for additional .ini files in: /usr/local/etc/php/7.3/conf.d
# Additional .ini files parsed:      /usr/local/etc/php/7.3/conf.d/ext-opcache.ini

php -i | grep "Configuration"
# Configuration File (php.ini) Path => /usr/local/etc/php/7.3
# Loaded Configuration File => /usr/local/etc/php/7.3/php.ini
# Configuration
```

## phpinfo()

关于 phpinfo() ，我们不用解释太多，里面的内容都有什么应该是学习使用 PHP 的开发人员的必修课。在这里，我们只是介绍一下 phpinfo() 这个函数的参数。没错，它是有参数的，可以只显示一部分的信息而不是全部都显示出来。

- INFO_GENERAL：配置的命令行、 php.ini 的文件位置、建立的时间、Web 服务器、系统及更多其他信息。
- INFO_CREDITS：PHP 贡献者名单。参加 phpcredits()。
- INFO_CONFIGURATION：当前PHP指令的本地值和主值。参见 ini_get()。
- INFO_MODULES：已加载的模块和模块相应的设置。参见 get_loaded_extensions()。
- INFO_ENVIRONMENT：环境变量信息也可以用 $_ENV 获取。
- INFO_VARIABLES：显示所有来自 EGPCS (Environment, GET, POST, Cookie, Server) 的 预定义变量。
- INFO_LICENSE：PHP许可证信息。参见 » license FAQ。
- INFO_ALL：显示以上所有信息。

```php
phpinfo(INFO_MODULES);
```

上面的代码在页面中所显示的信息就只是已加载模式相关的配置信息了。phpinfo() 会直接输出到页面上，如果想将它的内容保存在一个变量中，我们需要使用输出缓冲控制来进行操作。我们将在后面的文章中讲到这方面的内容。这里就简单的给一段代码。

```php
ob_start();
phpinfo();
$v = ob_get_contents();
ob_end_clean();

echo $v;
```

## 总结

不看不知道，一看吓一跳。原来只是使用过 ini_set() 去修改运行时内存大小，但直到今天才知道原来 ini_set() 并不是所有的配置都可以修改的，每个参数是否能动态修改还要看它的参数类型。而且上面还忘了说了，我们并不能使用 ini_set() 去增加配置参数。也就是说，使用 ini_set("B", "TEST_B") 这样一个 B 参数，然后直接使用 ini_get() 也是无法获取的。而且简单的获取参数信息的两个函数也有这么多的不同，phpinfo() 原来也有这么多参数。果然，文档才是最好的学习资料。旅程还没有停止，我们刷文档的脚步依然不能停，一起加油冲冲冲！！

测试代码：


参考文档：

[https://www.php.net/manual/zh/function.get-cfg-var.php](https://www.php.net/manual/zh/function.get-cfg-var.php)
[https://www.php.net/manual/zh/function.ini-set.php](https://www.php.net/manual/zh/function.ini-set.php)
[https://www.php.net/manual/zh/function.ini-restore.php](https://www.php.net/manual/zh/function.ini-restore.php)
[https://www.php.net/manual/zh/function.ini-get.php](https://www.php.net/manual/zh/function.ini-get.php)
[https://www.php.net/manual/zh/function.ini-get-all.php](https://www.php.net/manual/zh/function.ini-get-all.php)
[https://www.php.net/manual/zh/function.ini-alter.php](https://www.php.net/manual/zh/function.ini-alter.php)
[https://www.php.net/manual/zh/function.php-ini-loaded-file.php](https://www.php.net/manual/zh/function.php-ini-loaded-file.php)
[https://www.php.net/manual/zh/function.php-ini-scanned-files.php](https://www.php.net/manual/zh/function.php-ini-scanned-files.php)
[https://www.php.net/manual/zh/ini.list.php](https://www.php.net/manual/zh/ini.list.php)
[https://www.php.net/manual/zh/configuration.changes.modes.php](https://www.php.net/manual/zh/configuration.changes.modes.php)