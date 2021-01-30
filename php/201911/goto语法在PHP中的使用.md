# goto语法在PHP中的使用

在C++、Java及很多语言中，都存在着一个神奇的语法，就是goto。顾名思义，它的使用是直接去到某个地方。从来代码的角度来说，也就是直接跳转到指定的地方。我们的PHP中也有这个功能，我们先来看看它是如何使用的：

```php
goto a;
echo "1"; // 不会输出

a:
echo '2'; // 2
```

代码运行到goto位置时，就跳转到了a:所在的代码行并继续执行下去。感觉很好玩吧，这个功能对于复杂的嵌套if或者在一些循环中进行跳出很有用，特别是针对某些异常或者错误情况的处理，比如：

```php
for ($i = 0, $j = 50; $i < 100; $i++) {
    while ($j--) {
        if ($j == 17) { // 假设$j==17是一种异常情况
            goto end; // 直接跳走了，循环结束的结果也不输出了
        }

    }
}
echo "i = $i";
end:
echo 'j hit 17'; // 直接到这里输出或者处理异常情况了
```

感觉还不错是吧，不过goto语法也有一些限制情况：

- 目标位置只能位于同一个文件和作用域，也就是说无法跳出一个函数或类方法，也无法跳入到另一个函数
- 无法跳入到任何循环或者 switch 结构中
- 跳出循环或者 switch，通常的用法是用 goto 代替多层的 break

比如以下的代码都是无效的：

```php
$a = 1;
goto switchgo;
switch ($a){
    case 1:
        echo 'bb';
    break;
    case 2:
        echo 'cc';
        switchgo:
            echo "bb";
    break;
}

goto whilego;
while($a < 10){
    $a++;
    whilego:
        echo $a;
}


// Fatal error: 'goto' to undefined label 'ifgo' 
```

它们都会报同样的错误，因为作用域的关系无法找到定义的goto标签。另外还需要注意的，使用goto可能引起死循环，如下所示：

```php
b:
    echo 'b';

goto b;
```

代码执行到goto时，跳回了之前的b标签行，然后继续向下执行，又到goto了，成为了一个死循环。有点像while(true)的感觉了。但是，在这个goto循环里是没有break的，只能在goto出去到别的地方。

所以，goto这个语法的使用非常少，因为它会扰乱你的代码逻辑流程，但喜欢它的人又会感觉到可以让代码非常地灵活多变。这就要仁者见仁智者见智的进行选择了，目前大多数语言的文档中都并不是很提倡使用这个语法，包括PHP。我的建议是，如果不是非常特殊的情况或者是为了炫技，尽量不要使用goto语法，当项目代码复杂起来后，很容易让别人或者自己看懵。

测试代码：[https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/goto%E8%AF%AD%E6%B3%95%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.md](https://github.com/zhangyue0503/dev-blog/blob/master/php/201911/goto%E8%AF%AD%E6%B3%95%E5%9C%A8PHP%E4%B8%AD%E7%9A%84%E4%BD%BF%E7%94%A8.md)

参考文档：[https://www.php.net/manual/zh/control-structures.goto.php](https://www.php.net/manual/zh/control-structures.goto.php)