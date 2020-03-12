# 关于PHP的方法参数类型约束

在之前的文章[PHP方法参数的那点事儿](https://mp.weixin.qq.com/s/G2N8-BXAQvnac5emez6BPA)中，我们讲过关于PHP方法参数的一些小技巧。今天，我们带来的是更加深入的研究一下PHP中方法的参数类型。

在PHP5之后，PHP正式引入了方法参数类型约束。也就是如果指定了方法参数的类型，那么传不同类型的参数将会导致错误。在PHP手册中，方法的类型约束仅限于类、接口、数组或者callable回调函数。如果指定了默认值为NULL，那么我们也可以传递NULL作为参数。

```php
class A{}
function testA(A $a){
    var_dump($a);
}

testA(new A());
// testA(1); 
// Fatal error: Uncaught TypeError: Argument 1 passed to testA() must be an instance of A, int given,
```

在这个例子中，我们定义了参数类型为A类，所以当我们传递一个标量类型时，直接就会返回错误信息。

```php
function testB(int $a){
    var_dump($a);
}
testB(1);
testB('52aadfdf'); // 字符串强转为int了
// testB('a');
// Fatal error: Uncaught TypeError: Argument 1 passed to testB() must be of the type int, string given

function testC(string $a){
    var_dump($a);
}
testC('测试');
testC(1);  // 数字会强转为字符串
// testC(new A()); 
// Fatal error: Uncaught TypeError: Argument 1 passed to testC() must be of the type string
```

在手册中明确说明了标量类型是不能使用类型约束的。但其实是可以使用的，不过如果都是标量类型则会进行相互的强制转换，并不能起到很好的约束作用。比如上例中int和string类型进行了相互强制转换。指定了非标量类型，则会报错。此处是本文的重点，小伙伴们可要划个线了哦。其实说白了，如果我们想指定参数的类型为固定的标量类型的话，在参数中指定并不是一个好的选择，最好还是在方法中进行再次的类型判断。而且如果参数中进行了强转，也会导致方法内部的判断产生偏差。

最后我们再看一看接口和匿名方法的类型约束。匿名参数类型在Laravel等框架中非常常见。

```php
// 接口类型
interface D{}
class childD implements D{}
function testD(D $d){
    var_dump($d);
}
testD(new childD());

// 回调匿名函数类型
function testE(Callable $e, string $data){
    $e($data);
}
testE(function($data){
    var_dump($data);
}, '回调函数');
```

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/%E5%85%B3%E4%BA%8EPHP%E7%9A%84%E6%96%B9%E6%B3%95%E5%8F%82%E6%95%B0%E7%B1%BB%E5%9E%8B%E7%BA%A6%E6%9D%9F.md](https://github.com/zhangyue0503/dev-blog/blob/master/php/202001/%E5%85%B3%E4%BA%8EPHP%E7%9A%84%E6%96%B9%E6%B3%95%E5%8F%82%E6%95%B0%E7%B1%BB%E5%9E%8B%E7%BA%A6%E6%9D%9F.md)

参考文档：
[https://www.php.net/manual/zh/language.oop5.typehinting.php](https://www.php.net/manual/zh/language.oop5.typehinting.php)

