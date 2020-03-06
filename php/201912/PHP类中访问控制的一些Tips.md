# PHP类中访问控制的一些Tips

包括PHP在内的大部分面向对象的编程语言，都提供了对类的变量或方法的访问控制。这是实现面向对象封装能力的基础。变量其实就是数据，而方法函数就是处理这些数据的操作，根据最少知识原则，一些数据你不需要知道它的存在。这时，就需要使用private私有的变量和方法，私有的变量或方法只有这个类自己可以访问。而有些变量和方法自己的子类需要使用，但又不能暴露给外部，那么我们就会使用protected，也就是受保护的。最后就是公开不管类内部、外部还是继承的子类都可以使用的public公共变量或方法了。

我们通过变量的访问控制先来复习一下这三种访问控制符的作用。

```php
class A {
    private $private;
    protected $protected;
    public $public;

    public function setPrivate($p){
        $this->private = $p;
    }

    public function setProtected($p){
        $this->protected = $p;
    }

    public function setPublic($p){
        $this->public = $p;
    }

    public function testA(){
        echo $this->private, '===', $this->protected, '===', $this->public, PHP_EOL;
    }
}

class B extends A{
    public function testB(){
        echo $this->private, '===';
        echo $this->protected, '===', $this->public, PHP_EOL;
    }
}

$a = new A();
// $a->private = 'a-private'; // atal error: Uncaught Error: Cannot access private property A::$private 
$a->setPrivate('a-private');
// $a->protected = 'a-protected'; // atal error: Uncaught Error: Cannot access protected property A::$protected 
$a->setProtected('a-protected');
$a->public = 'c-public';
$a->testA();

echo "Out side public:" . $a->public, PHP_EOL;
// echo "Out side private:" . $a->private, PHP_EOL; // Fatal error: Uncaught Error: Cannot access private property A::$private
// echo "Out side protected:" . $a->protected, PHP_EOL; // Fatal error: Uncaught Error: Cannot access protected property A::$protected

$b = new B();
$b->setProtected('b-protected');
$b->public = 'b-public';
$b->testB(); // 没有b-private

$b->setPrivate('b-private');
$b->testB(); // 没有b-private

```

从上述代码中很清晰的可以看出，除了public之外的变量都不能在类外部直接调用或者赋值。所以我们使用setXXX()的public方法来为$private和$protected赋值。这里就出现了封装的概念了，比如在setPrivate()中我们就可以对传递过来的$p变量进行逻辑判断而决定是否将值赋给$private。

B类继承了A类，所以它可以访问到A类的$public和$protected变量，但是，请注意，$private变量是无法访问到的。所以即使调用了setPrivate()方法为$private赋值了，但因为B无法访问，所以依然取不到$private的值。有小伙伴要问了，这种情况不报错？当然不会报错，B类会在自己的范围内查找$private变量，没有定义的话就会生成一个局部的变量并赋值为空。

那么子类要使用$private应该怎么办呢？

```php
class C extends A {
    private $private;

    public function testC(){
        echo $this->private, '===', $this->protected, '===', $this->public, PHP_EOL;
    }

    // public function setPrivate($p){
    //     $this->private = $p;
    // }
}

$c = new C();
$c->setProtected('c-protected');
$c->public = 'c-public';
$c->setPrivate('c-private');
$c->testC();
```

先不要打开C类setPrivate()方法的注释，你会发现$private依然是空值。也就是说，定义了同名的$private私有变量并不是对父类的变量覆盖，而是在本类作用域内新建了一个。父类的setPrivate()方法当然也不能访问子类的private变量，因此，子类也要重写一个setPrivate()方法来为自己的$private变量赋值。

记住一点：**private修饰的变量或方法仅对当前类开放**

对于方法的修饰也是一样的效果。

```php
class D {
    public function testD(){
        $this->show();
    }
    private function show(){
        echo 'This is D', PHP_EOL;
    }
}

class E extends D {
    private function show(){
        echo 'This is E', PHP_EOL;
    }
}

$e = new E();
$e->testD(); // This is D
```

子类E调用父类D的testD()方法，testD()方法中调用的是private修饰的show()方法，根据上面的原则，它依然调用的是自己D类的show()方法。

### **总结**

关于访问控制的内容还是比较简单的，最主要的就是private这个修饰符的问题需要注意，其他的其实还是比较好理解的。不过越是简单的东西越是基础，面向对象脱离不了这三个简单的访问修饰符，它们在现代软件开发中的份量十足，只有牢牢掌握它们才是我们正确的学习之道。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E7%B1%BB%E4%B8%AD%E8%AE%BF%E9%97%AE%E6%8E%A7%E5%88%B6%E7%9A%84%E4%B8%80%E4%BA%9BTips.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/201912/source/PHP%E7%B1%BB%E4%B8%AD%E8%AE%BF%E9%97%AE%E6%8E%A7%E5%88%B6%E7%9A%84%E4%B8%80%E4%BA%9BTips.php)

参考文档：
[https://www.php.net/manual/zh/language.oop5.visibility.php#87413](https://www.php.net/manual/zh/language.oop5.visibility.php#87413)
[https://www.php.net/manual/zh/language.oop5.visibility.php#110555](https://www.php.net/manual/zh/language.oop5.visibility.php#110555)
[https://www.php.net/manual/zh/language.oop5.visibility.php](https://www.php.net/manual/zh/language.oop5.visibility.php)