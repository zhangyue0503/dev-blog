在服务器上，当我们查看php进程时，全都是php-fpm进程，大家都知道这个就是php的运行环境，那么，它到底是个什么东西呢？

## PHP-FPM简介

PHP-FPM，就是PHP的FastCGI管理器，用于替换PHP FastCGI的大部分附加功能，在PHP5.3.3后已经成为了PHP的标配。

有小伙伴要问了，FastCGI又是什么鬼？CGI程序又叫做“通用网关接口”，就是让Web服务器和你的应用程序进行交互的一个接口。就像nginx中需要配置的fastcgi_pass，一般我们会使用127.0.0.1:9000或者unix:/tmp/php-cgi.sock来配置这个参数。它的意思就是告诉nginx，过来的请求使用tcp:9000端口的监听程序来处理或者使用unix/socket来处理。它们都是指向的PHP运行程序。

再说得通俗一点，我们运行php脚本用的是

```php

php aaa.php 

```

php-fpm就相当于是这个php命令。nginx通过fastcgi_pass来运行php $nginx_root(nginx配置文件中网站根目录root配置)下的index.php。所以，如果你用的是python或者其他什么语言，都可以用它们的cgi程序来让nginx调用。

FastCGI和CGI又有什么不同呢？FastCGI是启动一个socket接口，服务器应用不需要自己去运行php，只需要向这个socket接口提交请求就可以了。

php-fpm在编译php时需要添加--enable-fpm。一些通用的集成安装包如lnmp、phpStudy等都会默认编译并使用php-fpm，毕竟是标配。

## tcp socket与unix socket

上文中说过nginx可以使用127.0.0.1:9000和unix:/tmp/php-cgi.sock这两种方式来调用php-fpm。它们有什么区别呢？

前者，一般带9000端口号的，是tcp形式的调用。也就是php-fpm启动了一个监听进程对9000端口进行监听。它会调起一个tcp/ip服务，nginx在调用的时候会走一次tcp请求流程，也就是3次握手4次挥手，会走到网络七层中的第四层传输层。相对来说这种方式性能会稍差一点，启动php-fpm后使用nestat查看端口中会出现9000端口的占用。

后者，使用的是unix套接字socket服务，通过sock文件来交换信息，性能相对好一些，因为它没有tcp连接过程，也不会有9000端口的占用。

对于高负载大访问量的网站还是推荐使用unix方式，对于普通小网站来说，无所谓使用哪个都可以，tcp方式反而更容易配置和理解，也是php-fpm.conf中默认的监听方式。

php-fpm.conf配置中的listen属性用来配置监听，这里的配置要和nginx中的一致，使用tcp的就监听127.0.0.1:9000，使用unix的就设置成/tmp/php-cgi-56.sock。

## PHP-FPM的功能

以下内容摘自官方文档：

- 支持平滑停止/启动的高级进程管理功能
- 可以工作于不同的 uid/gid/chroot 环境下，并监听不同的端口和使用不同的 php.ini 配置文件（可取代 safe_mode 的设置）
- stdout 和 stderr 日志记录
- 在发生意外情况的时候能够重新启动并缓存被破坏的 opcode
- 文件上传优化支持
- "慢日志" - 记录脚本（不仅记录文件名，还记录 PHP backtrace 信息，可以使用 ptrace或者类似工具读取和分析远程进程的运行数据）运行所导致的异常缓慢;
- fastcgi_finish_request() - 特殊功能：用于在请求完成和刷新数据后，继续在后台执行耗时的工作（录入视频转换、统计处理等）
- 动态／静态子进程产生
- 基本 SAPI 运行状态信息（类似Apache的 mod_status）
- 基于 php.ini 的配置文件

> 本文参考：

- [https://www.php.net/manual/zh/install.fpm.php](https://www.php.net/manual/zh/install.fpm.php)
- [https://www.cnblogs.com/sunlong88/p/9001184.html](https://www.cnblogs.com/sunlong88/p/9001184.html)
- [https://www.jianshu.com/p/34a20e8dbf10](https://www.jianshu.com/p/34a20e8dbf10)
- [https://blog.csdn.net/erlib/article/details/38488937](https://blog.csdn.net/erlib/article/details/38488937)
