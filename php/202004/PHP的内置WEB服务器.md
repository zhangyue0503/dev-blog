# PHP的内置WEB服务器

在很多时候，我们需要简单的运行一个小 demo 来验证一些代码或者轮子是否可用，是否可以运行起来，但是去配 nginx 或者 apache 都很麻烦，其实，PHP CLI 已经提供了一个简单的测试服务器，我们直接就可以运行起来进行简单的一些测试工作。

## 直接启动一个内置服务器

```php
php -S localhost:8081
```

直接使用 -S 命令选项，然后指定地址及端口号，我们就可以运行起来一个 PHP 内置的简易WEB服务器。默认情况下，这个地址会找当前目录下的 index.php 或 index.html 文件。当我们在浏览器输入指定的文件时，就是访问指定的文件，如果都没有找到会正常的返回404错误。

而控制台会输出当前服务器的访问情况，如下图所示：

![https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202004/img/PHP%E7%9A%84%E5%86%85%E7%BD%AEWEB%E6%9C%8D%E5%8A%A1%E5%99%A8.png](https://raw.githubusercontent.com/zhangyue0503/dev-blog/master/php/202004/img/PHP%E7%9A%84%E5%86%85%E7%BD%AEWEB%E6%9C%8D%E5%8A%A1%E5%99%A8.png)

这个内置服务器和用 nginx 等服务器搭起来的应用服务器本质上没有太大的区别，包括 $_SERVER 之类的内容都可以正常获取到，也可以正常使用 include 等功能加载其他文件，也就是说这个内置WEB服务器运行一些框架也是没有问题的。它是可以完全满足我们的测试要求的。但是需要注意的是，这个内置WEB服务器不能用于生产环境。毕竟它的功能还是太简单，不是一个生产配备的高规格服务器应用。

## 指定内置服务器的运行目录

我们也可以在任何目录去运行指定目录的php代码，只需要再增加一个 -t 选项来指明要运行起服务器的根目录即可。

```php
php -S localhost:8081 -t dev-blog/php/202004/source
```

这样我们就可以运行起来一个以 dev-blog/php/202004/source 目录为根目录的测试环境服务器。

## 使用路由脚本

```php
php -S localhost:8081 PHP的内置WEB服务器.php
```

如果我们给当前服务器直接指定了一个PHP文件，那么直接打开链接就会访问的是这个文件的内容，而不是去找 index.php 之类的文件。即使我们继续给 URL 后台增加其他路径或者其他文件名，它依然会打开的是这个文件，也就是说，我们启动了一个单文件入口的应用服务器程序。就像各种框架的 index.php 文件一样，比如我们利用这个文件做一个简单的路由分发测试：

```php
$routePages = [
    '/testRoute2.php',
    '/route/testRoute1.php'
];

if(in_array($_SERVER['REQUEST_URI'], $routePages)){
    include __DIR__ . $_SERVER['REQUEST_URI'];
}else{
    print_r($_SERVER);
}
```

```php
// route/testRoute1.php
echo "Hello Route1!";

// testRoute2.php
echo "Hello Route2!";
```

两个测试文件只是简单的输出了一段文字用于区别分别加载了两个文件。上述代码的意思是我们访问定义好的两个路由路径时，就会加载对应的文件，访问其他路径则会打印当前服务器的 $_SERVER 信息。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E7%9A%84%E5%86%85%E7%BD%AEWEB%E6%9C%8D%E5%8A%A1%E5%99%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E7%9A%84%E5%86%85%E7%BD%AEWEB%E6%9C%8D%E5%8A%A1%E5%99%A8.php)

参考文档：
[https://www.php.net/manual/zh/features.commandline.webserver.php](https://www.php.net/manual/zh/features.commandline.webserver.php)
