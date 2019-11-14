# 彻底搞明白PHP中的include和require

在PHP中，有两种包含外部文件的方式，分别是include和require。他们之间有什么不同呢？

> 如果文件不存在或发生了错误，require产生E_COMPILE_ERROR级别的错误，程序停止运行。而include只产生警告，脚本会继续执行。

这就是它们最主要的区别，其他方面require基本等同于include。

- 被包含文件先按参数给出的路径寻找，如果没有给出目录（只有文件名）时则按照 include_path 指定的目录寻找。如果在 include_path 下没找到该文件则 include 最后才在调用脚本文件所在的目录和当前工作目录下寻找
- 如果定义了路径不管是绝对路径还是当前目录的相对路径 include_path 都会被完全忽略
- include_path 在php.ini中定义
- 当一个文件被包含时，其中所包含的代码继承了 include 所在行的变量范围。从该处开始，调用文件在该行处可用的任何变量在被调用的文件中也都可用。不过所有在包含文件中定义的函数和类都具有全局作用域

除了普通的require和include之外，还有require_once和include_once，他们的作用是：

- 如果该文件中已经被包含过，则不会再次包含。如同此语句名字暗示的那样，只会包含一次
- 可以用于在脚本执行期间同一个文件有可能被包含超过一次的情况下，想确保它只被包含一次以避免函数重定义，变量重新赋值等问题

我们来看些例子：

```php

// a.php 不存在
include "a.php"; // warning
// require "a.php"; // error

echo 111; // 使用include时111会输出

// file1.php 中只有一行代码echo 'file1';
require_once 'includeandrequire/file1.php'; // file1
require_once 'includeandrequire/file1.php'; // noting

include_once 'includeandrequire/file1.php'; // noting
include_once 'includeandrequire/file1.php'; // noting

require 'includeandrequire/file1.php'; // file1
require 'includeandrequire/file1.php'; // file1

require 'includeandrequire/file1.php'; // file1
require 'includeandrequire/file1.php'; // file1

```

我们可以看出当第一个_once加载成功后，后面不管是require_once还是include_once，都不会再加载这个文件了。而不带_once的则会重复加载文件。

```php

file2.php

<?php

echo 'file2:' . $a, PHP_EOL;
echo 'file2:' . $b, PHP_EOL;
$b = "file2";

myFile.php

<?php

$a = 'myFile';
$b = 'youFile';
require_once 'includeandrequire/file2.php';
echo $a, PHP_EOL;
echo $b, PHP_EOL;

// 输出结果
// file2:myFile
// file2:youFile
// myFile
// file2

file3.php
<?php

$c = 'file3';

myFile.php
<?php
function test(){
    require_once 'includeandrequire/file3.php';
    echo $c, PHP_EOL; // file3
}
test();
echo $c, PHP_EOL; // empty

```

被包含文件中可以获取到父文件中的变量，父文件也可以获得包含文件中的变量，但是，需要注意_once的一个特殊情况。

```php

function foo(){
    require_once 'includeandrequire/file3.php';
    return $c;
}

for($a=1;$a<=5;$a++){
    echo foo(), PHP_EOL;
}

// file3
// empty
// empty
// empty
// empty

```

使用_once并循环加载时，只有第一次会输出file3.php中的内容，这是为什么呢？因为现在的变量范围作用域在方法中，第一次加载完成后，后面的的文件不会再被加载了，这时后面四次循环并没有$c被定义，$c默认就是空值了。

如果两个方法中同时用_once加载了一个文件，第二个方法还会加载吗？

```php

function test1(){
    require_once 'includeandrequire/file1.php';
}
function test2(){
    require_once 'includeandrequire/file1.php';
}
test1(); // file1
test2(); // empty

```

抱歉，只有第一个方法会加载成功，第二个方法不会再次加载了。

那么，我们在日常的开发中，使用哪个更好呢？

- 从效率来说，_once需要验证是否已经加载过文件，效率会低一些，但是并不是绝对的，甚至是我们肉眼不可见的降低，所以可以忽略它的效率问题。而它带来的好处则比不带_once的多得多
- 本着错误提前的原则，使用require_once更好。因为将PHP报错级别调整为不显示警告后，include的警告信息会不可见，会带来不可预知的错误
- 在方法中使用时，不应该用_once来加载文件，特别是这个文件需要在多个类或者方法中使用时，使用_once可能会导致后面的方法中无法载相同的文件
- 使用require或include时，最好不要用括号，虽然的确可以这么使用，如 include ('xxx.php'); 它们是表达式关键字，不是系统方法，所以直接用 include 'xxx.php' 即可

include和require的文件如果有return，可以用变量接收retun回来的数据，另外它们还可以加载非PHP文件以及远程文件（远程加载需要确定php.ini中的allow_url_include为On），如：

```php

file4.php
<?php

return 'file4';

file4.txt
可以吧

myFile.php
<?php
$v = require 'includeandrequire/file4.php';
echo $v, PHP_EOL; // file4

include 'includeandrequire/file4.txt';
// 可以吧

include 'https://www.baidu.com/index.html';
// 百度首页的html代码

```

这下我们对于include和require的了解就非常深入了吧，这两个加载文件的方式并不复杂，但也很容易出现一些坑，特别是_once在方法中使用的时候一定要特别注意。最后，给一个小福利，封装一个一次性加载目录中所有文件的方法：

```php

function include_all_once ($pattern) {
    foreach (glob($pattern) as $file) { 
        require $file;
    }
}

include_all_once('includeandrequire/*');

```

测试代码：[]()

参考文档：
[https://www.php.net/manual/zh/function.require.php](https://www.php.net/manual/zh/function.require.php)
[https://www.php.net/manual/zh/function.include.php](https://www.php.net/manual/zh/function.include.php)
[https://www.php.net/manual/zh/function.require-once.php](https://www.php.net/manual/zh/function.require-once.php)
[https://www.php.net/manual/zh/function.include-once.php](https://www.php.net/manual/zh/function.include-once.php)