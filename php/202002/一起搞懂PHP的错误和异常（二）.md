# 一起搞懂PHP的错误和异常（二）

上回文章中我们讲到了错误是编译和语法运行时会出现的，它们与逻辑无关，是程序员在码代码时不应该出现的，也就是说，这些错误应该是尽量避免带到线上环境的，他们不能通过try...catch捕获到。而异常则正好相反。

## 什么是异常？

异常，指的是程序运行中出现的不符合预期的情况，通常允许它发生，并交由相应的异常处理来进行处理。当然，你也可以选择忽略掉异常的处理，但是就像严重错误一样，代码马上会终止运行。异常属于业务逻辑上的错误，基本上是我们人为的。

还是先通过一个简单的代码看下异常的抛出和捕获：

```php
function test()
{
    throw new Exception('This is test Error...');
}

try {
    test();
} catch (Exception $e) {
    print_r($e);
}
```

我们通过 throw 来抛出异常，然后在调用方法时将方法包裹在 try...catch 块中来捕获抛出的异常。这就是异常最基础的结构。

从这里我们可以看出，异常基本都是通过我们手动进行抛出的，让外部来进行处理。在PHP内部多数也是在类中会进行异常的抛出，这就是面向对象的错误处理思想了。比如说PDO类：

```php
try {
    // $pdo = new PDO(); // Fatal error: Uncaught ArgumentCountError: PDO::__construct() expects at least 1 parameter, 0 given
    $pdo = new PDO('');
} catch (PDOException $e) {
    print_r($e); // invalid data source name
}
```

注意上面那行注释的代码，没有传参数是错误，是无法捕获的。而传了的参数不对，就是异常了，在PDO类的源码中发现参数不对进行了抛出。交给上层代码也就是我们这些调用方来进行捕获。

接下来，我们看下自定义的异常类和finally语句块的使用。

自定义的异常类都会去继承 Exception 类，这个类可以看做是所有异常的基类。它的结构如下：

```php
class Exception
{
    protected $message = 'Unknown exception';   // 异常信息
    private   $string;                          // __toString cache
    protected $code = 0;                        // 用户自定义异常代码
    protected $file;                            // 发生异常的文件名
    protected $line;                            // 发生异常的代码行号
    private   $trace;                           // backtrace
    private   $previous;                        // previous exception if nested exception

    public function __construct($message = null, $code = 0, Exception $previous = null);

    final private function __clone();           // 不能被复制，如果clone异常类将直接产生致命错误

    final public  function getMessage();        // 返回异常信息
    final public  function getCode();           // 返回异常代码
    final public  function getFile();           // 返回发生异常的文件名
    final public  function getLine();           // 返回发生异常的代码行号
    final public  function getTrace();          // backtrace() 数组
    final public  function getPrevious();       // 之前的 exception
    final public  function getTraceAsString();  // 已格成化成字符串的 getTrace() 信息

    // Overrideable
    public function __toString();               // 可输出的字符串
}
```

通过上述类定义，我们可以看出，我们能重写 构造函数 和 __toString() 方法，也能使用一些受保护的属性。那么我们就来定义一个自定义的异常类吧。

```php
class TestException extends Exception
{
    protected $code = 200;

    public function __construct($message = null, $code = 0, Exception $previous = null){
        $this->message = 'TestException：' . $message;
    }

    public function __toString(){
        return 'code: ' . $this->code . '; ' . $this->message;
    }
}

function test2()
{
    throw new TestException('This is test2 Error...');
}

try {
    test2();
} catch (TestException $e) {
    echo $e, PHP_EOL; // code: 200; TestException：This is test2 Error...
}
```

还是非常好理解的吧，大部分的PHP框架都会有自定义异常的组件或者能力供我们使用，因为现代框架还是以面向对象为基础的，所以异常会定义的比较详细。不同组件会提供不同的异常类来进行异常的提示封装。

接下来就是 finally 关键字，其实这个并没有什么可多说的，finally 的特点就是不管有没有出现异常，都会去执行 finally 关键字所定义代码块内部的内容。

```php
try {
    test2();
} catch (TestException $e) {
    echo $e, PHP_EOL; 
} finally {
    echo 'continue this code ...', PHP_EOL;
}
// code: 200; TestException：This is test2 Error...
// continue this code ...
```

说了这么多，最后我们来结合上述内容来处理下除0错误的异常抛出。在文章开头已经说过，错误是应该避免的，而异常是属于逻辑业务的。所以当我们接到一个需要做除法的参数时，可以先判断这个数是否为0，如果是0的话，就抛出异常让上层调用者来处理，如果不是0的话，就让它正常进行除法运算就好了。

```php
function test3($d)
{
    if ($d == 0) {
        throw new Exception('除数不能为0');
    }
    return 1 / $d;
}

try {
    echo test3(2), PHP_EOL;
} catch (Exception $e) {
    echo 'Excepition：' . $e->getMessage(), PHP_EOL;
} finally {
    echo 'finally：继续执行！', PHP_EOL;
}

// 0.5
// finally：继续执行！

try {
    echo test3(0), PHP_EOL;
} catch (Exception $e) {
    echo 'Excepition：' . $e->getMessage(), PHP_EOL;
} finally {
    echo 'finally：继续执行！', PHP_EOL;
}

// Excepition：除数不能为0
// finally：继续执行！
```

## 总结
异常相关的使用就是这些了，通过这两篇文章，相信大家已经对PHP的错误和异常有了一些直观的了解了。接下来的文章我们将一起对比下错误和异常，并且说明一下PHP7对错误有了哪些改进。内容依然精彩，值得期待哦！！

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E4%B8%80%E8%B5%B7%E6%90%9E%E6%87%82PHP%E7%9A%84%E9%94%99%E8%AF%AF%E5%92%8C%E5%BC%82%E5%B8%B8%EF%BC%88%E4%BA%8C%EF%BC%89.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202002/source/%E4%B8%80%E8%B5%B7%E6%90%9E%E6%87%82PHP%E7%9A%84%E9%94%99%E8%AF%AF%E5%92%8C%E5%BC%82%E5%B8%B8%EF%BC%88%E4%BA%8C%EF%BC%89.php)

参考文档：
[https://www.cnblogs.com/init-007/p/11242813.html](https://www.cnblogs.com/init-007/p/11242813.html)
[https://www.php.net/manual/zh/language.exceptions.php](https://www.php.net/manual/zh/language.exceptions.php)
[https://www.php.net/manual/zh/class.exception.php](https://www.php.net/manual/zh/class.exception.php)
[https://www.php.net/manual/zh/language.exceptions.extending.php](https://www.php.net/manual/zh/language.exceptions.extending.php)


