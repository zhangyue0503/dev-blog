# PHP中的输出缓冲控制

在 PHP 中，我们直接进行 echo 、 或者 print_r 的时候，输出的内容就会直接打印出来。但是，在某些情况下，我们并不想直接打印，这个时候就可以使用输出缓冲控制来进行输出打印的控制。当然，这一套功能并不仅限出针对打印的内容，我们还可以做其它一些操作，这个我们放到最后再说。

## 清除输出

首先，我们先来看看不让 echo 之类的内容打印输出。

```php
ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
ob_end_clean();
```

相信有不少小伙伴应该见过 ob_start() 这个函数，它的作用就是开始一段输出缓冲控制。在 ob_start() 之后的代码中的输出语句都会进入输出缓冲区，这个时候，如果我们调用了 ob_end_clean() 、 ob_clean() 或者 ob_get_clean() ，则不会有任何输出了。它们三个的作用都是清除输出缓冲区的内容。具体的区别大家可以参考文章最后给出的函数说明或者官方文档。

## 获得输出缓冲区的内容

```php
ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
$v = ob_get_contents();
ob_end_clean();

echo $v;
```

上面说过，使用了 ob_end_clean() 就会清除输出缓冲区里面的内容，但是在这段代码中，我们使用 ob_get_contents() 函数直接将缓冲区的内容赋值给了变量 \\$v 。这时候，$v 中就有了前面两段 echo 中的内容，也就是说，这个一套操作我们就拿到了本身应该输出的内容，并将它保存在了变量中。这样做有什么用呢？我们可以获得类似于 phpinfo() 、 var_dump() 这些直接输出函数的内容了，并且不会打印在客户端屏幕上。比如：

```php
ob_start();
php_info();
$v = ob_get_contents();
ob_end_clean();

echo $v;
```

在 $v 中的内容就是 php_info() 的内容了。这就是输出缓冲控制的第二个能力。

## 刷新（输出）缓冲区内容

```php
ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
flush();
ob_flush();
```

类似的，我们在缓冲区中想要再次直接输出内容，使用 flush() 、ob_flush() 、 ob_end_flush() 及 ob_get_flush() 就可以了，其实就是相当于让 ob_start() 之后的 echo 这类输出语句重新生效并正常输出。

另外，我们还可以使用一个函数进行自动的刷新。

```php
ob_implicit_flush();

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
```

使用 ob_implicit_flush() 之后，我们就不需要手动地调用 ob_flush() 之类的函数来刷新缓冲区内容了。


## 一些检测函数

```php
ob_start();
ob_start();

echo 123, PHP_EOL;

echo ob_get_length(), PHP_EOL;
// 3

echo ob_get_level(), PHP_EOL;
// 2

print_r(ob_get_status(true));

// Array
// (
//     [0] => Array
//         (
//             [name] => default output handler
//             [type] => 0
//             [flags] => 112
//             [level] => 0
//             [chunk_size] => 0
//             [buffer_size] => 16384
//             [buffer_used] => 0
//         )

//     [1] => Array
//         (
//             [name] => default output handler
//             [type] => 0
//             [flags] => 112
//             [level] => 1
//             [chunk_size] => 0
//             [buffer_size] => 16384
//             [buffer_used] => 17
//         )

// )

ob_get_flush();
```

ob_get_length() 会返回当前缓冲区里面内容的长度，这里我们只打印了一个 123 ，在缓冲区中保存了3个字符，所以输出的正是 3 。ob_get_level() 返回的是当前缓冲区的层级，请注意，我们在上面调用了两次 ob_start() ，也就是有两层的缓冲区，这个缓冲区是可以嵌套的。ob_get_status() 函数是缓冲区的状态信息，字段的说明可以查看官方文档，这里不再赘述。

## 使用 ob_start() 的回调函数来进行输出缓冲区的内容替换

这是一个例子，但是可以推广到其他很功能，比如我们可以用来进行全局的输出过滤、可以做 CSS 或 JS 文件的压缩优化等等。

```php
ob_start(function($text){
    return (str_replace("apples", "oranges", $text));
});

echo "It's like comparing apples to oranges", PHP_EOL;
ob_get_flush();

// It's like comparing oranges to oranges
```

最后的输出结果就是将 apples 内容替换成了 oranges 内容。

## 添加 URL 重写器

```php
output_add_rewrite_var('var', 'value');
// some links
echo '<a href="file.php">link</a>
<a href="http://example.com">link2</a>';

// <a href="file.php?var=value">link</a>
// <a href="http://example.com">link2</a>

// a form
echo '<form action="script.php" method="post">
<input type="text" name="var2" />
</form>';

// <form action="script.php" method="post">
// <input type="hidden" name="var" value="value" />
// <input type="text" name="var2" />
// </form>
```

上面的代码看出什么端倪了嘛？没错，使用 output_add_rewrite_var() 函数，我们可以在 PHP 输出的时候为 HTML 的链接或者表单代码增加一个参数。有没有想到什么使用场景？POST 表单的 CSRF 攻击的防范。

这个函数会根据 php.ini 文件中的 url_rewriter.tags 配置项来进行添加，在默认情况下这个配置项只支持 from 表单，同时，它还可以支持 a 标签的href 、 area标签的href 、 frame标签的src 、 input标签的src 等等。也就是说，会在这些标签相对应的属性中自动添加字段。当然，它也有一个反函数 output_reset_rewrite_vars() 用于取消之前增加的这个参数。

## 总结

关于输出缓冲控制这块还有很多好玩的东西，不过限于篇幅我们先介绍到这里，将来踫到什么好的功能的应用我们再单独讲解。现在基于 Swoole 的应用越来越多，当我们需要将 TP 、 Laravel 这类传统框架转换成支持 Swoole 的时候，往往就需要在入口文件使用输出缓冲控制来进行修改。因为传统框架基本都是直接进行 echo 之类的输出的，而在 Swoole 中，echo 这类的内容是直接打印在控制台的，这就需要我们通过 ob_get_contents() 能力获得全部的输出再通过 response->end() 来进行实际的响应。另外，还有一些其他的场景也会用到输出缓冲控制：

- 1.在PHP中，像header(), session_start(), setcookie() 等这样的发送头文件的函数前，不能有任何的输出，而利用输出缓冲控制函数可以在这些函数前进行输出而不报错
- 2.对输出的内容进行处理，例如生成静态缓存文件、进行gzip压缩输出，这算是较常用的功能了
- 3.捕获一些不可获取的函数输出，例如phpinfo(), var_dump() 等等，这些函数都会将运算结果显示在浏览器中，而如果我们想对这些结果进行处理，则用输出缓冲控制函数是个不错的方法。说的通俗点，就是这类函数都不会有返回值，而要获取这些函数的输出数据，就要用到输出缓冲控制函数
- 4.对一些数据进行实时的输出

最后，再给出输出缓冲控制相关的函数说明，具体内容大家还是要多看官方文档的介绍。

- flush — 刷新输出缓冲
- ob_clean — 清空（擦掉）输出缓冲区
- ob_end_clean — 清空（擦除）缓冲区并关闭输出缓冲
- ob_end_flush — 冲刷出（送出）输出缓冲区内容并关闭缓冲
- ob_flush — 冲刷出（送出）输出缓冲区中的内容
- ob_get_clean — 得到当前缓冲区的内容并删除当前输出缓。
- ob_get_contents — 返回输出缓冲区的内容
- ob_get_flush — 刷出（送出）缓冲区内容，以字符串形式返回内容，并关闭输出缓冲区。
- ob_get_length — 返回输出缓冲区内容的长度
- ob_get_level — 返回输出缓冲机制的嵌套级别
- ob_get_status — 得到所有输出缓冲区的状态
- ob_gzhandler — 在ob_start中使用的用来压缩输出缓冲区中内容的回调函数。ob_start callback function to gzip output buffer
- ob_implicit_flush — 打开/关闭绝对刷送
- ob_list_handlers — 列出所有使用中的输出处理程序。
- ob_start — 打开输出控制缓冲
- output_add_rewrite_var — 添加URL重写器的值（Add URL rewriter values）
- output_reset_rewrite_vars — 重设URL重写器的值（Reset URL rewriter values）

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E8%BF%98%E6%90%9E%E4%B8%8D%E6%87%82PHP%E4%B8%AD%E7%9A%84%E8%BE%93%E5%87%BA%E7%BC%93%E5%86%B2%E6%8E%A7%E5%88%B6%EF%BC%9F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202005/source/%E8%BF%98%E6%90%9E%E4%B8%8D%E6%87%82PHP%E4%B8%AD%E7%9A%84%E8%BE%93%E5%87%BA%E7%BC%93%E5%86%B2%E6%8E%A7%E5%88%B6%EF%BC%9F.php)

参考文档：

[https://www.php.net/manual/zh/ref.outcontrol.php](https://www.php.net/manual/zh/ref.outcontrol.php)

[https://www.php.net/manual/zh/session.configuration.php#ini.url-rewriter.tags](https://www.php.net/manual/zh/session.configuration.php#ini.url-rewriter.tags)

[https://blog.csdn.net/xiaofan1988/article/details/43124359](https://blog.csdn.net/xiaofan1988/article/details/43124359)

