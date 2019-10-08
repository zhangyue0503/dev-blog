Composer作为PHP的包管理工具，为PHPer们提供了丰富的类库，并且让PHP重焕新生，避免被时代淘汰的悲剧。可以说，Composer和PHP7是现在PHP开发者的标配，如果你还没用过Composer或者在PHP7的环境下工作，那么还真是有点落伍了哦！

这次的系列文章将一步步的解析Composer原理，不会去讲解Composer的命令或者如何使用，这方面的内容您可以稳步Composer中文网：[https://www.phpcomposer.com/](https://www.phpcomposer.com/)

---

## 第一篇主要了解一个简单的函数：__autoload()魔术方法


```php
<?php

$m = new TestClass();
$m->show();

function __autoload($className)
{
    require $className . '.php';
}

```

学习编程，第一步一定是把代码敲下来，请新建一个文档叫作autoload.php，并把上面的代码复制进去。

然后在同级目录新建一个TestClass.php文件，将以下代码放入TestClass.php中：

```php
<?php

class TestClass
{
    public function show()
    {
        echo 'we are family!';
    }
}

```

接下来，你可以通过网页形式访问autoload.php，或者我更推荐的直接在命令行运行：php ./autoload.php

神奇的事情发生了，我们并没有在autoload.php上方显式的使用 **require()** 和 **include** 之类的函数，而是在__autoload()中使用了 **require $className . '.php';** 这段语句，就完成了TestClass.php文件的加载。

没错，我估计您也猜到了，__autoload()这个魔术方法的作用就是在调用的类如果没有加载的情况下，就进入到这个方法中。

### 在PHP官方文档的解释中是这样定义的

> 尝试加载未定义的类

### 函数格式

> __autoload( string $class ) : void

- 参数$class是没有加载类的类名，也就是上方的TestClass
- 返回值是空
- 一般在函数内部会根据$class去加载指定文件

---

这个方法在PHP7.2后会提示DEPRECATED，在未来的版本中可能会删除。我们将再下一篇文章中讲解的spl_autoload_register()函数将是自动加载的未来。使用自动加载函数的好处：**不需要在文件顶部一大串的require**。

嗯，已经了解了__autoload()是干嘛的，但是这和Composer有什么关系？

别急，任何牛X的技术总有一个基础，没有这个条件这项技术就很难实现，就像人工智能，虽然早就有了各种算法和理论，但在大数据技术盛开之前总是无法落地。因为机器学习需要的大量数据如何存取实在是个难点。在这里，Composer就像是AI技术，而__autoload()方法就是那个基石。

完整源码：[GitHub](https://github.com/zhangyue0503/php-blog-code-resource/tree/master/composer/base)