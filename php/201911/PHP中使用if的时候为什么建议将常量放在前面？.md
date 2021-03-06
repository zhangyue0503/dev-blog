# PHP中使用if的时候为什么建议将常量放在前面？

在某些框架或者高手写的代码中，我们会发现有不少人喜欢在进行条件判断的时候将常量写在前面，比如：

```php

if(1 == $a){
    echo 111;
}

```

这样做有什么好处呢？我们假设一个不小心的粗心大意，少写了一个=号，会有什么结果。

```php

$a = 'a';
if($a = 'b'){
    echo 111;
}
echo $a;

```

没错，111输出了，$a的值也变成了b。少了一个等号，就变成了赋值操作，这样的操作会先给$a赋值，然后根据$a的值进行判断。如果$a = ''，就不会输出111，但是$a的值还是会变成''。

**划重点：这样的写法php是不会报错的，这也是有可能造成BUG的情况。**

那么反过来呢？

```php

$a = 'a';
if('b' = $a){
    echo 111;
}

```

首先，大部分的IDE都会报语法错误，也就是直接划红线了。常量是不能被赋值修改的，不管是数字、字符串还是系统或者我们自己已经定义了的常量。

其次，这种情况下你要是还发现不了这里有问题的话也没关系，运行起来也会报错的，代码是无法继续向下运行的。

当然，这只是一个小技巧，而且最主要的目的是为了应对粗心带来的问题。所以并不是强制的规范，有些公司可能会在代码审计或者规范文档中强调这样写法，当然，最好的还是我们要杜绝这种粗心带来的错误。

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E4%B8%AD%E4%BD%BF%E7%94%A8if%E7%9A%84%E6%97%B6%E5%80%99%E4%B8%BA%E4%BB%80%E4%B9%88%E5%BB%BA%E8%AE%AE%E5%B0%86%E5%B8%B8%E9%87%8F%E6%94%BE%E5%9C%A8%E5%89%8D%E9%9D%A2%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/source/PHP%E4%B8%AD%E4%BD%BF%E7%94%A8if%E7%9A%84%E6%97%B6%E5%80%99%E4%B8%BA%E4%BB%80%E4%B9%88%E5%BB%BA%E8%AE%AE%E5%B0%86%E5%B8%B8%E9%87%8F%E6%94%BE%E5%9C%A8%E5%89%8D%E9%9D%A2%EF%BC%9F.php)
