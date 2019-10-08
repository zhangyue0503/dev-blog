## 本系列第四篇文章，也是最后一篇

首先，我们先看看Composer的源码从哪里看起。当然，请您先准备好源码。

composer init或者直接install之后，自动生成了一个vendor目录，这时您需要在文件中手动的require这个vendor目录下的autoload.php文件，其实这个文件又载入了vendor/composer/autoload\_real.php。

在autoload\_real.php中，我们发现了熟悉的spl\_autoload\_register函数。但这个文件最大的作用是去加载ClassLoader.php这个文件和一些目录文件，也在同级目录下。这个文件就值得大家好好研究下了，不过核心也无外乎前面三篇文章中的内容。但是在autoload\_real.php中，大家可以发现在调用ClassLoader的register()函数前，还加载了几个目录相关的文件：

- autoload\_static.php，静态加载方式，顶级类加载命名空间
- autoload\_psr4.php，遵守PSR4规范的包目录映射数组文件
- autoload\_namespaces.php，命名空间映射，PSR0规范
- autoload\_classmap.php，类图映射，命名空间直接映射路径

好深奥的感觉，不过PSR4您一定已经很了解了。其他的其实就是对应的没有遵守PSR4规范的一些类库。而在ClassLoader中的register()函数就是加载的这些文件中对应的路径文件。在这里，最好的方式是您可以多下载一些包，然后看看这些文件发生了什么改变。比如我安装了一个monolog后，autoload\_psr4.php的内容变成了这样：

![image](https://mmbiz.qpic.cn/mmbiz_png/KMwYptRJicTwI3XwWEBeFTnicMXmvwT7vXLlga9FV640fbE0WRhOj3EVOZrzJrzibnCAia21ibjhgPtoVwzVyMnpTGw/640?wx_fmt=png&wxfrom=5&wx_lazy=1&wx_co=1)

接下来，composer这个命令干了什么您应该也就了解了。当您进行composer require时，首先修改了composer.json文件，然后下载包，完成后根据包里的composer.json文件中所对应的规范来修改对应的autoload\_xxx.php文件。完成了文件命名空间相关内容的映射。当register()进行加载的时候，自然就得心应手了。

ClassLoader源码中重点阅读的一些函数内容包括：

- findFile()
- findFileWithExtension()
- addPsr4()
- add()

相关参考文档：

[深入解析 composer 的自动加载原理](https://segmentfault.com/a/1190000014948542)

[Composer概述及其自动加载探秘](https://www.cnblogs.com/kelsen/p/laravel-composer.html)

[Composer文档](https://docs.phpcomposer.com/00-intro.html)

[PSR规范](https://psr.phphub.org/)

---

至此，深入学习Composer原理相关内容更新完成。其实还有更多可以学习的内容，比如安装时的install文件其实也是个php文件。composer命令也是个phar文件，也就是完全PHP实现的，源码的Github地址：[https://github.com/composer/composer](https://github.com/composer/composer)。也许在将来我们可以再深入的研究研究核心composer命令行相关的源码。到那时，再开一个系列文章再说，而这回，就先到这里吧！！