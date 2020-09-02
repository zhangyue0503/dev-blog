# PHP中PDO关闭连接的问题

在之前我们手写 mysql 的连接操作时，一般都会使用 mysql_close() 来进行关闭数据库连接的操作。不过在现代化的开发中，一般使用框架都会让我们忽视了底层的这些封装，而且大部分框架都已经默认是使用 PDO 来进行数据库的操作，那么，大家知道 PDO 是如何关闭数据的连接的吗？

## 官方说明

> 要想关闭连接，需要销毁对象以确保所有剩余到它的引用都被删除，可以赋一个 NULL 值给对象变量。如果不明确地这么做，PHP 在脚本结束时会自动关闭连接。

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');
$pdo = null;
```

官方文档中说得很明白，那就是给 PDO 对象赋值为 NULL 即可。但是事情真的有那么简单吗？

## 实际测试

我们来这样进行一下测试，正常情况下，我们打开数据库连接后都不会直接就关闭，而是要进行一些操作。

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');

$stmt = $pdo->prepare('SELECT * FROM zyblog_test_user');
$stmt->execute();

$pdo = null;
sleep(60);
```

运行上述代码后，我们在数据库使用 show full processlist; 查看连接进程，会发现当前的连接并没有马上关闭，而是等到 60 秒之后，也就是页面执行完成之后才会关闭。似乎 $pdo = null; 这句并没有执行成功。

其实，在官方文档中已经说明了这个情况，只是大家可能不太会注意。【需要销毁对象以确保所有剩余到它的引用都被删除】，在上面的代码中，$stmt 预编译 SQL 语句的功能调用的是 $pdo 对象中的方法，它们之间产生了引用依赖的关系，这样的情况下，直接给 $pdo = null; 是没有效果的，我们需要将 $stmt 也赋值为 null 。

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');

$stmt = $pdo->prepare('SELECT * FROM zyblog_test_user');
$stmt->execute();

$stmt = null;
$pdo = null;
sleep(60);
```

## mysqli测试

那么使用 mysqli 的默认扩展组件，也就是使用 mysqli 对象中的 close() 来关闭数据库连接会有这个问题吗？还是直接用代码来测试测试。（ mysql 扩展已经过时不推荐使用了，大家如果要自己封装数据库操作类或者写小 Demo 的话还是要用 mysqli 更好一些 ）

```php
$conn = new mysqli('127.0.0.1', 'root', '', 'blog_test');

$result = $conn->query('SELECT * FROM zyblog_test_user');
$stmt = $conn->prepare("SELECT * FROM zyblog_test_user");
$stmt->execute();

$conn->close();

sleep(60);
```

在运行上述代码后，我们在数据库中查看连接进程就不会看到还在执行的连接的，也就是说在 mysqli 中调用 close() 方法是能够直接马上关闭掉数据库的连接的。

## 总结

其实今天的内容也是官方文档关于数据库连接这一页文档上的一个 Note 中的信息。很早就有大神发现了这个问题并且分享了出来，但是大部分人根本都不知道这个问题，甚至很多人连 PDO 也是可以关闭数据库连接的都不知道。框架在带给我们便利的同时，确实也将很多东西封装的太好了，以至于很多朋友都不去关心底层的一些内容，但是，当你向更高阶层迈进时，往往这些底层的东西会成为你的阻碍。

测试代码：

参考文档：

[https://www.php.net/manual/zh/pdo.connections.php](https://www.php.net/manual/zh/pdo.connections.php)

[https://www.php.net/manual/zh/pdo.connections.php#114822](https://www.php.net/manual/zh/pdo.connections.php#114822)