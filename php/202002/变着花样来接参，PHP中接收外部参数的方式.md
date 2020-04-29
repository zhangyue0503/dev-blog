# 变着花样来接参，PHP中接收外部参数的方式

对于PHP这样一个web语言来说，接参是非常重要的一个能力。毕竟从前端表单或异步请求传递上来的数据都要获取到才能进行正常的交互展示。当然，这也是所有能够进行web开发的语言的必备能力。今天我们就来看看PHP各种各样的接参形式。

首先，我们要准备一个静态页面，就像下面这个一样，它提供了一个表单，同时url里还带有一个GET参数：

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="?show=1" method="post">
        姓名：<input type="text" name="name"/><br />
        电话：<input type="text" name="tel"/><br/>

        地址（省）：<input type="text" name="address.prov"/><br/>
        地址（市）：<input type="text" name="address city"/><br/>

        兴趣1：<input type="text" name="interest[]"/><br/>
        兴趣2：<input type="text" name="interest[]"/><br/>
        兴趣3：<input type="text" name="interest[]"/><br/>

        学历1：<input type="text" name="edu[one]"/><br/>
        学历2：<input type="text" name="edu[two]"/><br/>

        <input type="submit" value="提交" >
    </form>
</body>
</html>
```

## 正常的$_GET、$_POST方式

```php
// 正常的GET、POST
    echo $_GET['show'], '<br/>'; // 1
    echo $_POST['name'], '<br/>'; // 提交的内容
```

这是最基础的也是最直接的接参方式，GET参数通过 $_GET 获取，POST参数通过 $_POST 获取，互相都不干扰。

## 正常的$_REQUEST方式

```php
    // 使用REQUEST
    echo $_REQUEST['show'], '<br/>'; // 1
    echo $_REQUEST['tel'], '<br/>'; // 提交的内容
```

$_REQUEST 则是获取所有请求中的参数，不包括上传文件。也就是说，它包含了 $_GET 、 $_POST 以及 $_COOKIE(需要配置，默认不包含) 这三个接参变量中的所有内容。这里需要注意的一点是，PHP5.3以后， $_REQUEST 接受的参数变量内容由 php.ini 文件中的 request_order 指定，默认情况下这个配置参数的值是 GP 也就是 GET 和 POST ，并没有 COOKIE ，想要 COOKIE 的话需要修改这里添加一个C就可以了。

如果 $_GET 、 $_POST 中有同名的内容呢？ $_REQUEST 展示的顺序也是根据这配置参数的顺序来的，从左至右，后面的覆盖前面的，比如你配置的是GP 那么参数覆盖的顺序是： POST > GET，最终显示的就是 POST 中的内容。

## register_globals问题

```php
    // register_globals 如果打开
    echo $name, '<br/>'; // 提交的内容
    echo $tel, '<br/>'; // 提交的内容
```

这是一个不安全的配置，也是在 php.ini 文件中进行配置的。它的作用就是将请求来的参数直接转成变量，有全局变量污染的问题，不要打开！！！现在的 php.ini 文件中基本都是默认关闭的。

## import_request_variables

```php
    // import_request_variables 抱歉，5.4之后已经取消了
    import_request_variables('pg', 'pg_');
    echo $pg_show, '<br/>';
    echo $pg_name, '<br/>';
```

这个函数是手动将指定的参数变量里面的内容注册为全局变量，同样的，它也在5.4之后被取消的，这样的函数都会存在风险，我们了解一下曾经有过这样一个函数即可。

## extract

```php
    extract($_POST, EXTR_PREFIX_ALL, 'ex');
    echo $ex_name, '<br/>'; // 提交的内容
    echo $ex_tel, '<br/>'; // 提交的内容
```

extract 是目前可以代替上面两种参数转变量的方式中目前依然支持的。它是由我们自己来控制对已存在变量的覆盖的，也就是第二个参数，这样在可控的环境下可以极大地避免污染全局变量的问题，当然前提还是我们自己要确定使用它，具体内容可以自行查找文档参考哦！


## 参数名中的.和空格

```php
    // 参数名中的.和空格
    echo $_REQUEST['address_prov'], '<br/>'; // 提交的内容
    echo $_REQUEST['address_city'], '<br/>'; // 提交的内容
```

表单提交的 input 的 name 中如果包含 . 或者 空格 ，将直接转换成 下划线 。不过我们在前端命名中也不建议使用 . 或者 空格 ，需要的时候直接就使用 下划线 就好了，前后端不要造成歧义。

## 参数名中的[]

```php
    // 参数名中的[]
    print_r($_REQUEST['interest']); // Array (v,....) 
    echo '<br />';
    print_r($_REQUEST['edu']); // Array (k/v,....) 
```

当表单提交的 input 的 name 是数组形式的，也就是 "interest[]" 或 "edu[one]" 这种形式时，我们接收到的参数默认就会成为一个数组形式的内容。

## 高大上的php://input

```php
    // php://input
    $content = file_get_contents('php://input');   
    print_r($content); //name=xxx&.....
```

最后就是现在接口开发中经常会使用的 php://input 形式接参。一般是因为安全或参数字段较多的情况下，前端通过 Body Raw 的形式直接传递一整段的 Body 内容过来。这时候就只能用这种形式获取到了，这个 Body Raw 的原始内容一般会是一整段的文字，也有可能是进行过一些加密处理的内容，格式可以自己定义。而面对普通表单，我们将会接收到的也是原始的表单内容，就像上面的 name=xxx&tel=xxx&.... 这样的内容。

需要注意的是 enctype="multipart/form-data" 时它是无法获取到内容的。同时，这种方式也是代替 $HTTP_RAW_POST_DATA 全局变量的，不要再使用淘汰的能力了哦，尽早更新新版本的PHP使用新的语法特性哦！

## 总结

随便一整理就发现原来简简单单的一个接参就有这么多种形式和需要注意的地方，还真是大开眼界。依然是那句话，学无止尽，继续深入的钻研早晚你也会成为大牛！

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E5%8F%98%E7%9D%80%E8%8A%B1%E6%A0%B7%E6%9D%A5%E6%8E%A5%E5%8F%82%EF%BC%8CPHP%E4%B8%AD%E6%8E%A5%E6%94%B6%E5%A4%96%E9%83%A8%E5%8F%82%E6%95%B0%E7%9A%84%E6%96%B9%E5%BC%8F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E5%8F%98%E7%9D%80%E8%8A%B1%E6%A0%B7%E6%9D%A5%E6%8E%A5%E5%8F%82%EF%BC%8CPHP%E4%B8%AD%E6%8E%A5%E6%94%B6%E5%A4%96%E9%83%A8%E5%8F%82%E6%95%B0%E7%9A%84%E6%96%B9%E5%BC%8F.php)


参考文档：
[https://www.php.net/manual/zh/language.variables.external.php](https://www.php.net/manual/zh/language.variables.external.php)
[https://www.php.net/manual/zh/function.import-request-variables.php](https://www.php.net/manual/zh/function.import-request-variables.php)
[https://www.php.net/manual/zh/function.extract.php](https://www.php.net/manual/zh/function.extract.php)