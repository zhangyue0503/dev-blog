# PHP7.4新特性

PHP7.4版本已经正式发布了，做为PHP7版本的最后一次大更新，这一次又为我们带来了什么新特性呢？

### **属性类型**

PHP7.4中的类属性终于可以为属性指定变量类型了。一切都是为了JIT铺垫。静态固定类型的引入将让PHP更加的工程化。

```php
class User {
    public int $id;
    public string $name;
}
```

### **箭头函数**

好吧，上一个是向Java、C++看齐，这一个就是把JavaScript的又一强大特性搬了过来。箭头函数不陌生吧，配合匿名函数简直不要太香。

```php
$factor = 10;
$nums = array_map(fn($n) => $n * $factor, [1, 2, 3, 4]);
```

### **空值合并赋值运算操作符**

PHP7的??操作符这次也带来了更新，这回直接可以进行合并赋值操作了。多行代码或者原来用??写得很长的代码这回可以写得更少了。

```php
$array['key'] ??= computeDefault();
// is roughly equivalent to
if (!isset($array['key'])) {
    $array['key'] = computeDefault();
}
```

### **数组元素解包**

...操作符可以用在数组元素中了。

```php
$parts = ['apple', 'pear'];
$fruits = ['banana', 'orange', ...$parts, 'watermelon'];
// ['banana', 'orange', 'apple', 'pear', 'watermelon'];
```

### **数字文本可包含下划线**

```php
6.674_083e-11; // float
299_792_458;   // decimal
0xCAFE_F00D;   // hexadecimal
0b0101_1111;   // binary
```

### **strip_tags()可以使用数组定义保留的标签**

```php
strip_tags($str, ['a', 'p']);
// 原来要这么写
strip_tags($str, '<a><p>');
```

### **新增自定义对象序列化魔术方法**

原来的__sleep()和__weakup()说实话真的太不形象了。睡着和起床了来表示序列化和反序列操作。这个...

不过总算是给掰回来了。PHP7.4新定义了__serialize()和__unserialize()方法。

```php
// Returns array containing all the necessary state of the object.
public function __serialize(): array;

// Restores the object state from the given data array.
public function __unserialize(array $data): void;
```

### **其他**

- 弱引用：允许程序员保留对某个对象的引用，该对象不会阻止该对象被销毁。
- __toString中出现的错误从可恢复的错误转换为错误异常，可被try/catch
- 添加mb_str_split()函数

参考文档：
[https://www.php.net/manual/zh/migration74.new-features.php](https://www.php.net/manual/zh/migration74.new-features.php)