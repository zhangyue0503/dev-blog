# 玩转PHP中的抽象类与接口

在面向对象开发中，特别是使用现代化框架的过程中，我们经常会和接口、抽象类打交道。特别是我们自己尝试去封装一些功能时，接口和抽象类往往会是我们开始的第一步，但你真的了解它们吗？

#### **抽象类定义**

抽象类的特点：
- 顾名思义，它是抽象的，当然也就是不能被实例化的。所以，抽象类一般是作为我们的基类来进行定义的。
- 在一个类中，只要有一个方法被定义为抽象的，那么这个类就必须加上abstract关键字成为抽象类。
- 被定义为抽象的方法只声明其调用方式，不能定义其具体的功能实现。
- 子类必须定义父类中的所有抽象方法，这些方法的访问控制必须和父类一致或者更为宽松。
- 方法的调用方式必须匹配，即类型和所需参数数量必须一致。子类实现的抽象方法可以增加参数但必须有默认值。

```php
abstract class A {
    public function show(){
        $this->getName();
        echo PHP_EOL;
    }

    protected abstract function getName();
    public abstract function getAge($age);
}

class ChildA1 extends A {
    public function getName(){
        echo "I'm ChildA1";
    }
    public function getAge($age){
        echo "Age is " . $age;
    }
}

class ChildA2 extends A {
    protected function getName(){
        echo "I'm ChildA2";
    }
    public function getAge($age, $year = ''){
        echo "Age is ". $age . ', bron ' . $year;
    }
}

$ca1 = new ChildA1();
$ca1->show();
$ca1->getAge(18);

$ca2 = new ChildA2();
$ca2->show();
$ca2->getAge(20, 2000);
```

#### **接口定义**

接口的特点：
- 可以指定某个类必须实现哪些方法，但不需要定义这些方法的具体内容。
- 就像定义一个标准的类一样，但其中定义所有的方法都是空的。
- 接口中定义的所有方法都必须是公有，这是接口的特性。
- 类中必须实现接口中定义的所有方法，否则会报一个致命错误。类可以实现多个接口，用逗号来分隔多个接口的名称。
- 类要实现接口，必须使用和接口中所定义的方法完全一致的方式。否则会导致致命错误
- 接口也可以继承，通过使用 extends 操作符
- 接口中也可以定义常量。接口常量和类常量的使用完全相同，但是不能被子类或子接口所覆盖

```php
interface B1 {
    const B1_NAME = 'Interface B1';
    function getName();
    function getAge($age);
}

interface B2 extends B1 {
    function show();
}

interface B3 {
    function getSchool();
}

class ChildB implements B2, B3{
    function getName(){
        echo "I'm ChildB";
    }
    function getAge($age, $year = ''){
        echo "Age is " . $age;
    }
    function show(){
        $this->getName();
        echo PHP_EOL;

        $this->getAge(23, 1997);
        echo PHP_EOL;

        echo self::B1_NAME;
        echo PHP_EOL;
    }
    
    function getSchool(){
        echo "study in Peking University";
        echo PHP_EOL;
    }
}

$b = new ChildB();
$b->show();
$b->getSchool();
```

#### **抽象类和接口的区别**

从上面我们可以总结出一些抽象类和接口的区别：
- 抽象类的子类遵循继承原则，只能有一个父类；但一个类可以实现多个接口
- 抽象类中可以有非抽象的已经实现的方法；接口中全是抽象的方法，都是方法定义
- 抽象类中方法和变量的访问控制自己定义；接口中只能是公共的

那么问题来，这两货哪个好？抱歉，这个问题可没有答案，它们的作用不同。抽象类可以作为基类，为子类提供公共方法，并定制公共的抽象让子类来实现。而接口则是更高层次的抽象，它可以让我们依赖于抽象而不是具体的实现，为软件开发带来更多的扩展性。

#### **面向接口开发**

接口，实际上也可以看做是一种契约。我们经常会拿电脑主机箱后面的插口来说明。比如USB接口，我们定义了它的大小，里面的线路格式，不管你插进来的是什么，我们都可以连通。而具体的实现则是取决于电脑软件对插入的硬件的解释，比如U盘就会去读取它里面的内容，而键盘则会识别为一个外设。

从这里可以看出，接口能够为我们程序的扩展提供非常强大的支撑。任何面向对象语言中接口都是非常重要的特性。下面我们来用接口模拟刚刚说的USB插口。

```php
interface USB{
    function run();
}

class Keyboard implements USB{
    function run(){
        echo "这是键盘";
    }
}

class UDisk implements USB{
    function run(){
        echo "这是U盘";
    }
}
```

这么写有什么好处呢？我们再深入一个概念：依赖注入。如果使用面向接口开发的话：

```php
function testUSB (USB $u){
    $u->run();
}

// 插入U盘
testUSB(new UDisk);

// 插入键盘
testUSB(new Keyboard);
```

testUSB方法中的$u并不是某个具体实例，保是USB接口的抽象，在不知道它是什么实例的情况下我们通过接口契约，保证它一定会有一个run()方法。而具体的实现，则是在外部我们调用方法的时候注入进来的。

### **总结**

掌握好接口的设计原则，往往就能看懂一大半的框架的设计思想。这也是我们面向对象中最最基础的特性。抽象类作为公共基类来说可以为多态提供比较好的范本，它能够让你的子类有自己的个性又能使用父类的能力。总之，深入场景业务，选择合适的方式实现代码，靠的是能力、经验与智慧的综合，决不是一句谁好谁不好所能定性的。

测试代码：
[]()

参考文档：
[https://www.php.net/manual/zh/language.oop5.abstract.php](https://www.php.net/manual/zh/language.oop5.abstract.php)
[https://www.php.net/manual/zh/language.oop5.interfaces.php](https://www.php.net/manual/zh/language.oop5.interfaces.php)
[https://www.php.net/manual/zh/language.oop5.interfaces.php#79110](https://www.php.net/manual/zh/language.oop5.interfaces.php#79110)