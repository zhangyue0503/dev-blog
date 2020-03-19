# 关于PHP中的请求上下文的相关知识

我们首先来了解下什么是上下文。在我们写文章，写句子时，都会考虑一个观点或者内容的前后逻辑，转承启合，而在这个观点前后的内容就可以看成是它的上下文内容。它包含了语境的意味在里面，其实代码世界中的上下文也是一样的意思，本身 Context 这个单词就是环境、背景的意思。

接下来，我们来说说请求上下文又是什么呢？比如说我们要使用PHP来请求一个链接地址，通常我们会使用 curl 来进行请求，但是 curl 的配置其实是比较复杂的，所以我们在简单使用的情况下会使用 file_get_contents() 这种函数来快捷地请求链接。不过，可能很多人并不知道或者说没怎么使用过它的上下文参数。其实，使用了上下文参数所以，file_get_contents() 不仅可以提交 POST 请求，还可以定义各种请求头内容。这些东西，就是一个请求的上下文，也就是它的执行环境和背景。

首先，我们定义一个服务端，在这里只是输出 $_GET 和 $_POST 里面的内容。同时，我们还打印了 $_SERVER 来看看请求头是否获取到了。

```php
print_r($_SERVER);

echo 'GET INFO', PHP_EOL;
foreach ($_GET as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
}

echo PHP_EOL,PHP_EOL;
echo 'POST INFO', PHP_EOL;
foreach ($_POST as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
}
```

接下来，在我们的测试代码中，使用 file_get_contents() 来进行 POST 提交。

```php
$postdata = http_build_query(
    [
        'var1' => 'some content',
        'var2' => 'doh',
    ]
);

$opts = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata,
    ],
];

$context = stream_context_create($opts);
$result = file_get_contents('http://localhost:8088/?a=1', false, $context);
print_r($result);
var_dump($http_response_header);
```

在这里，我们只是用到了 stream_context_create() ，就能够轻松地创建一个请求的上下文环境了。stream_context_create() 是创建上下文环境的函数，它接收的参数是一个选项数组，里面用于定义当前请求的相关选项。注意，我们这里其实定义的是 http/https 相关的选项，它还可以定义 ftp 、 socket 等相关的请求协议选项。

在使用 file_get_contents() 函数请求远程地址后，我们可以在 $http_response_header 变量内获取到请求返回的响应头信息。而且这个变量是会定义在当前的局部作用域下，不用担心全局作用域污染的问题。

非常简单的方式就可以实现 POST 请求了吧，另外我们还可以使用 fopen() 函数来实现类似的效果，不过获取 body 和响应应信息时的方式就不同了。

```php
$url = "http://localhost:8088/?a=1";

$opts = [
    'http' => [
        'method' => 'GET',
        'max_redirects' => '0',
        'ignore_errors' => '1',
    ],
];

$context = stream_context_create($opts);
$stream = fopen($url, 'r', false, $context);

// 返回响应头
var_dump(stream_get_meta_data($stream));

// 返回内容
var_dump(stream_get_contents($stream));
fclose($stream);
```

在这段代码中，我们使用 stream_get_meta_data() 函数来获得响应头，使用 stream_get_contents() 来获得响应的内容（body）。这样其实就真的和 curl 的效果差不多了，而且最主要的是，当前这种写法更简单方便。

从上面的代码中我们可以看出，这种上下文相关的函数都是 Stream 类型的函数，也就是流函数。它们是专门用来处理各种数据的，包括但不限于文件中的、网络上的、压缩文件以及其他一些操作的数据。在将来的学习中，我们还会接触到其它的内容。今天的学习，其实是流的网络数据处理中的一小部分内容，大家先消化消化吧！

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/context.php](https://www.php.net/manual/zh/context.php)