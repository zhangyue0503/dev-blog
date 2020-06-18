# 一起学习PHP的runkit扩展如何使用

这次又为大家带来一个好玩的扩展。我们知道，在 PHP 运行的时候，也就是部署完成后，我们是不能修改常量的值，也不能修改方法体内部的实现的。也就是说，我们编码完成后，将代码上传到服务器，这时候，我们想在不修改代码的情况去修改一个常量的值是不行的。常量本身就是不允许修改的。但是，runkit 扩展却可以帮助我们完成这个功能。

## 动态修改常量

```php
define('A', 'TestA');

runkit_constant_redefine('A', 'NewTestA');

echo A; // NewTestA
```

是不是很神奇。这个 runkit 扩展就是在运行时可以让我们来动态的修改一些常量、方法体及类的功能扩展。当然，从系统安全的角度来来，这个扩展并不是很推荐。因为本身常量的含义就是不变的量，本身就不应该修改的。同理，在运行时动态的改变函数体或者类定义的内容都是会有可能影响到其它调用到这些函数或类的代码，所以，这个扩展是一个危险的扩展。

除了动态地修改常量外，我们还可以使用 runkit_constant_add() 、 runkit_constant_remove() 函数来动态地增加或者删除常量。

## 安装

runkit 扩展的安装是需要在 githup 下载然后进行正常的扩展编译即可，pecl 下载的已经过时了。

PHP5: [http://github.com/zenovich/runkit](http://github.com/zenovich/runkit)

PHP7：[https://github.com/runkit7/runkit7.git](https://github.com/runkit7/runkit7.git)

clone 成功后进行正常的扩展编译安装步骤即可。

```shell
phpize
./configure
make
make install
```

不同的 PHP 版本需要安装不同版本的扩展，同时，runkit7 还在开发中，有一些函数还没有支持，比如：

- runkit_class_adopt
- runkit_class_emancipate 
- runkit_import
- runkit_lint_file
- runkit_lint 
- runkit_sandbox_output_handler
- runkit_return_value_used 
- Runkit_Sandbox
- Runkit_Sandbox_Parent 

在写这篇文章的测试代码时，上述函数或者类都是不支持的。大家可以用 PHP5 的环境测试下原版的扩展是否都能正常使用。

## 查看超全局变量键

```php
print_r(runkit_superglobals());
//Array
//(
//    [0] => GLOBALS
//    [1] => _GET
//    [2] => _POST
//    [3] => _COOKIE
//    [4] => _SERVER
//    [5] => _ENV
//    [6] => _REQUEST
//    [7] => _FILES
//    [8] => _SESSION
//)
```

这个函数其实就是查看下当前运行环境中的所有超全局变量键名。这些都是我们常用的一些超全局变量，就不一一解释了。

## 方法相关操作

方法操作就和常量操作一样，我们可以动态地添加、修改、删除以及重命名各种方法。首先还是来看一下我们最关心的在动态运行时来修改方法体里面的逻辑代码。

```php
function testme() {
  echo "Original Testme Implementation\n";
}
testme(); // Original Testme Implementation
runkit_function_redefine('testme','','echo "New Testme Implementation\n";');
testme(); // New Testme Implementation
```

定义了一个 testme() 方法，然后通过 runkit_function_redefine() 来修改它的实现，最后再次调用 testme() 时输出的就是新修改后的实现了。那么，我们能不能修改 PHP 自带的那些方法呢？

```php
// php.ini runkit.internal_override=1
runkit_function_redefine('str_replace', '', 'echo "str_replace changed!\n";');
str_replace(); // str_replace changed!

runkit_function_rename ('implode', 'joinArr' );
var_dump(joinArr(",", ['a', 'b', 'c'])); 
// string(5) "a,b,c"


array_map(function($v){
   echo $v,PHP_EOL;
},[1,2,3]);
// 1
// 2
// 3
runkit_function_remove ('array_map');

// array_map(function($v){
//   echo $v;
// },[1,2,3]);
// PHP Fatal error:  Uncaught Error: Call to undefined function array_map()
```

代码里的注释说的很清楚了，我们只需要在 php.ini 中设置 runkit.internal_override=1 ，就可以动态地修改 PHP 自带的那些方法函数了。比如第一段我们修改了 str_replace() 方法，让他直接就输出了一段文字。然后我们将 implode() 改名为 joinArr() ，就可以像 implode() 一样来使用这个 joinArr() 。最后，我们删除了 array_map() 方法，如果再次调用这个方法，就会报错。

## 类方法相关操作

类内部方法函数的操作和上面变量方法操作是类似的，不过对于 PHP 自带的类我们无法进行修改之类的操作。这个大家可以自己尝试一下。

```php
//runkit_method_add('PDO', 'testAddPdo', '', 'echo "This is PDO new Func!\n";');
//PDO::testAddPdo();
// PHP Warning:  runkit_method_add(): class PDO is not a user-defined class
```

从报错信息可以看出，PDO 类不是用户定义的类，所以无法使用 runkit 函数进行相关操作。那我们就来看看我们自定义的类是如何使用 runkit 来进行动态操作的吧。

```php
class Example{
}

runkit_method_add('Example', 'func1', '', 'echo "This is Func1!\n";');
runkit_method_add('Example', 'func2', function(){
    echo "This is Func2!\n";
});
$e = new Example;
$e->func1(); // This is Func1!
$e->func2(); // This is Func2!

runkit_method_redefine('Example', 'func1', function(){
    echo "New Func1!\n";
});
$e->func1(); // New Func1!

runkit_method_rename('Example', 'func2', 'func22');
$e->func22(); // This is Func2!

runkit_method_remove('Example', 'func1');
//$e->func1();
// PHP Fatal error:  Uncaught Error: Call to undefined method Example::func1()
```

我们定义了一个空类，然后动态给它添加了两个方法，之后修改了方法1，重命名了方法2，最后删除了方法1，一系列的操作其实和上面的普通方法的操作基本是一样的。

## 总结

就像上面说过的一样，这个扩展是比较危险的一个扩展，特别是如果开启了 runkit.internal_override 后，我们还能够修改 PHP 的原生函数。不过如果是必须要使用它的话，那么它的这些功能就非常有用。就像 访问者模式 一样，“大多时候你并不需要访问者模式，但当一旦你需要访问者模式时，那就是真的需要它了”，这一套 runkit 扩展也是一样的道理。

测试代码：


参考文档：

[https://www.php.net/manual/zh/book.runkit.php](https://www.php.net/manual/zh/book.runkit.php)
[https://www.php.net/manual/zh/book.runkit7.php](https://www.php.net/manual/zh/book.runkit7.php)