# 学习PDO中的错误与错误处理模式

在 PDO 的学习过程中，我们经常会在使用事务的时候加上 try...catch 来进行事务的回滚操作，但是大家有没有注意到默认情况下 PDO 是如何处理错误语句导致的数据库操作失败问题呢？今天，我们就来学习一下。

## PDO 中的错误与错误处理模式简介

PDO 提供了三种不同的错误处理方式：

- PDO::ERRMODE_SILENT，这是 PDO 默认的处理方式，只是简单地设置错误码，可以使用 PDO::errorCode() 和 PDO::errorInfo() 方法来检查语句和数据库对象

- PDO::ERRMODE_WARNING，除设置错误码之外，PDO 还将发出一条传统的 E_WARNING 信息。如果只是想看看发生了什么问题且不中断应用程序的流程，那么此设置在调试/测试期间非常有用。

- PDO::ERRMODE_EXCEPTION，除设置错误码之外，PDO 还将抛出一个 PDOException 异常类并设置它的属性来反射错误码和错误信息。

原来默认情况下，我们的 PDO 是不会处理错误信息的，这个你知道吗？如果不信的话，我们继续向下看具体的测试情况。不过，首先我们要说明的是，PDO 的错误处理机制针对的是 PDO 对象中的数据操作能力，如果在实例化 PDO 对象的时候就产生了错误，比如数据库连接信息不对，那么直接就会抛出异常。（ PHP5 中会直接返回一个 NULL，PHP7会抛出异常！ ）

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test1', 'root', '');
// Fatal error: Uncaught PDOException: SQLSTATE[HY000] [1049] Unknown database 'blog_test1'
```

blog_test1 表并不存在，所以在 new PDO 的时候就已经直接会抛出异常了。这个在实例化连接数据库过程中的错误处理机制是固定的，不是我们能修改的错误处理机制，毕竟如果连数据库连接都无法建立的话，就不用谈后面的任何操作了。

## 默认情况

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');
$pdo->query('select * from aabbcc');
var_dump($pdo->errorCode());
// string(5) "42S02"

var_dump($pdo->errorInfo());
// array(3) {
//   [0]=>
//   string(5) "42S02"
//   [1]=>
//   int(1146)
//   [2]=>
//   string(38) "Table 'blog_test.aabbcc' doesn't exist"
// }
```

在上面的测试代码中，我们查询了 aabbcc 这个表，但其实数据库中并不存在这个表。如果不使用 errorCode() 或者 errorInfo() 的话，这段代码不会有任何输出，也就是说，不会有任何错误信息让你看到，代码就直接运行过去了。

这个就是 PDO 在默认情况下的错误处理机制。其实，这样的处理并不好，因为如果我们忘记设置错误处理机制的话，就会导致一些错误无法呈现，而且并不好调试。

## 设置为警告

```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$pdo->query('select * from aabbcc');
// Warning: PDO::query(): SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist
```

在设置错误处理机制为警告后，PDO 会抛出一个不影响程序执行的 warning 信息。但是，如果我们修改了 ini 文件中错误处理机制后，也可能是看不到警告信息的。不过相对于默认处理的情况来说，有一条警告信息已经非常好了。

## 设置为异常

```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->query('select * from aabbcc');
// Fatal error: Uncaught PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist 
```

最后，我们将错误处理机制设置为抛出异常。总算是能让程序中止运行并且报出 Fatal error 错误了，同时，这个异常信息也是可以通过 try...catch 来捕获到的。这样的开发才是我们最需要的开发形式。

## 属性添加方式

在上述测试代码中，我们使用的是 setAttribute() 方法来设置 PDO 的错误处理属性，但其实我们可以在实例化 PDO 类时就指定一些需要的属性。

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
$pdo->query('select * from aabbcc');
// Warning: PDO::query(): SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.aabbcc' doesn't exist
```

## 总结

PDO 已经是现在的主流数据库连接扩展，也是各种框架的必备连库扩展，但是如果不深入的学习的话，很多人可能还真不知道很多关于 PDO 的一些知识。框架在为我们带来便利的同时，也让我们变得更“笨”，所以，学习还是要更多地接触底层地知识，免得在面试的时候需要手写代码的时候手足无措。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/%E5%AD%A6%E4%B9%A0PDO%E4%B8%AD%E7%9A%84%E9%94%99%E8%AF%AF%E4%B8%8E%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86%E6%A8%A1%E5%BC%8F.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/%E5%AD%A6%E4%B9%A0PDO%E4%B8%AD%E7%9A%84%E9%94%99%E8%AF%AF%E4%B8%8E%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86%E6%A8%A1%E5%BC%8F.php)

参考文档：

[https://www.php.net/manual/zh/pdo.error-handling.php](https://www.php.net/manual/zh/pdo.error-handling.php)
