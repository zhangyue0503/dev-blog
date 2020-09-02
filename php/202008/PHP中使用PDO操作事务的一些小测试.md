# PHP中使用PDO操作事务的一些小测试

关于事务的问题，我们就不多解释了，以后在学习 MySQL 的相关内容时再深入的了解。今天我们主要是对 PDO 中操作事务的一些小测试，或许能发现一些比较好玩的内容。

## 在 MyISAM 上使用事务会怎么样？

首先，相信只要是学过一点点的 MySQL 相关知识的人都知道，在 MySQL 中常用的两种表类型就是 InnoDB 和 MyISAM 这两种类型。当然，我们今天也不讲它们全部的区别，但有一个区别是最明显的，那就是 MyISAM 不支持事务。那么，如果我们在 PDO 操作中对 MyISAM 进行事务操作会怎么样呢？

```php
// myisam
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_myisam (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_myisam2 (name, age) values ('Joe', 12, 33)");

    // sleep(30);
    $pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}
```

tran_myisam 和 tran_myisam2 表都是 MyISAM 类型的表，在这段代码中，我们故意写错了 tran_myisam2 的插入语句，让它走到 catch 中。实际执行的结果是，报错信息正常输出，tran_myisam 表的数据也被插入了。也就是说，针对 MyISAM 表的事务操作是没有效果的。当然，PDO 也不会主动报错，如果我们让第二条 SQL 语句也是正常语句的话，PDO 只会正常执行结束，不会有任何的错误或者提示信息。

```php
// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12, 3)");
    // sleep(30);
    $pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}
```

我们可以打开 sleep(30); 这行代码的注释，也就是在事务提交前暂停 30 秒，然后在 MySQL 中查看 infomation_schema.INNODB_TRX 表。这个表中显示的就是正在执行中的事务。在 InnoDB 类型的表执行时就可以看到一条事务正在执行的记录，而 MyISAM 类型的表中则不会看到任何信息。

## 不提交不回滚事务会发生什么？

假设我们忘写了 commit() ，同时也没有报错，这条语句会执行成功吗？就像下面这段代码一样。

```php
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)");

    // 忘记写 $pdo->commit(); 了
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}
```

PHP 会在脚本执行结束后，其实也就是在 $pdo 对象析构时回滚这个事务。也就是说，这里的 SQL 语句是不会执行的。但是，尽量不要这么做，因为在正式环境中，我们的代码非常复杂，而且不一定会析构成功。这样的话，可能会有长时间占据的事务存在，最终结果就是会导致 MySQL 的 IPQS 奇高，而且还很难找到原因。所以，在使用事务的时候，一定要记得 commit() 和 rollBack() 都是我们的亲兄弟，绝不能落下他们。

## 上一个事务没有提交没有回滚，下一个事务会执行吗？

同样的，在上一个问题的基础上我们再继续延伸。如果有两个事务依次执行，第一个事务没有提交，没有回滚，那么下一个事务还能执行吗？

```php
// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)");
    // 忘记写 $pdo->commit(); 了
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}

// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('BW', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('BW', 12)");

    // sleep(30);
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL; // Failed: There is already an active transaction
}
```

我们可以看到，第二段事务直接就报错了，内容是：“这里有一个已经存在的活动事务”。也就是说如果上一个事务没有提交没有回滚的话，第二个事务是无法执行的。

## 总结

今天我们只是学习并测试了几个事务相关的小问题，但问题虽小却有可能带来严重的线上事故，大家在开发的时候一定要小心。关于事务的详细内容在将来深入学习 MySQL 的时候我们再好好研究。

测试代码：


参考文档：

[https://www.php.net/manual/zh/pdo.transactions.php](https://www.php.net/manual/zh/pdo.transactions.php)