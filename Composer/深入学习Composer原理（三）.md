## 本系列第三篇文章，一起了解下PSR规范中的PSR4和PSR0规范

首先恭喜大家，包括我自己，坚持到了现在。这篇文章之后，Composer的基础原理就清晰明了咯。也就是说，Composer所利用的正是spl_autoload_register()和PSR4规范，然后通过线上服务器存储包，来实现包管理的功能。spl_autoload_register()的作用我们已经清楚了，主要就是动态加载我们所需要的文件。然而我们的文件不可能都乱七八糟的随便找个目录放下，然后注册一堆的spl_autoload_register()来加载吧，要真这么写，估计你的老板会废了你。在这个时候，PSR路径规范的作用就显示出来咯！！

本文参考PSR规范：[https://psr.phphub.org/](https://psr.phphub.org/)

#### PSR4的格式

> \\<命名空间>(\\<子命名空间>)*\\类名

具体的内容直接上文中提供的参考链接，这里总结重要的几点：

- 顶级命名空间必须有一个
- 子命名空间可以多个或没有
- 类名必须有
- 大小写敏感，下划线无实际意义（注意，下划线是主要的和PSR0的区别）

#### 类名与文件载入的对应

- 去掉最前面的命名空间的分隔符，前面的命名空间作为[命名空间前缀]，必须与至少一个[文件基目录]对应
- 子命名空间与[文件基目录]下的文件夹对应，命名空间分隔符号作为目录分隔符号
- 末尾的类名，与最终目录下的对应的.php文件相同
- autoload的实现不可出现异常，也就是要解决掉异常问题

估计各位看得一脸懵逼吧！！

其实很好理解，举例说明，我们先建立一个目录叫myvendor，里面放着常用的工具包，如图：

![image](https://mmbiz.qpic.cn/mmbiz_png/KMwYptRJicTylCHg9kexOI29Yia1wZia1wHLt6YvEW13qaAPqhIPlGNbM2vWLxOBBLnvicfsBvf8QDCvcYrX68LaibA/640?wx_fmt=png&wxfrom=5&wx_lazy=1&wx_co=1)

那么TestClass.php的命名空间应该是Test，而CaseClass的应该是CaseModel\\CaseChild。统一从myvendor这个文件夹作为入口进入。也就是myvendor是一个超级[基目录]，然后Test和CaseModel是对应命名空间的两个[文件基目录]，剩下的子个名空间与目录对应。官网中还有其他的展示方式，但在这里我们用这种最标准的方式。

其实说白了，就是命名空间和目录对应上，写代码找文件就方便得很啦！！

上面说的是PSR4的规范，那么PSR0又是什么鬼？目前来说PSR0已经废弃了，它们两个大部分内容还是相近的，最大的区别在于PSR0中的\_这个符号是有意义的，也就是/namespace/package/Class\_Name这样的内容，会去提供/namespace/package/Class/Name.php文件，而PSR4中则忽略\_这个符号的意义，还是去查找Class_Name.php这个文件。

> TestClass.php代码

```php
<?php

namespace Test;


class TestClass
{
    public function show()
    {
        echo "we are family!\n";
    }
}
```

> CaseClass.php代码

```php
<?php

namespace CaseModel\CaseChild;

class CaseClass
{
    public function show()
    {
        echo "Good!\n";
    }
}

```

接下来，在myvendor目录外面添加一个psr4.php文件，代码如下：

```php
<?php

spl_autoload_register(function ($class) {
    $vendor = __DIR__ . '/myvendor';
    $file   = $vendor . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use CaseModel\CaseChild\CaseClass;
use Test\TestClass;

$t = new TestClass();
$t->show();

$c = new CaseClass();
$c->show();

```

神奇的事情发生了，文件自动加载进来了，有点高大上吧，至此，关于Composer的自动加载部分就结束了。我们一起学习到了PHP是如何通过spl_autoload_register方法来自动加载文件，并且通过PSR4规范来形成约束，让大家都有一套统一的规范。而这些，正是Composer的灵魂和肉身。

完整源码：[https://github.com/zhangyue0503/php-blog-code-resource/tree/master/composer/base/psr4namespace](https://github.com/zhangyue0503/php-blog-code-resource/tree/master/composer/base/psr4namespace)
