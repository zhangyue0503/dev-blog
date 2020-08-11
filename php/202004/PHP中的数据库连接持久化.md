# PHP中的数据库连接持久化

数据库的优化是我们做web开发的重中之重，甚至很多情况下其实我们是在面向数据库编程。当然，用户的一切操作、行为都是以数据的形式保存下来的。在这其中，数据库的连接创建过程有没有什么可以优化的内容呢？答案当然是有的，Java等语言中有连接池的设定，而PHP在普通开发中并没有连接池这种东西，在牵涉到多线程的情况下往往才会使用连接池的技术，所以PHP每次运行都会创建新的连接，那么这种情况下，我们如何来优化数据连接呢？

## 什么是数据库连接持久化

我们先来看下数据库连接持久化的定义。

*持久的数据库连接是指在脚本结束运行时不关闭的连接。当收到一个持久连接的请求时。PHP 将检查是否已经存在一个（前面已经开启的）相同的持久连接。如果存在，将直接使用这个连接；如果不存在，则建立一个新的连接。所谓“相同”的连接是指用相同的用户名和密码到相同主机的连接。*

*对 web 服务器的工作和分布负载没有完全理解的读者可能会错误地理解持久连接的作用。特别的，持久连接不会在相同的连接上提供建立“用户会话”的能力，也不提供有效建立事务的能力。实际上，从严格意义上来讲，持久连接不会提供任何非持久连接无法提供的特殊功能。*

这就是PHP中的连接持久化，不过它也指出了，持久连接不会提供任何非持久连接无法提供的特殊功能。这就很让人疑惑了，不是说好了这个方案可以带来性能的提升吗？

## 连接持久化有什么用？

没错，从上述定义中指出的特殊功能来看，持久化连接确实没有带来新的或者更高级的功能，但是它最大的用处正是提升了效率，也就是性能会带来提升。

*当Web Server创建到SQL服务器的连接耗费(Overhead)较高（如耗时较久，消耗临时内存较多）时，持久连接将更加高效。*

也就是说连接耗费高的时候，创建数据库连接的成本开销也会越大，时间当然也越长。使用持久化连接之后，*使得每个子进程在其生命周期中只做一次连接操作，而非每次在处理一个页面时都要向SQL 服务器提出连接请求。这也就是说，每个子进程将对服务器建立各自独立的持久连接。*

例如，如果有 20 个不同的子进程运行某脚本建立了持久的 SQL 服务器持久连接，那么实际上向该 SQL 服务器建立了 20 个不同的持久连接，每个进程占有一个。

## 效率对比

话不多说，我们直接通过代码来对比。首先，我们定义好一个统计函数，用来返回当前的毫秒时间。另外，我们还要准备好数据的连接参数。

```php
function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
}

$db = [
    'server' => 'localhost:3306',
    'user' => 'root',
    'password' => '',
    'database' => 'blog_test',
];
```

接下来，我们先使用普通的 mysqli 进行测试。

```php
$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $mysqli = new mysqli($db["server"], $db["user"], $db["password"], $db["database"]); //持久连接
    $mysqli->close();
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 6.5814000000
```

在 1000 次的循环创建数据库的连接过程中，我们消耗了6秒多的时间。接下来我们使用持久化连接的方式进行这 1000 次的数据库连接创建。只需要在 mysqli 的 $host 参数前加上一个 p: 即可。

```php
$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $mysqli = new mysqli('p:' . $db["server"], $db["user"], $db["password"], $db["database"]); //持久连接
    $mysqli->close();
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 0.0965000000
```

从 mysqli 的连接上来看，效率提升非常明显。当然，PDO 方式的数据库连接也提供了建立持久连接的属性。

```php
$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $pdo = new PDO("mysql:dbname={$db['database']};host={$db['server']}", $db['user'], $db['password']);
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 6.6171000000

$startTime = getmicrotime();
for ($i = 0; $i < 1000; $i++) {
    $pdo = new PDO("mysql:dbname={$db['database']};host={$db['server']}", $db['user'], $db['password'], [PDO::ATTR_PERSISTENT => true]); //持久连接
}
echo bcsub(getmicrotime(), $startTime, 10), PHP_EOL;
// 0.0398000000
```

PDO 方式连接时，需要给一个 PDO::ATTR_PERSISTENT 参数并设置为 true 。这样就让 PDO 建立的连接也成为了持久化的连接。

## 注意

既然数据库的持久化连接这么强大，为什么不默认就是这种持久化的连接形式，而需要我们手动增加参数来实现呢？PHP 的开发者们当然还是有顾虑的。

*如果持久连接的子进程数目超过了设定的数据库连接数限制，系统将会产生一些问题。如果数据库的同时连接数限制为 16，而在繁忙会话的情况下，有 17 个线程试图连接，那么有一个线程将无法连接。如果这个时候，在脚本中出现了使得连接无法关闭的错误（例如无限循环），则该数据库的 16 个连接将迅速地受到影响。*

同时，表锁和事务也有需要注意的地方。

*在持久连接中使用数据表锁时，如果脚本不管什么原因无法释放该数据表锁，其随后使用相同连接的脚本将会被持久的阻塞，使得需要重新启动 httpd 服务或者数据库服务*

*在使用事务处理时，如果脚本在事务阻塞产生前结束，则该阻塞也会影响到使用相同连接的下一个脚本*

所以，在使用表锁及事务的情况下，最好还是不要使用持久化的数据库连接。不过好在持久连接和普通连接是可以在任何时候互换的，我们定义两种连接形式，在不同的情况下使用不同的连接即可解决类似的问题。

## 总结

事物总有两面性，持久连接一方面带来了效率的提升，但另一方面也可能带来一些业务逻辑上的问题，而且这种问题如果在不了解持久连接的机制的情况下会非常难排查。因此，在日常开发中我们一定要在了解相关功能特性的情况下再选择适合的方式来完成所需要的功能开发。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E4%B8%AD%E7%9A%84%E6%95%B0%E6%8D%AE%E5%BA%93%E8%BF%9E%E6%8E%A5%E6%8C%81%E4%B9%85%E5%8C%96.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202004/source/PHP%E4%B8%AD%E7%9A%84%E6%95%B0%E6%8D%AE%E5%BA%93%E8%BF%9E%E6%8E%A5%E6%8C%81%E4%B9%85%E5%8C%96.php)

参考文档：

[https://www.php.net/manual/zh/features.persistent-connections.php](https://www.php.net/manual/zh/features.persistent-connections.php)