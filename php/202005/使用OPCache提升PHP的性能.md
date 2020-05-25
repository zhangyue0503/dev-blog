# 使用OPCache提升PHP的性能

对于 PHP 这样的解释型语言来说，每次的运行都会将所有的代码进行一次加载解析，这样一方面的好处是代码随时都可以进行热更新修改，因为我们不需要编译。但是这也会带来一个问题，那就是无法承载过大的访问量。毕竟每次加载解析再释放，都会增加 CPU 的负担，通常一台 8核16G 的服务器在2、3000并发左右 CPU 就能达到60%以上的使用率。而且如果你使用的是类似于 Laravel 这种大型的框架，效率将更加低下。这个时候，我们通常会通过增加服务器数量来做负载均衡，从而达到减轻服务器压力的效果。不过，这样做的成本又会增加许多。那么，有没有什么优化的方案呢？

鸟哥在他的博客中针对 PHP7 的优化的一篇文章中，第一条建议就是开启 OPcache 。当然，另外一个方案就是使用 Swoole 。关于 Swoole 的内容我们将来再说，今天，我们先学习学习 OPcache 。

## 什么是 OPcache

*OPcache 通过将 PHP 脚本预编译的字节码存储到共享内存中来提升 PHP 的性能， 存储预编译字节码的好处就是 省去了每次加载和解析 PHP 脚本的开销。*

这是 PHP 文档中关于 OPcache 的简介，也就是说，OPcache 节约了每次加载和解析的步骤，将第一次解析编译后的脚本字节码缓存到系统的共享内存中。其实，这就类似于一个不完全的编译。

类似于 Java 之类的语言，都是要打包编译之后才能上线运行的，比如打包成一个 jar包 。C++ 或 C# 可以打包成一个 .dll 或 .exe 。这些打包之后的文件就是编译完成的文件，将它们运行起来后一般会一直保持运行状态，也就是会成为一个常驻进程，它们的代码就进入内存中了。在程序运行的时候，不需要再进行解释或编译，自然速度就要快很多。而 OPcache 也是起到类似的作用。只不过它并不是完全的一套编译流程，我们还是依赖的 PHP-FPM 来运行脚本，只不过在开启 OPcache 后，PHP-FPM 会先从内存中查找是否已经有相关的已经缓存的字节码在内存中了，如果有的话就直接取用，如果没有的话，会再次进行解释编译后缓存下来。另外，OPcache 是针对文件的，也就是说，一个文件如果是新增加进来的，只有运行过它才会缓存，如果没有运行过，它并不在当前的共享内存中。

## 安装 Opcache

OPcache 已经是 PHP 的官方扩展并随安装包一起发布了，所以，我们可以在编译安装 PHP 时使用 --enable-opcache 来开启扩展，它已经是默认扩展。也可以在未安装 OPcache 的系统中使用安装包中的文件来进行安装。

```php
cd php-7.4.4/ext/opcache/
phpize
./configure
make && make install
```

需要注意的是， OPcache 和 Xdebug 在生产环境中尽量不要一起使用。本身 Xdebug 就是不推荐在生产环境中使用的，如果一定需要同时使用的话，需要先加载 OPcache ，然后再加载 Xdebug 。

扩展安装后，在 php.ini 文件中打开扩展。需要注意的是，OPcache 扩展是 Zend 扩展包，所以我们需要打开的是 Zend 扩展。

```php
zend_extension=opcache.so
```

另外，还需要启用它。

```php
opcache.enable=1
```

当开启了 OPcache 之后，我们再更新代码将会发现刚刚更新的代码不是我们最新的代码。这是因为代码已经被缓存了，就像 Java 一样，我们需要重启服务才行。那么 PHP 这边重启的是什么呢？当然就是重启下我们的 PHP-FPM 就可以了，直接使用 kill -USR2 命令去重启主进程就行了。这里也给出一个快速重启的命令。

```php
ps -ef | grep "php-fpm: master" | grep -v grep | cut -c 9-15 | xargs kill -USR2
```

## ab 测试效果

我们进行测试的内容是测试环境的一台2核4G的服务器，使用的 PHP 版本是 PHP7.4 ，正常的 Nginx 及 PHP 配置， ulimit 也都开到了最大。代码只是简单的输出了一行文字，不过我们使用的是一个简单的 mvc 框架 ，也就是说这段代码运行起来至少也会加载几个文件，而不是简简单单的一个文件。

首先我们来看未开启 OPcache 的情况。

![https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202005/img/ab1.png](https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202005/img/ab1.png)

接下来是开启了 OPcache 的情况。

![https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202005/img/ab2.png](https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202005/img/ab2.png)

很明显，性能有了很大的提高。不仅速度快了很多，吞吐率也是直接上升了几倍。当然，这只是非常简单的一个测试，不过总体看来，确实对单机的性能提升有很大的帮助。最最主要的是，同样的并发情况下，CPU 资源也比未开启的状态下低了70%。

## 配置参考

在 PHP 的官方文档中，已经为我们给出了一套默认的 OPcache 在 php.ini 中的配置。经过测试，基本没什么问题，当然，现在还没有在生产环境中使用过，还需要进行更多的测试。不过文档中指出，这套配置是可以直接运用到线上的，不过需要注意的是某些使用了注解之类功能的高级框架可能需要注意某些参数。

```php
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=1
```

具体的配置说明以及其他的一些配置选项我们可以参考官方文档进行详细的了解。

## 总结

既然是我们的 PHP 大神鸟哥推荐的，而且也是官方推荐的扩展，我觉得在正式生产环境中使用不会有太大问题。另外，官方也给出了一套可以直接运用于线上生产环境的配置参数，也方便我们直接在线上进行测试。目前在生产环境中，我们只使用了一台服务器来进行测试，并且给它多分配了一些负载过来，从目前的情况来看，这一台机器的运行效率比其他几台的高很多。因为它一方面处理了更多的请求，另一方面它的 CPU 资源占用率还没有其他几台机器高。同时，OPcache 也不需要我们去了解更多的进程协程之类的知识，不像 Swoole 一样的会带来更高的学习成本。所以综上所述，在测试完备的情况下，OPcache 绝对是我们最优先考虑的单机优化方案。

参考文档：
[https://www.laruence.com/2015/12/04/3086.html](https://www.laruence.com/2015/12/04/3086.html)
[https://www.php.net/manual/zh/book.opcache.php](https://www.php.net/manual/zh/book.opcache.php)

