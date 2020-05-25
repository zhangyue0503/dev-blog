# 使用Serializable接口来自定义PHP中类的序列化

关于PHP中的对象序列化这件事儿，之前我们在很早前的[]()文章中已经提到过 __sleep() 和 __weakup() 这两个魔术方法。今天我们介绍的则是另外一个可以控制序列化内容的方式，那就是使用 Serializable 接口。它的使用和上述两个魔术方法很类似，但又稍有不同。

## Serializable接口

```php
class A implements Serializable {
    private $data;
    public function __construct(){
        echo '__construct', PHP_EOL;
        $this->data = "This is Class A";
    }

    public function serialize(){
        echo 'serialize', PHP_EOL;
        return serialize($this->data);
    }

    public function unserialize($data){
        echo 'unserialize', PHP_EOL;
        $this->data = unserialize($data);
    }

    public function __destruct(){
        echo '__destruct', PHP_EOL;
    }

    public function __weakup(){
        echo '__weakup', PHP_EOL;
    }

    public function __sleep(){
        echo '__destruct', PHP_EOL;
    }
    
}

$a = new A();
$aSerialize = serialize($a);

var_dump($aSerialize);
// "C:1:"A":23:{s:15:"This is Class A";}"
$a1 = unserialize($aSerialize);
var_dump($a1);
```

这段代码就是使用 Serializable 接口来进行序列化处理的，注意一点哦，实现了 Serializable 接口的类中的 __sleep() 和 __weakup() 魔术方法就无效了哦，序列化的时候不会进入它们。

Serializable 这个接口需要实现的是两个方法，serialize() 方法和 unserialize() 方法，是不是和那两个魔术方法完全一样。当然，使用的方式也是一样的。

在这里，我们多普及一点序列化的知识。对象序列化只能序列化它们的属性，不能序列化他们方法。如果当前能够找到对应的类模板，那么可以还原出这个类的方法来，如果没有定义过这个类的模板，那么还原出来的类是没有方法只有属性的。我们通过这段代码中的序列化字符串来分析：

- "C:"，指的是当前数据的类型，这个我面后面还会讲，实现 Serializable 接口的对象序列化的结果是 C: ，而没有实现这个接口的对象序列化的结果是 O: 
- "A:"，很明显对应的是类名，也就是类的::class
- "{xxx}"，对象结构和JSON一样，也是用的花括号

## 各种类型的数据进行序列化的结果

下面我们再来看下不同类型序列化的结果。要知道，在PHP中，我们除了句柄类型的数据外，其他标量类型或者是数组、对象都是可以序列化的，它们在序列化字符串中是如何表示的呢？

```php
$int = 110;
$string = '110';
$bool = FALSE;
$null = NULL;
$array = [1,2,3];

var_dump(serialize($int)); // "i:110;"
var_dump(serialize($string)); // "s:3:"110";"
var_dump(serialize($bool)); // "b:0;"
var_dump(serialize($null)); // "N;"
var_dump(serialize($array)); // "a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}"
```

上面的内容还是比较好理解的吧。不过我们还是一一说明一下：

- 数字类型：i:<值>
- 字符串类型：s:<长度>:<值>
- 布尔类型：b:<值:0或1>
- NULL类型：N;
- 数组：a:<长度>:<内容>

## 对象在使用Serializable接口序列化时要注意的地方

接下来，我们重点讲讲对象类型，上面已经提到过，实现 Serializable 接口的对象序列化后的标识是有特殊情况的。上方序列化后的字符串开头类型标识为 "C:"，那么我们看看不实现 Serializable 接口的对象序列化后是什么情况。

```php
// 正常对象类型序列化的结果
class B {
    private $data = "This is Class B";

}
$b = new B();
$bSerialize = serialize($b);

var_dump ($bSerialize); // "O:1:"B":1:{s:7:"Bdata";s:15:"This is Class B";}"
var_dump($bSerialize);
var_dump(unserialize("O:1:\"B\":1:{s:7:\"\0B\0data\";s:15:\"This is Class B\";}"));

// object(B)#4 (1) {
//     ["data":"B":private]=>string(15) "This is Class B"
// }
```

果然，它开头的类型标识是 "O:"。那么我们可以看出，"C:" 很大的概率指的是当前序列化的内容是一个类类型，不是一个对象类型。它们之间其实并没有显著的差异，包括官方文档上也没有找到特别具体的说明。如果有过这方面的研究或者有相关资料的同学可以评论留言一起讨论哈。

此外，如果我们手动将一个对象的 "O:" 转成 "C:" 会怎么样呢？

```php
// 把O:替换成C:
var_dump(unserialize(str_replace('O:', 'C:', $bSerialize))); // false
```

抱歉，无法还原了。那么我们反过来，将上面 A 类也就是实现了 Serializable 接口的序列化字符串中的 "C:" 转成 "O:" 呢？

```php
// Warning: Erroneous data format for unserializing 'A'
var_dump(unserialize(str_replace('C:', 'O:', $aSerialize))); // false
```

嗯，会提示一个警告，然后同样也无法还原了。这样看来，我们的反序列化还是非常智能的，有一点点的不同都无法进行还原操作。

## 未定义类的反序列化操作

最后，我们来看看未定义类的情况下，直接反序列化一个对象。

```php
// 模拟一个未定义的D类
var_dump(unserialize("O:1:\"D\":2:{s:7:\"\0D\0data\";s:15:\"This is Class D\";s:3:\"int\";i:220;}"));

// object(__PHP_Incomplete_Class)#4 (3) {
//     ["__PHP_Incomplete_Class_Name"]=>string(1) "D"
//     ["data":"D":private]=>string(15) "This is Class D"
//     ["int"]=>int(220)
// }

// 把未定义类的O:替换成C:
var_dump(unserialize(str_replace('O:', 'C:', "O:1:\"D\":2:{s:7:\"\0D\0data\";s:15:\"This is Class D\";s:3:\"int\";i:220;}"))); // false
```

从代码中，我们可以看出，"C:" 类型的字符串依然无法反序列化成功。划重点哦，*如果是C:开头的序列化字符串，一定需要是定义过的且实现了 Serializable 接口的类* 才能反序列化成功。

另外，我们可以发现，当序列化字符串中的模板不存在时，反序列化出来的类的类名是 __PHP_Incomplete_Class_Name 类，不像有类模板的反序列化成功直接就是正常的类名。

## 总结

其实从以上各种来看，个人感觉如果要保存数据或者传递数据的话，序列化并不是最好的选择。毕竟包含了类型以及长度后将使得格式更为严格，而且反序列化回来的内容如果没有对应的类模板定义也并不是特别好用的，还不如直接使用 JSON 来得方便易读。当然，具体情况具体分析，我们还是要结合场景来选择合适的使用方式。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/%E4%BD%BF%E7%94%A8Serializable%E6%8E%A5%E5%8F%A3%E6%9D%A5%E8%87%AA%E5%AE%9A%E4%B9%89PHP%E4%B8%AD%E7%B1%BB%E7%9A%84%E5%BA%8F%E5%88%97%E5%8C%96.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/%E4%BD%BF%E7%94%A8Serializable%E6%8E%A5%E5%8F%A3%E6%9D%A5%E8%87%AA%E5%AE%9A%E4%B9%89PHP%E4%B8%AD%E7%B1%BB%E7%9A%84%E5%BA%8F%E5%88%97%E5%8C%96.php)

参考文档：
[https://www.php.net/manual/zh/class.serializable.php](https://www.php.net/manual/zh/class.serializable.php)

