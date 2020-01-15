# 记一次PHP的Invalid binding type问题

首先说明下环境问题，新旧服务器的迁移。代码在老服务器运行没有任何问题。环境都是PHP7.3，结果新的服务器上流量导过来以后，就报出了如下问题：

```php
FastCGI sent in stderr: "PHP message: PHP Fatal error:  Invalid binding type in /base.inc.php on line 221
```

这个base.inc.php的第221行是什么东东呢？

```php
221 }
```

额，这就有点诡异了。注释掉相关的方法后，报错信息又顺延到下一个花括号的结尾处了。这就神奇了。于是去百度谷歌了半天，并没有什么有用的资料，唯一一个提到的内容是说重新编译一下PHP。

[https://stackoverflow.com/questions/3960323/why-dont-php-attributes-allow-functions](https://stackoverflow.com/questions/3960323/why-dont-php-attributes-allow-functions)

好吧，咱们就重新编译，可是编译完了一旦导流过来，马上就又挂掉。PHP-FPM正常运行，但不是所有的都会出问题，于是测试访问的时候是有的可以有的报错的。再深入对比发现，新服务器为了将来的扩展我们安装了swoole扩展。可能问题就出在这里，马上删掉swoole扩展，问题解决。

在swoole官网也并没有找到相关的信息。预估可能是代码中或者在PHP-FPM的配置中有和swoole不兼容的地方。所以在运行的过程中没有流量的时候正常测试不会有影响，但流量较大的情况下就会产生这种错误。有的时候很多代码看似运行没毛病，但真正的问题往往还是要在大流量高并发的场景下才能体现出来。
