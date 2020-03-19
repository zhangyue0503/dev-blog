# 那些对php://伪协议迷糊的人不得不了解的事

相信不少PHP开发者或多或少都见过类似于"php://input"或者"php://output"这样的内容，很多人都知道这两个的作用一个是接收的 POST 请求中的原始 body 内容，另一个其实和 echo 之类的输出一样是进行输出的。当然，我们的文章内容不会如此的简单，其实类似这样的 php:// 开头的协议还有好几种，它们共同称为 PHPIO流协议（PHP输入/输出流协议） 。

这种协议有什么用呢？我们知道计算机中正常的协议有 http:// ，这是我们做web开发最熟悉的。还有 file:// 表示文件，ftp:// 表示ftp协议，当然，还有一些不太常用的 zlib:// 、 data:// 、 rar:// ，等等，这些协议PHP都是支持的，而且这些协议都是约定俗成的并且有相应的文件或流类型支持的协议。通过这些协议我们的程序可以读取、解析这些协议所对应的相关内容。比如说http协议，服务器、客户端浏览器都是因为支持了相同的http协议规范，所以才能够通过这个协议来进行传输，而传输的内容是什么呢？正是我们看到的网页或接口文本。而今天我们的主角 php:// 协议，其实也有另一个别名是 PHP伪协议 。伪协议的原因其实就是这种协议只是PHP自身所支持的并定义的一种协议，而且也仅仅只是 IO 相关操作的一种协议规范。

好了，废话就说到这里，我们来一个一个的看看 php:// 相关的内容都有哪些。

## stdin 输入流

```php
while ($line = fopen('php://stdin', 'r')) {
    $info = fgets($line);
    echo $info;
    if ($info == "exit\n") {
        break;
    }
}

while ($info = fgets(STDIN)) {
    echo $info;
    if ($info == "exit\n") {
        break;
    }
}
```

上述代码有什么用呢？相信做过 C 或者 Java 开发的人会更有感觉，stdin 是获取PHP进程脚本的输入，也就是我们在使用命令行 php xxx.php 运行PHP脚本文件时，获取命令行输入内容的。上述代码就是使用 while 循环一直监听命令行的输入，当你输入内容后进行打印，如果输入的是 exit 就退出循环也就是结束脚本的运行。

这里除了正常的用 fopen() 获取 php://stdin 句柄外，还使用了另一种方式，也就是第二个循环所展示的 STDIN 常量来方便快捷地直接获取输入内容。这也是PHP所推荐的方式。同时，下面讲的 php://stdout 和 php://stderr ，也有相应的 STDOUT 和 STDERR 常量。

## stdout 、 stderr 和 output 输出流

```php
$stdout = fopen('php://stdout', 'w');
fputs($stdout, 'fopen:stdout');
echo PHP_EOL;
file_put_contents("php://stdout", "file_put_contents:stdout");
echo PHP_EOL;

file_put_contents("php://stderr", "file_put_contents:stderr");
echo PHP_EOL;

$output = fopen('php://output', 'w');
fputs($output, 'fopen:output');
echo PHP_EOL;
file_put_contents("php://output", "file_put_contents:output");
echo PHP_EOL;
```

这三种都是输出流，其实就和 echo 、 print 一样，就是将内容打印输出的。不过不同的地方在于，stdin 和 stdout 是针对PHP命令行的输出。也就是说，如果我们是通过浏览器查看这个脚本的话，这两个输出的内容是不会打印到浏览器上的。小伙伴们可以试试用 php -S localhost:8081 <测试文件> 来测试下上述代码，访问 http://localhost:8081 的话，浏览器上会输出 output 打印的内容，而命令行这边则会打印 stdin 和 stdout 所输出的内容。

另外需要注意的，这三个输出流都是只写的，而 stdin 是只读的。也就是说 file_get_contents() 对这三个输出流是没什么用的，而 file_put_contents() 对 stdin 流也是没效果的。

## input 访问请求的原始数据的只读流

这个相信做过接口开发的大多数人都会接触过。当前端或客户端使用 body raw 方便发送数据时，就使用这个协议来接收POST中的原始 body 内容。

```php
echo file_get_contents("php://input");
```

非常简单，这里我们直接使用 postman 来模拟这种请求，可以看我们是能够正常接收到 body raw 里面的内容的。见下图：
[]()

## memory 、 temp 内存及临时文件流

```php
$mem = fopen('php://memory', 'r+');
for ($i = 0; $i < 10; $i++) {
    fwrite($mem, 'fopen:memory');
}
rewind($mem);
while ($info = fgets($mem)) {
    echo $info, PHP_EOL;
}
fclose($mem);
```

这两个流协议是输入、输出都支持的，它们都是在内存中读写数据。不同的是， php://temp 会在数据超过一定容量时将数据写到临时文件中。这里我们就不演示 temp 的操作了，它和 memory 的操作代码是非常像的。另外需要注意的，它们两个操作都是一次性的，也就是说，如果我们在写入(fwrite)后直接关闭(fclose)了句柄，那么后面再读取的话(fgets)，是无法获取到内容的。

## filter 用于数据打开时的筛选过滤

```php
readfile("php://filter/read=string.toupper/resource=http://www.baidu.com");
echo file_get_contents("php://filter/read=convert.base64-encode/resource=http://www.baidu.com");
```

这个自己试试就知道它的好处了，第一行我们是获取百度页面的内容，并把内容中所有的字母替换成大写字母了。第二个过滤器则是直接将百度首页的内容转成base64编码的内容了，是不是非常强大，我觉得这个功能可以是我们好好开发的一个能力。

## 总结

其实说实话，笔者本人平常也就是用过 php://input 这一个协议而已，偶尔或者说基本一年难得用上几次 stdin 来进行脚本调试，但是，这并不妨碍我们了解学习这些流协议的使用。最主要的是，通过学习后我们更进一步的了解了它们的作用及适用的场景，这样就可以在将来需要的时候灵活使用。

测试代码：

参考文档：
[https://www.php.net/manual/zh/wrappers.php.php](https://www.php.net/manual/zh/wrappers.php.php)
[https://www.php.net/manual/zh/filters.php](https://www.php.net/manual/zh/filters.php)