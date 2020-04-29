# 让PHP能够调用C的函数-FFI扩展

在大型公司中，一般会有很我编程语言的配合。比如说让 Java 来做微服务层，用 C++ 来进行底层运算，用 PHP 来做中间层，最后使用 JS 展现效果。这些语言间的配合大部分都是通过 RPC 来完成，或者直接将数据入库再使用不同的语言来取用。那么，我们 PHP 的代码能否直接调用这些语言呢？其实，PHP 还真为我们准备了一个可以直接调用 C 语言的扩展库，并且这个扩展库还是已经默认内置在 PHP 中了，它就是 FFI 扩展。

## 什么是 FFI 

FFI ， Foreign Function Interface，外部函数接口。这个扩展允许我们加载一些公共库（.dll、.so），其实也就是可以调用一些 C 的数据结构及函数。它已经是随 PHP 源码发布的一个扩展了，在编译的时候可以加上 --with-ffi 来直接编译到 PHP 程序中。

我们这里已经是编译好的 PHP ，所以我们直接找到这个扩展，进行简单的扩展安装步骤就可以安装完成。

```php
cd php-7.4.4/ext/ffi/
phpize
./configure
make && make install
```

安装完成后记得在 php.ini 文件中打开扩展。关于这个扩展需要注意的一点是，它有一个配置项为 ffi.enable ，默认情况下这个配置项的值是 "preload" ，仅在 CLI SAPI 环境下启用 FFI 的能力。当然，我们也可以修改为 "true" 或 "false" 来开启和关闭它。设定为 "true" 将使得这个扩展在任何环境下都启用。

## 使用 FFI 调用 C 的函数

接下来，简单地看一下它是如何调用 C 的函数的。

```php
// 创建一个 FFI 对象，加载 libc 并且导入 printf 函数
$ffi_printf = FFI::cdef(
    "int printf(const char *format, ...);", // C 的定义规则
    "libc.so.6"); // 指定 libc 库
// 调用 C 的 printf 函数
$ffi_printf->printf("Hello %s!\n", "world"); // Hello World

// 加载 math 并且导入 pow 函数
$ffi_pow = FFI::cdef(
    "double pow(double x, double y);", 
    "libboost_math_c99.so.1.66.0");
// 这里调用的是 C 的 pow 函数，不是 PHP 自己的
echo $ffi_pow->pow(2,3), PHP_EOL; // 8
```

我们创建了两个对象，分别调用了 C 的 printf() 和 pow() 函数。FFI::cdef() 是用于创建一个 FFI 对象，它接收两个参数，一个是包含常规C语言（类型、结构、函数、变量等）声明序列的字符串。实际上，这个字符串可以从C头文件复制粘贴。而另一个参数则是要加载并定义链接的共享库文件的名称。也就是我们需要的 .dll 或 .so 文件，它与我们声明字符串是对应的，比如在 libc.so.6 中并没有 pow() 这类的计算函数，所以我们就要找到 math 相关的 C 语言计算函数库。

## 定义变量和数组

当然，FFI 也是可以定义变量和数组的。

```php
// 创建一个 int 变量
$x = FFI::new("int");
var_dump($x->cdata); // int(0)

// 为变量赋值
$x->cdata = 5;
var_dump($x->cdata); // int(5)

// 计算变量
$x->cdata += 2;
var_dump($x->cdata); // int(7)


// 结合上面的两个 FFI 对象操作

echo "pow value:", $ffi_pow->pow($x->cdata, 3), PHP_EOL;
// pow value:343
$ffi_printf->printf("Int Pow value is : %f\n", $ffi_pow->pow($x->cdata, 3));
// Int Pow value is : 343.000000


// 创建一个数组
$a = FFI::new("long[1024]");
// 为数组赋值
for ($i = 0; $i < count($a); $i++) {
    $a[$i] = $i;
}
var_dump($a[25]); // int(25)

$sum = 0;
foreach ($a as $n) {
    $sum += $n;
}
var_dump($sum); // int(523776)

var_dump(count($a)); // int(1024) 数组长度
var_dump(FFI::sizeof($a)); // int(8192)，内存大小
```

使用 FFI::new() 函数来创建一个 C 的数据结构，也就是变量声明，这些变量的内容将保存在 cdata 属性中。而数组则直接就可以操作这个函数的返回值。当然，当我们要结束使用的时候，还是需要使用 FFI::free() 来释放变量的，就和 C 语言的开发一样。

## 总结

是不是感觉很高大上？但是请注意哦，FFI 调用的 C 函数并没有 PHP 本身去调用的效率高。比如这种 pow() 函数，使用 PHP 自身的效率更好。而且，FFI 扩展虽说已经是跟随 PHP 同步发布的扩展，但它还是处于实验性质的。也就是说，这个扩展是为未来可能用到的其它功能准备的，而且还有很多不确定性。所以在生产环境中如果需要合适类似的功能的话，那么还是要做更多的深入调研哦。

测试代码：


参考文档：
[https://www.php.net/manual/zh/intro.ffi.php][https://www.php.net/manual/zh/intro.ffi.php]
[https://www.php.net/manual/zh/ffi.examples-basic.php][https://www.php.net/manual/zh/ffi.examples-basic.php]
