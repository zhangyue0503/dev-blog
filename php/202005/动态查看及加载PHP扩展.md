在编译并完成 php.ini 的配置之后，我们就成功的安装了一个 PHP 的扩展。不过， PHP 也为我们提供了两个在动态运行期间可以查看扩展状态以及加载未在 php.ini 中进行配置的扩展的函数。下面，我们就来看看它们的使用。

## 查看是否已经加载了扩展

```php
echo extension_loaded("redis");
```

非常简单的一个函数，它的作用就是检查一个扩展是否已经加载。它返回的是一个布尔值，当扩展已经加载则返回 true ，如果扩展没有加载，则返回 false 。

在 PHP-FPM 的网页中，我们可以通过 phpinfo() 函数来查看当前 PHP 的状态及扩展相关信息。而在 CLI 命令行脚本中，我们可以使用 php -m 命令来查看已加载的扩展。

## 动态加载扩展

首先，我们在 php.ini 中关闭 redis 扩展的加载，并且同时需要打开 enable_dl=1 ，这样，我们就可以使用 dl() 函数来动态加载一个扩展了。

```php
dl("redis");
echo extension_loaded("redis");
// 1
```

没错， dl() 函数正是用来动态加载扩展的一个函数。不过它的使用是有许多限制的，这也并不是一个安全的函数。所以在 PHP7 中，它在 php.ini 的配置 enable_dl 已经是默认关闭的了。我们在生产环境也尽量不要使用这种方式进行扩展的加载。

另外，这个函数在 PHP7 中仅对 CLI 环境有效。也就是说，在 PHP-FPM 的网页环境下，这个函数是没用的，即使已经打开了 php.ini 中的 enable_dl 。

扩展加载的目录是以 PHP 默认的扩展目录为基础进行加载的，在 windows 环境下注意扩展名为 .dll 文件。当扩展加载失败时，不仅这个函数会返回 false ，同时还会产生一条 E_WARNING 的错误消息。最后，在 PHP 安全模式下，这个函数也同样是无法使用的。

综上所述，在生产环境中，我们还是尽量不要使用动态加载扩展的能力。这个可以当成我们的一个学习资料，在自己本机电脑上不想一次加载太多扩展的情况下使用，当需要测试某些功能而需要某些特殊的扩展时，再考虑使用这个功能进行本地的测试。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E5%8A%A8%E6%80%81%E6%9F%A5%E7%9C%8B%E5%8F%8A%E5%8A%A0%E8%BD%BDPHP%E6%89%A9%E5%B1%95.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E5%8A%A8%E6%80%81%E6%9F%A5%E7%9C%8B%E5%8F%8A%E5%8A%A0%E8%BD%BDPHP%E6%89%A9%E5%B1%95.php)

参考文档：

[https://www.php.net/manual/zh/function.extension-loaded.php](https://www.php.net/manual/zh/function.extension-loaded.php)

[https://www.php.net/manual/zh/function.dl.php](https://www.php.net/manual/zh/function.dl.php)