## 本系列的第二篇文章，这次我们聊聊：spl_autoload_register()函数

PHP的SPL库作为扩展库，已经于5.3.0版本后默认保持开启，成为PHP的一组强大的核心扩展库。大家有时间可以多研究研究SPL里面的方法功能。而且，SPL中包含很多类库哟，在设计模式的系列文章中，我们也会再次见到他们的身影！

这回我们建立一个文件，叫做spl_autoload_register.php，然后将下面的代码复制进去吧：

```php

<?php

spl_autoload_register(function( $className ){
    require $className . '.php';
});

$m = new TestClass();
$m->show();



```

是不是和__autoload()很像，当然作用也很像。我们直接运行这个文件试试，会发现TestClass.php也正常的加载了进来。那么为啥不直接用__autoload()函数，而使用sql_autoload_register()这么诡异的函数，而且还有个神奇的闭包参数！！！

我们先看看它的定义和格式

#### PHP官方文档中的定义

> 注册给定的函数作为 __autoload 的实现

没错，那个匿名函数就是一个__autoload()函数，我们可以理解为给当前这个PHP文件中注册一个__autoload()函数，而使用匿名函数的原因呢？当然就是为了闭包特性，最主要的就是能够带来延迟加载（懒加载 ）的实现！

另外，spl_autoload_register()函数不止是仅仅去注册一个__autoload()，它实现并维护了一个__autoload()队列。原来在一个文件中只能有一个__autoload()方法，但现在，你拥有的是一个队列。

#### 函数格式

> spl_autoload_register ([ callable $autoload_function [, bool $throw = true [, bool $prepend = false ]]] ) : bool

有点长，我们一步步看：
- callable $autoload_function：闭包函数，不多解释了，上面已经说了，不了解闭包函数的作用可以百度百度
- bool $throw：当$autoload_function无法成功注册时，是否抛出异常
- bool $prepend：如果是true，将会添加一个__autoload()函数到队列的顶部
- 这个函数有返回值，成功或失败

#### 改造代码

嗯，到这里好像有点复杂了，我们需要改造改造代码这样才能让大家看得更清晰，先准备另一个需要加载 的类文件，就叫CaseClass.php好了

```php
<?php

class CaseClass
{
    public function show()
    {
        echo "Good!\n";
    }
}

```

然后修改spl_autoload_register.php文件

```php
<?php

// 使用匿名函数方式
spl_autoload_register(function( $className ){
    echo "first==>\n";
    require_once 'TestClass.php';
});

// 需要注册的外部__autoload()实现
spl_autoload_register('CaseAutoLoad');

function CaseAutoLoad( $className ){
    echo "second==>\n";
    require_once 'CaseClass.php';
}

$m = new TestClass();
$m->show();

echo "--------\n";

$s = new CaseClass();
$s->show();

```

什么都别说了，直接运行吧，如果有报错请检查下哪里写错了，反正我这里没错~~

正常情况下应该输出这样的内容

![image](https://mmbiz.qpic.cn/mmbiz_png/KMwYptRJicTyJkYRchqQ1nIDYkKXLvWAzJq0NvD1z6lZumV728ARXS9SC73R3gVbsC5kbfWRKxL6FvebWUI8CmQ/640?wx_fmt=png&wxfrom=5&wx_lazy=1&wx_co=1)

1. "first==>"是我们原来的spl_autoload_register()函数输出的内容，这里我们没有使用$className来动态加载，而是只加载TestClass.php这一个文件
2. 接下来我们便输出了TestClass里面的show()方法的内容。需要注意的是：**这里可还没有加载CaseClass.php这个文件哦，也就是现在我们已经实现了懒加载了哦**
3. 接下来，我们想要实例化CaseClass对象，于是spl_autoload_register()维护的队列发挥作用了。先走第一条，利用require_once()对于之前已经加载过的TestClass.php不会再次加载了。但是这一个文件中并没有找到我们需要的CaseClass对象，于是我们进入了队列第二条，来到了CaseAutoLoad()方法中，CaseClass.php终于在这个方法中被require_once()进来了

到这里，你已经知道了这个函数最大的作用就是维护的这个队列并且可以延迟加载我们需要的文件。是不是感觉有点要走上人生巅峰了？不不不，你心里或许还在疑惑，这玩意跟Composer有啥关系？

请在您需要测试的目录初始化一个Composer

- 进入vendor/composer/autoload_real.php中
- 在getLoader()方法中马上就能发现spl_autoload_register()方法
- 然后在最底下有个$loader->register(true);方法-- 简单的阅读代码我们发现其实这个$loader就是ClassLoader类
- 进入ClassLoader.php文件中，找到register()方法- 没错，里面还是一个spl_autoload_register()方法，这样来看，这货就是Composer的灵魂啊！！

OK，走到这里，其实在面试的时候就可以跟面试官司吹牛了，Composer的原理？spl_autoload_register()方法嘛。说不定确实有不少人就被你唬住了，但是，对于Composer来说，我们还有一个非常重要的方面不能忽略，可以将它看作是Composer的血肉，让自动加载能够有形，成为一个有灵魂有躯体的完整的人，这就是PSR规范中的PSR0和PSR4规范，下篇我们就聊聊这俩货！

完整源码：[GitHub](https://github.com/zhangyue0503/php-blog-code-resource/tree/master/base)
