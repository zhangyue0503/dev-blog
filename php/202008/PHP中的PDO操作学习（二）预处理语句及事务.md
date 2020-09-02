# PHP中的PDO操作学习（二）预处理语句及事务

今天这篇文章，我们来简单的学习一下 PDO 中的预处理语句以及事务的使用，它们都是在 PDO 对象下的操作，而且并不复杂，简单的应用都能很容易地实现。只不过大部分情况下，大家都在使用框架，手写的机会非常少。

## 预处理语句功能

预处理语句就是准备好一个要执行的语句，然后返回一个 PDOStatement 对象。一般我们会使用 PDOStatement 对象的 execute() 方法来执行这条语句。为什么叫预处理呢？因为它可以让我们多次调用这条语句，并且可以通过占位符来替换语句中的字段条件。相比直接使用 PDO 对象的 query() 或者 exec() 来说，预处理的效率更高，它可以让客户端/服务器缓存查询和元信息。当然，更加重要的一点是，占位符的应用可以有效的防止基本的 SQL 注入攻击，我们不需要手动地给 SQL 语句添加引号，直接让预处理来解决这个问题，相信这一点是大家都学习过的知识，也是我们在面试时最常见到的问题之一。

```php
// 使用 :name 形式创建一个只进游标的 PDOStatement 对象
$stmt = $pdo->prepare("select * from zyblog_test_user where username = :username", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

var_dump($stmt);
// object(PDOStatement)#2 (1) {
//     ["queryString"]=>
//     string(57) "select * from zyblog_test_user where username = :username"
//   }

$stmt->execute([':username' => 'aaa']);
$aUser = $stmt->fetchAll();

$stmt->execute([':username' => 'bbb']);
$bUser = $stmt->fetchAll();

var_dump($aUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "1"
//       [0]=>
//       string(1) "1"
//       ["username"]=>
//       string(3) "aaa"
//       ……

var_dump($bUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "2"
//       [0]=>
//       string(1) "2"
//       ["username"]=>
//       string(3) "bbb"
//       ……

```

prepare() 方法的第一个参数就是我们需要执行的 SQL 语句，在这段代码中，我们使用的是 :xxx 形式的占位符，所以在调用 prepare() 方法返回的 PDOStatement 对象的 execute() 方法时，我们需要指定占位符的值。在代码中，我们使用这一条 SQL 语句，通过替换不同的占位符内容，实现了两次查询。

prepare() 方法的第二个参数是为返回的 PDOStatement 对象设置的属性。常见用法是：设置 PDO::ATTR_CURSOR 为 PDO::CURSOR_SCROLL，将得到可滚动的光标。 某些驱动有驱动级的选项，在 prepare 时就设置。PDO::ATTR_CURSOR 是设置数据库游标的类型，而 PDO::CURSOR_FWDONLY 的意思是创建一个只进游标的 PDOStatement 对象。此为默认的游标选项，因为此游标最快且是 PHP 中最常用的数据访问模式。关于数据库游标的知识大家可以自行查阅相关的内容。

此外，PDOStatement 还可以通过 bindParam() 方法来绑定占位符数据，我们将在后面学习 PDOStatement 对象相关的文章中继续学习。

接下来，我们再看一下使用 ? 号占位符来实现查询，? 号占位符在绑定的时候是以下标形式进行绑定的。

```php
// 使用 ? 形式创建一个只进游标的 PDOStatement 对象
$stmt = $pdo->prepare("select * from zyblog_test_user where username = ?", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

$stmt->execute(['aaa']);
$aUser = $stmt->fetchAll();

var_dump($aUser);
// array(1) {
//     [0]=>
//     array(8) {
//       ["id"]=>
//       string(1) "1"
//       [0]=>
//       string(1) "1"
//       ["username"]=>
//       string(3) "aaa"
//       ……
```

当然，这种预编译语句不仅限于查询语句，增、删、改都是可以的，而且也都是支持占位符的。在 [PHP中操作数据库的预处理语句]() 这篇文章中有详细的示例。

## 事务能力

关于事务想必大家也都有一定的了解，所以在这里也不介绍具体的概念了，我们只看看在 PDO 中事务是如何实现的。首先，我们先看下在没有事务的情况下会发生什么。

```php
$pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)"); // 成功插入

$pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)"); // 报错停止整个PHP脚本执行
// Fatal error: Uncaught PDOException: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.tran_innodb2' doesn't exist
```

假设这两个表需要同时更新，但第二条语句报错了。在没有事务的情况下，我们第一条数据是会正常插入成功的，这并不是我们需要的结果。在这时，就需要事务能力的帮助，让我们能够让两个表要么同时成功，要么同时失败。

```php
try {
    // 开始事务
    $pdo->beginTransaction();

    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)"); // 不存在的表

    // 提交事务
    $pdo->commit();
} catch (Exception $e) {
    // 回滚事务
    $pdo->rollBack();
    // 输出报错信息
    echo "Failed: " . $e->getMessage(), PHP_EOL;
    // Failed: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'blog_test.tran_innodb2' doesn't exist
}
```

首先就是 beginTransaction() 方法，它是用来关闭数据库的自动提交，并启动一个事务，在这个方法之后，只有遇到 commit() 或者 rollBack() 方法后才会关闭这个事务。

commit() 方法就是操作过程中没有出现意外的话，就将在 beginTransaction() 之后的所有数据操作一起打包提交。

rollBack() 是回滚数据，当 beginTransaction() 之后的某一条语句或者代码出现问题时，回滚之前的数据操作，保证 beginTransaction() 之后的所有语句要么都成功，要么都失败。

就是这样三个简单的函数，就为我们完成了整个事务操作。关于事务的深入学习我们会在将来深入地研究 MySQL 时再进行探讨。在这里我们需要注意的是，PDO 对象最好指定错误模式为抛出异常，如果不指定错误模式的话，事务中出现的错误也不会直接报错，而是返回错误码，我们需要通过错误码来确定是否提交或回滚。这样远没有异常机制来的简洁直观。

## 总结

我们简单的梳理并学习了一下 PDO 中的预处理和事务相关的知识，接下来就要进入 PDOStatement 对象相关内容的学习。PDOStatement 对象就是 PDO 的预处理对象，也就是在日常开发中我们会接触到的最多的数据操作对象。这块可是重点内容，大家可不能松懈了哦！

测试代码：

参考文档：

[https://www.php.net/manual/zh/pdo.prepare.php](https://www.php.net/manual/zh/pdo.prepare.php)

[https://www.php.net/manual/zh/pdo.begintransaction.php](https://www.php.net/manual/zh/pdo.begintransaction.php)

[https://www.php.net/manual/zh/pdo.commit.php](https://www.php.net/manual/zh/pdo.commit.php)

[https://www.php.net/manual/zh/pdo.rollback.php](https://www.php.net/manual/zh/pdo.rollback.php)