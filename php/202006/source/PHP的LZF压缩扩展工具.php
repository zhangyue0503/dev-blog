<?php


$str = "The 2014 World Cup will be hold in .It is a grand occasion for all the football fans all over the world.My favorite team is the Spainish Team.And my favorite football star is Didier Yves Drogba Tébily.I hope the Chinese Tee
am can do well in the World Cup.Because China has never won a World Cup before.This year I hope the situation will change.


When the match begins�~LI hope I can watch it.But if I am busy studying thenn
 I will not watch it.Because study is always the first priority.I wish one day China can hold a World Cup�~Lthen our Chinese can watch the matches withouu
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