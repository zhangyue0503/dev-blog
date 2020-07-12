# PHP的LZF压缩扩展工具

这次为大家带来的是另外一个 PHP 的压缩扩展，当然也是非常冷门的一种压缩格式，所以使用的人会比较少，而且在 PHP 中提供的相关的函数也只是对字符串的编码与解码，并没有针对文件的操作。所以就像 Bzip2 一样，我们也可以用它来进行一些加密传输的操作。

LZF 扩展直接在 phar.php.net 下载安装即可，也是走得正常的 PHP 的扩展安装的步骤。LZF 压缩算法基于 Lempel-Ziv ，并使用了有限状态熵编码。LZF采用类似 lz77 和 lzss 的混合编码。使用3种 “起始标记” 来代表每段输出的数据串。关于 LZF 压缩的信息非常少，仅有的查询结果显示是它是 Apple 开源的一种非常简单的字符压缩算法。

## 基本函数使用

```php
$str = "The 2014 World Cup will be hold in .It is a grand occasion for all the football fans all over the world.My favorite team is the Spainish Team.And my favorite football star is Didier Yves Drogba Tébily.I hope the Chinese Tee
am can do well in the World Cup.Because China has never won a World Cup before.This year I hope the situation will change.


When the match begins, I hope I can watch it.But if I am busy studying thenn
 I will not watch it.Because study is always the first priority.I wish one day China can hold a World Cup, then our Chinese can watch the matches withouu
t going abroad.


Maybe one day my dream can come true.";

$c = lzf_compress($str);
echo $c, PHP_EOL;
// The 2014 World Cup will be ho in .It is a grand occasion for a *t Bfootb@
//                                                                          fan * over`w@X.My
// vorite team@Q@8	Spainish T .A _m�)�Vstar@2Didi WYves Drogba Tébily.I �p \ �Chchange.	 can do we � �@��.Becau )@1a has ne@�w �a�'! �e.Thye ��msituatAa9


// When`omatch Cgins，�;I`�w`it.Bu!ff !busy �udying@Bn `]not�2��s@)Aalways@0	 first priAsAwAeone day��Aa��� �!"n our`%AG@'�� ��!witho �go@�abroad@�May"=�i!�dr!�`Dcom!�rue.

$v = lzf_decompress($c);
echo $v, PHP_EOL;
// The 2014 World Cup will be hold in .It is a grand occasion for all the football fans all over the world.My favorite team is the Spainish Team.And my favorite football star is Didier Yves Drogba Tébily.I hope the Chinese Team can do well in the World Cup.Because China has never won a World Cup before.This year I hope the situation will change.


// When the match begins，I hope I can watch it.But if I am busy studying then I will not watch it.Because study is always the first priority.I wish one day China can hold a World Cup，then our Chinese can watch the matches without going abroad.

echo lzf_optimized_for(), PHP_EOL;
// 1
// 如果LZF针对速度进行了优化，则返回1；对于压缩，则返回0。
```

LZF 全部就只提供了这三个非常简单的函数。lzf_compress() 用于对字符串进行压缩编码，可以看出我们输出的压缩之后的内容已经变成了乱码的形式。但是相对于 Bzip2 完全看不懂的编码内容来说，LZF 是可以看到原文的一部分内容的。lzf_decompress() 用于解码已经编码的字符串内容。lzf_optimized_for() 输出的是 LZF 扩展的编译后运行状态，如果返回的是 1 ，则表明针对当前系统的速度进行了优化，如果返回的是 0 ，表示的是仅仅是进行了压缩编码。

## 中文支持

```php
$str = "如今我们站长做网站会越来越多的选择服务器，而不是虚拟主机。但是在选择服务器之后，我们大部分网友会直接使用宝塔面板、LNMP等一键安装WEB系统去配置网站环境。有些软件确实是在不断的升级和维护且安全功能做的不错，但是有些可能还没有考虑到安全问题。

因为大部分软件提供商都更多的考虑到功能，对于细节的安全做的还是不够的，比如前一段时间由于THINKPHP框架的漏洞导致安装THINKPHP的程序被黑，同时也影响到同一台服务器中的其他网站也有被黑掉，所以对于安全问题还是需要单独的处理";

$c = lzf_compress($str);
echo $c, PHP_EOL;
// 如今我们站长做网
//                 会越来 多的选择服务器，而不��虚拟主机。但 在�2之后 8�大部分 q有些软件� 5���@��� �升级和维护且 全功能A系统去配置 H �环境 �
//                                         �� ,错 ��ՀS可  还没考虑到�>问题 �

// 因为�逋提供商都更�^�C`| p
//                          对于细节 ��[��@y�� �够  比如前!!
// THINKPHP框架 .                                           段时间由 A
//               漏洞导致 U!J�"
//                              程序被黑 W同 也影响@��!��台�
// �aL��他�=��A`D掉 G所以�� s!d�%��
//                                 需要单独 �处理�

$v = lzf_decompress($c);
echo $v, PHP_EOL;
// 如今我们站长做网站会越来越多的选择服务器，而不是虚拟主机。但是在选择服务器之后，我们大部分网友会直接使用宝塔面板、LNMP等一键安装WEB系统去配置网站环境。有些软件确实是在不断的升级和维护且安全功能做的不错，但是有些可能还没有考虑到安全问题。

// 因为大部分软件提供商都更多的考虑到功能，对于细节的安全做的还是不够的，比如前一段时间由于THINKPHP框架的漏洞导致安装THINKPHP的程序被黑，同时也影响到同一台服务器中的其他网站也有被黑掉，所以对于安全问题还是需要单独的处理
```

当然，LZF 对中文也是良好支持的。同样的在编码后的内容中也是有部分内容是可见的。

## 总结

全部下来就只有这三个函数的一个压缩算法的扩展，是不是非常的简单方便。就像上面所说的，一是对于字符串的存储节约空间，二是可以做为某些传输的加密实现。当然，这个算法并不是完全的编码，所以我们还是能够看到原文的内容的。其实从这方面我们可以和 Bzip2 对比下，Bzip2 是二进制编码的，所以编码后的内容是完成乱码的。而 LZF 是非二进制的，采用一种熵算法的压缩算法，自然会有很多内容是肉眼可见的。最终，还是要取决于我们的业务形态来决定采用哪种具体的压缩扩展工具。

测试代码：



参考文档：

[https://www.php.net/manual/zh/book.lzf.php](https://www.php.net/manual/zh/book.lzf.php)
[https://www.cnblogs.com/pengze0902/p/5998843.html](https://www.cnblogs.com/pengze0902/p/5998843.html)