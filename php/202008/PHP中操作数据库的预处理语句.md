# PHP中操作数据库的预处理语句

今天这篇文章的内容其实也是非常基础的内容，不过在现代化的开发中，大家都使用框架，已经很少人会去自己封装或者经常写底层的数据库操作代码了。这回，我们就来复习一下数据库中相关扩展中的预处理语句内容。

## 什么是预处理语句？

预处理语句，可以把它看作是想要运行的 SQL 语句的一种编译过的模板，它可以使用变量参数进行控制。预处理语句可以带来两大好处：

- 查询仅需解析（或预处理）一次，但可以用相同或不同的参数执行多次。当查询准备好后，数据库将分析、编译和优化执行该查询的计划。对于复杂的查询，此过程要花费较长的时间，如果需要以不同参数多次重复相同的查询，那么该过程将大大降低应用程序的速度。通过使用预处理语句，可以避免重复分析/编译/优化周期。简言之，预处理语句占用更少的资源，因而运行得更快。

- 提供给预处理语句的参数不需要用引号括起来，驱动程序会自动处理。如果应用程序只使用预处理语句，可以确保不会发生SQL 注入。（然而，如果查询的其他部分是由未转义的输入来构建的，则仍存在 SQL 注入的风险）。

上述内容是摘自官方文档的说明，但其实预处理语句带给我们最直观的好处就是能够有效地预防 SQL 注入。关于 SQL 注入的内容我们将来在学习 MySQL 的时候再进行深入的学习，这里就不多说，反正预处理语句就是可以完成这项工作就好了。

## PDO 操作预处理语句

在 PHP 的扩展中，PDO 已经是主流的核心数据库扩展库，自然它对预处理语句的支持也是非常全面的。

```php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=blog_test', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// :xxx 占位符
$stmt = $pdo->prepare("insert into zyblog_test_user (username, password, salt) values (:username, :password, :salt)");
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':salt', $salt);

$username = 'one';
$password = '123123';
$salt = 'aaa';
$stmt->execute();

$username = 'two';
$password = '123123';
$salt = 'bbb';
$stmt->execute();
```

在代码中，我们使用 prepare() 方法定义预处理语句，这个方法会返回一个 PDOStatement 对象。在预处理的语句内使用 :xxx 这样的占位符号，并在外部使用 PDOStatement 对象的 bindParam() 方法为这些占位符绑定上变量。最后通过 execute() 来真正地执行 SQL 语句。

从这段代码中，我们就可以看到预处理语句的两大优势的体现。首先是占位符，使用占位符之后，我们就不用在 SQL 语句中去写单引号，单引号往往就是 SQL 注入的主要漏洞来源。bindParam() 方法会自动地转换绑定数据的类型。当然，bindParam() 方法也在可选的参数可以指定绑定的数据类型，大家可以查阅相关的文档。

另一个优势就是模板的能力，我们只定义了一个 PDOStatement 对象，然后通过改变数据的内容，就可以多次地使用 execute() 方法去执行预处理语句。

占位符还有另一种写法，就是使用一个问号来作为占位符号，在这种情况下，bindParam() 方法的键名就要使用数字下标了。这里需要注意的是，数字下标是从 1 开始的。

```php
// ? 占位符
$stmt = $pdo->prepare("insert into zyblog_test_user (username, password, salt) values (?, ?, ?)");
$stmt->bindParam(1, $username);
$stmt->bindParam(2, $password);
$stmt->bindParam(3, $salt);

$username = 'three';
$password = '123123';
$salt = 'ccc';
$stmt->execute();
```

在我们的查询中，也是可以方便地使用预处理语句的功能进行数据查询的。在这里，我们直接使用 execute() 来为占位符传递参数。

```php
// 查询获取数据
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username");

$stmt->execute(['username'=>'one']);

while($row = $stmt->fetch()){
    print_r($row);
}
```

## mysqli 操作预处理语句

虽说主流是 PDO ，而且大部分框架中使用的也是 PDO ，但我们在写脚本，或者需要快速地测试一些功能的时候，还是会使用 mysqli 来快速地开发。当然，mysqli 也是支持预处理语句相关功能的。

```php
// mysqli 预处理
$conn = new mysqli('127.0.0.1', 'root', '', 'blog_test');
$username = 'one';
$stmt = $conn->prepare("select username from zyblog_test_user where username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();

echo $stmt->bind_result($unames);

var_dump($unames);

while ($stmt->fetch()) {
    printf("%s\n", $unames);
}
```

可以看出，mysqli 除了方法名不同之外，绑定参数的键名也不完全的相同，这里我们使用的是问题占位，在 bind_param() 方法中，是使用 s 来表示符号位置，如果是多个参数，就要写成 sss... 这样。

## 总结

预处理语句的能力在现在的框架中都已经帮我们封装好了，其实我们并不需要太关心，就像 Laravel 中使用 DB::select() 进行数据库操作时，我们就可以看到预处理语句的应用。
大家可以自行查阅 vendor/laravel/framework/src/Illuminate/Database/Connection.php 中的 select() 方法。

测试代码：


参考文档：

[https://www.php.net/manual/zh/pdo.prepared-statements.php](https://www.php.net/manual/zh/pdo.prepared-statements.php)
