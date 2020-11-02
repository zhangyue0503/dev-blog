# PHP的加密伪随机数生成器的使用

今天我们来介绍的是 PHP 中的加密伪随机数生成器（CSPRNG 扩展）。随机数的生成其实非常简单，使用 rand() 或者 mt_rand() 函数就可以了，但是我们今天说的这个则是使用了更复杂算法的一套随机数生成器。rand() 已经不是很推荐使用了，mt_rand() 的生成速度更快一些，也是现在的主流函数，而加密的伪随机数生成函数则是密码安全的，速度会比 mt_rand() 略慢一点。它需要依赖操作系统的一些函数，这个我们后面再说。

这个加密扩展已经集成在 PHP7 中，不需要特别的安装，如果是 PHP7 以下的版本需要独立安装扩展。如果在测试时找不到下面介绍的函数，请检查当前 PHP 的版本。

## 伪随机字符生成

```php
var_dump(random_bytes(5));
// string(10) "0681109dd1"
```

random_bytes() 每次调用都会生成不同内容的字符串，而参数则是字符长度的随机字符，在这里我们传递的是 5 ，返回了 10 个字符，可以看出这个参数是字符数量，而返回的其实是字节数量，对应一个字符占用两个字节的返回形式。或者我们就直接记住它返回的就是参数的两倍即可。至于这个函数的作用嘛，可以为我们生成安全的用户密码 salt 、 密钥关键字 或者 初始化向量。

## 伪随机整数生成

```php
var_dump(random_int(100, 999));
var_dump(random_int(-1000, 0));
// int(900)
// int(-791)
```

对于整数数字的生成就更简单了，为 random_int() 函数提供两个参数，也就是随机整数的范围就可以了。其实和 mt_rand() 的用法一样。

## 生成来源

上述两种加密伪随机函数的生成来源都是依赖于操作系统的，具体如下：

- 在 Windows 系统，会使用 CryptGenRandom() 函数。从7.2.0开始使用CNG-API
- 在 Linux 系统,会使用 Linux getrandom(2) 系统调用
- 在其他系统,会使用 /dev/urandom
- 否则将抛出异常

## 异常情况

这两个函数也有相应的异常情况会出现，比如上面找不到生成来源的话就会抛出异常，当然，除了这个之外还会有其它的因素也会导致异常的发生。

- 如果找不到适当的随机性来源，将抛出异常
- 如果给定的参数无效，将引发 TypeError
- 如果给定的字节长度无效，将引发错误

## 总结

今天的内容非常简单，而且还发现了 random_bytes() 这个函数的秒用，以后不用再自己去写随机生成 salt 的函数了，就像我们之间介绍密码加盐文章中 [什么叫给密码“加盐”？如何安全的为你的用户密码“加盐”？](https://mp.weixin.qq.com/s/yajIbFH3ghFzQ3Onqc3zNA) 的那个随机字符生成函数（generateSalt）基本就可以用这个来替代了。是不是感觉收获满满呢，学习的脚步从未停下，让我们继续一起探索更好玩的内容吧！！

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84%E5%8A%A0%E5%AF%86%E4%BC%AA%E9%9A%8F%E6%9C%BA%E6%95%B0%E7%94%9F%E6%88%90%E5%99%A8%E7%9A%84%E4%BD%BF%E7%94%A8.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84%E5%8A%A0%E5%AF%86%E4%BC%AA%E9%9A%8F%E6%9C%BA%E6%95%B0%E7%94%9F%E6%88%90%E5%99%A8%E7%9A%84%E4%BD%BF%E7%94%A8.php)

参考文档：

[https://www.php.net/manual/zh/book.csprng.php](https://www.php.net/manual/zh/book.csprng.php)