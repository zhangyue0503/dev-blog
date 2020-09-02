# PHP中的PDO对象操作学习（一）初始化PDO及原始SQL语句操作

PDO 已经是 PHP 中操作数据库事实上的标准。包括现在的框架和各种类库，都是以 PDO 作为数据库的连接方式。基本上只有我们自己在写简单的测试代码或者小的功能时会使用 mysqli 来操作数据库。注意，普通的 mysql 扩展已经过时了哦！

## PDO 实例

首先来看看一个 PDO 实例是如何初始化的。

```php
$dns = 'mysql:host=localhost;dbname=blog_test;port=3306;charset=utf8';
$pdo = new PDO($dns, 'root', '');
```

普通情况下，我们直接实例化的时候传递构造参数就可以获得一个 PDO 对象。这样，我们就和数据库建立了连接。如果连接失败，也就是参数写得有问题的时候，在实例化时直接就会报异常。

PDO 对象的参数包括 DNS 信息、用户名、密码，另外还有一个参数就是可以设置 PDO 连接的一些属性，我们将在后面看到它的使用。

### dns 参数

PDO 构造参数的第一个参数是一个 DNS 字符串。在这个字符串中使用分号 ; 分隔不同的参数内容。它里面可以定义的内容包括：

- DSN prefix，也就是我们要连接的数据库类型，MySQL 数据库一般都是直接使用 mysql: 这样来定义即可。

- host，连接的地址，在这里我们连接的是本地数据库 localhost

- port，端口号，MySQL 默认为 3306 ，可以不写

- dbname，要连接的数据库名称

- unix_socket，可以指定 MySQL 的 Unix Socket 文件

- charset，连接的字符集

我们可以通过一个函数来查看当前 PHP 环境中所支持的数据库扩展都有哪些：

```php
print_r(PDO::getAvailableDrivers());exit;
// Array
// (
//     [0] => dblib
//     [1] => mysql
//     [2] => odbc
//     [3] => pgsql
//     [4] => sqlite
// )
```

### PDO 对象属性

PDO 构造参数的最后一个参数可以设置连接的一些属性，如：

```php
$pdo = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
showPdoAttribute($pdo);
// ……
// PDO::ATTR_ERRMODE: 2
// ……
```

showPdoAttribute() 方法是我们自己封装的一个展示所有连接属性的函数。

```php
// 显示pdo连接属性
function showPdoAttribute($pdo){
    $attributes = array(
        "DRIVER_NAME", "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
        "ORACLE_NULLS", "PERSISTENT", "SERVER_INFO", "SERVER_VERSION"
    );
    
    foreach ($attributes as $val) {
        echo "PDO::ATTR_$val: ";
        echo $pdo->getAttribute(constant("PDO::ATTR_$val")) . "\n";
    }
}
```

在这个函数中，我们使用 PDO 实例的 getAttribute() 方法来获取相应的属性值。在没有设置 PDO::ATTR_ERRMODE 时，它的默认值为 0 ，也就是 PDO::ERRMODE_SILENT 常量所对应的值。在上述代码中，我们将它设置为了 PDO::ERRMODE_EXCEPTION ，查看属性输出的结果就变成了 2 。

除了在构造函数的参数中设置属性外，我们也可以使用 PDO 实例的 setAttribute() 方法来设置 PDO 的属性值。

```php
pdo2 = new PDO($dns, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo $pdo2->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE), PHP_EOL;
// 4

// 设置属性
$pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
echo $pdo2->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE), PHP_EOL;
// 2
```

在这段代码中，我们设置 PDO::ATTR_DEFAULT_FETCH_MODE 为 PDO::FETCH_ASSOC 。这样，在使用这个 $pdo2 的连接进行查询时，输出的结果都会是以数组键值对形式返回的内容。我们马上就进入查询方面相关函数的学习。

## 查询语句

大多数情况下，使用 PDO 我们都会用它的预处理能力来编写 SQL 语句，一来是性能更好，二来是更加安全。不过我们今天先不讲预处理方面的问题，还是以最原始的直接操作 SQL 语句的方式学习相关的一些函数。

### 普通查询及遍历

```php
// 普通查询 - 遍历1
$stmt = $pdo->query('select * from zyblog_test_user limit 5');
foreach ($stmt as $row) {
    var_dump($row);
}

// array(8) {
//     ["id"]=>
//     string(3) "204"
//     [0]=>
//     string(3) "204"
//     ["username"]=>
//     string(5) "three"
//     [1]=>
//     string(5) "three"
//     ["password"]=>
//     string(6) "123123"
//     [2]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "ccc"
//     [3]=>
//     string(3) "ccc"
//   }
//   ……

// 普通查询 - 遍历2
$stmt = $pdo->query('select * from zyblog_test_user limit 5');

while ($row = $stmt->fetch()) {
    var_dump($row);
}

// array(8) {
//     ["id"]=>
//     string(3) "204"
//     [0]=>
//     string(3) "204"
//     ["username"]=>
//     string(5) "three"
//     [1]=>
//     string(5) "three"
//     ["password"]=>
//     string(6) "123123"
//     [2]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "ccc"
//     [3]=>
//     string(3) "ccc"
//   }
//   ……

```

PDO 实例的 query() 方法就是执行一条查询语句，并返回一个 PDOStatement 对象。通过遍历这个对象，就可以获得查询出来的数据结果集。

在代码中，我们使用了两种方式来遍历，其实它们的效果都是一样的。在这里，我们要关注的是返回的数据格式。可以看出，数据是以数组格式返回的，并且是以两种形式，一个是数据库定义的键名，一个是以下标形式。

### 查询结果集（数组、对象）

其实大部分情况下，我们只需要数据库键名的那种键值对形式的数据就可以了。这个有两种方式，一是直接使用上文中我们定义好默认 PDO::ATTR_DEFAULT_FETCH_MODE 属性的 $pdo2 连接，另一个就是在查询的时候为 query() 方法指定属性。

```php
$stmt = $pdo2->query('select * from zyblog_test_user limit 5');
foreach ($stmt as $row) {
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_ASSOC);
foreach ($stmt as $row) {
    var_dump($row);
}
// array(4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……
```

当然，我们也可以直接让数据返回成对象的格式，同样的也是使用预定义的常量来指定 query() 或者 PDO 实例连接的属性就可以了。

```php
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_OBJ);
foreach ($stmt as $row) {
    var_dump($row);
}
// object(stdClass)#4 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……
```

### 查询结果集（类）

上面返回对象形式的结果集中的对象是 stdClass 类型，也就是 PHP 的默认类类型。那么我们是否可以自己定义一个类，然后在查询完成后直接生成它的结果集呢？就是像是 ORM 框架一样，完成数据到对象的映射。既然这么说了，那当然是可以的啦，直接看代码。

```php
class user
{
    public $id;
    public $username;
    public $password;
    public $salt;

    public function __construct()
    {
        echo 'func_num_args: ' . func_num_args(), PHP_EOL;
        echo 'func_get_args: ';
        var_dump(func_get_args());
    }
}

class user2
{

}
// 返回指定对象
$u = new user;
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_INTO, $u);
foreach ($stmt as $row) {
    var_dump($row);
}
// object(user)#3 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……

// 空类测试
$u = new user2;
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_INTO, $u);
foreach ($stmt as $row) {
    var_dump($row);
}

// object(user2)#2 (4) {
//     ["id"]=>
//     string(1) "5"
//     ["username"]=>
//     string(3) "two"
//     ["password"]=>
//     string(6) "123123"
//     ["salt"]=>
//     string(3) "bbb"
//   }
//   ……
```

在这段代码中，我们定义了两个类，user 类有完整的和数据库字段对应的属性，还定义了一个构造方法（后面会用到）。而 user2 类则是一个空的类。通过测试结果来看，类的属性对于 PDO 来说并不重要。它会默认创建数据库查询到的字段属性，并将它赋值给对象。那么假如我们定义了一个 const 常量属性并给予相同的字段名称呢？大家可以自己尝试一下。

对于 user 和 user2 来说，我们将它实例化了并传递给了 query() ，并且指定了结果集格式为 PDO::FETCH_INTO ，这样就实现了获取对象结果集的能力。但是 PDO 远比你想象的强大，我们还可以直接用类模板来获取查询结果集。

```php
// 根据类返回指定对象
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_CLASS, 'user', ['x1', 'x2']);
foreach ($stmt as $row) {
    var_dump($row);
}
// func_num_args: 2
// func_get_args: array(2) {
//   [0]=>
//   string(2) "x1"
//   [1]=>
//   string(2) "x2"
// }
// object(user)#4 (4) {
//   ["id"]=>
//   string(1) "5"
//   ["username"]=>
//   string(3) "two"
//   ["password"]=>
//   string(6) "123123"
//   ["salt"]=>
//   string(3) "bbb"
// }
// ……
```

query() 方法直接使用查询结果集模式为 PDO::FETCH_CLASS ，并传递一个类模板的名称，PDO 就会在当前代码中查找有没有对应的类模板，获得的每个结果都会实例化一次。在这里，我们又多了一个参数，最后一个参数是一个数组，并且给了两个元素。估计有不少小伙伴已经看出来了，这个参数是传递给类的构造方法的。记住，使用这个模式，每个元素都会实例化一次，结果集中的每个元素都是新创建的类（object(user2)#3，#号后面的数字是不同的对象句柄id），而 PDO::FETCH_INTO 则是以引用的形式为每个元素赋值（object(user2)#3，#号后面的数字是相同的对象句柄id）。也就是说，我们使用 PDO::FETCH_INTO 模式的时候，修改一个元素的值，其它的元素也会跟着改变，如果使用一个数组去记录遍历的元素值，最后数组的结果也会是相同的最后一个元素的内容。

```php
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_INTO, $u);
$resArr = [];
foreach ($stmt as $row) {
    var_dump($row);
    $resArr[] = $row;
}
$resArr[0]->id = 55555;
print_r($resArr);
// Array
// (
//     [0] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [1] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [2] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [3] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

//     [4] => user2 Object
//         (
//             [id] => 55555
//             [username] => two
//             [password] => 123123
//             [salt] => bbb
//         )

// )
```

如何解决这个问题呢？最简单的方式就是在数组赋值的时候加个 clone 关键字呗！

### 查询结果集（指定字段）

最后轻松一点，我们看下 query() 方法还可以指定查询的某一个字段。

```php
// 只返回第几个字段
$stmt = $pdo->query('select * from zyblog_test_user limit 5', PDO::FETCH_COLUMN, 2);
foreach ($stmt as $row) {
    var_dump($row);
}
// string(32) "bbff8283d0f90625015256b742b0e694"
// string(6) "123123"
// string(6) "123123"
// string(6) "123123"
// string(6) "123123"
```

## 增、删、改操作

除了查询之外的操作，我们都可以使用 exec() 方法来执行相应的 SQL 语句。

### 增加操作

```php
$count = $pdo->exec("insert into zyblog_test_user(`username`, `password`, `salt`) value('akk', 'bkk', 'ckk')");
$id = $pdo->lastInsertId();

var_dump($count); // int(1)
var_dump($id); // string(3) "205"
```

exec() 返回的是影响的行数，如果我们执行这一条 SQL ，返回的就是成功添加了一行数据。如果要获得新增加数据的 id ，就要使用 lastInserId() 方法来获取。

```php
$count = $pdo->exec("insert into zyblog_test_user(`username`, `password`, `salt`) value('akk', 'bkk', 'ckk', 'dkk')");
// Fatal error: Uncaught PDOException: SQLSTATE[21S01]: Insert value list does not match column list: 1136 Column count doesn't match value count at row 1
```

执行错误的 SQL 语句，就像根据 PDO::ATTR_ERRMODE 属性的设置来返回错误信息。我们在最上面的实例化 PDO 代码中指定了错误形式是异常处理模式，所以这里直接就会报 PDOException 异常。

### 修改操作

```php
// 正常更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='{$id}'");

var_dump($count); // int(1)

// 数据不变更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='{$id}'");
var_dump($count); // int(0)

// 条件错误更新
$count = $pdo->exec("update zyblog_test_user set `username`='aakk' where id='123123123123'");
var_dump($count); // int(0)
echo '===============', PHP_EOL;
```

同样的，在执行更新操作的时候，exec() 返回的也是受影响的行数。很多小伙伴会以这个进行判断是否更新成功，但如果数据没有修改，那么它返回的将是 0 ，SQL 语句的执行是没有问题的，逻辑上其实也没有问题。比如我们在后台打开了某条数据查看，然后并不想更新任何内容就直接点了提交，这时候不应该出现更新失败的提示。也就是说，在前端判断更新操作的时候，需要判断字段是否都有改变，如果没有改变的话那么不应该提示更新失败。这一点是业务逻辑上的考虑问题，如果你认为这样也是更新失败的话，那么这么报错也没有问题，一切以业务形式为主。

### 删除操作

```php
$count = $pdo->exec("delete from zyblog_test_user where id = '{$id}'");
var_dump($count); // int(1)

// 条件错误删除
$count = $pdo->exec("delete from zyblog_test_user where id = '5555555555'");
var_dump($count); // int(0)
```

删除操作需要注意的问题和更新操作是一样的，那就是同样的 exec() 只是返回影响行数的问题，不过相对于更新操作来说，没有受影响的行数那肯定是删除失败的，没有数据被删除。同样的，这个失败的提示也请根据业务情况来具体分析。

## 总结

不学不知道，一学吓一跳吧，简简单的一个 PDO 的创建和语句执行竟然有这么多的内容。对于我们的日常开发来说，掌握这些原理能够避免很多莫名其妙的问题，比如上面 exec() 只是返回影响行数在业务开发中如何判断操作是否成功的问题就很典型。好了，这只是第一篇，后面的学习不要落下了哦！

测试代码：

参考文档：

[https://www.php.net/manual/zh/pdo.construct.php](https://www.php.net/manual/zh/pdo.construct.php)

[https://www.php.net/manual/zh/pdo.query.php](https://www.php.net/manual/zh/pdo.query.php)

[https://www.php.net/manual/zh/pdo.exec.php](https://www.php.net/manual/zh/pdo.exec.php)

[https://www.php.net/manual/zh/pdo.lastinsertid.php](https://www.php.net/manual/zh/pdo.lastinsertid.php)

[https://www.php.net/manual/zh/ref.pdo-mysql.connection.php](https://www.php.net/manual/zh/ref.pdo-mysql.connection.php)
