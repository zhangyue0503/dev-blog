# PHP的命令行扩展Readline相关函数学习

PHP 作为一个 Web 开发语言，相对来说，命令行程序并不是它的主战场。所以很多年轻的 PHP 开发者可能连命令行脚本都没有写过，更别提交互式的命令操作了。而今天，我们带来的这个扩展就是针对 PHP 的交互式命令行操作的。

*readline 扩展函数实现了访问 GNU Readline 库的接口。这些函数提供了可编辑的命令行。一个例子是在 Bash 中允许你使用箭头按键来插入字符或者翻看历史命令。因为这个库的交互特性，这个功能在你写的 Web 程序中没多大用处，但是当你写的脚本被用在命令行中时非常有用。*

## Readline 扩展的安装

Readline 扩展已经加入了 PHP 的官方安装包中，所以我们直接安装这个扩展是比较困难的，如果是新的 PHP 环境，那么在编译的时候加上 --with-readline 即可。另外，我们还需要安装操作系统的 Readline 库。当然，如果已经是正常运行的 PHP ，也可以重新编译一下。

```shell
# yum install -y readline-devel
# ./congiure xxxx --with-readline
```

默认情况下，如果没有在编译时增加 --whit-readline ，Readline 的一些函数也是可以使用的，不过它们调用的是系统的 libedit 库。有一些函数，比如 readline_list_history() 这种函数是无法使用的。要想完整的使用 Readline 扩展的能力，那么还是需要安装操作系统的 libreadline 库（上面 yum 安装的那个 readline-devel ）并在 PHP 中进行相应参数的编译安装。

## 基本函数操作

Readline 扩展提供的函数不多，也非常的简单易用。

### 读取一行

```php
$line = readline("请输入命令："); // 读取命令行交互信息
echo $line, PHP_EOL; // aaa
```

运行 PHP 代码后，我们就进入了命令提示符等待状态，并且会提示“请输入命令：”，当我们输入了 aaa 并回车之后，输入的内容就保存到了 $line 变量中。

### 命令历史列表相关操作

Readline 很强大的一个功能就是它自带一套命令历史记录的功能。不过这个需要我们自己手动地将命令加入到命令历史中。

```php
$line = readline("请输入命令："); // 读取命令行交互信息
if (!empty($line)) {
    readline_add_history($line); // 需要手动加入到命令历史记录中
}
echo $line, PHP_EOL; // aaa

$line = readline("请输入命令：");
if (!empty($line)) {
    readline_add_history($line);
}

// 命令历史记录列表
print_r(readline_list_history());
// Array
// (
//     [0] => aaa
//     [1] => bbb
// )
```

使用 readline_add_history() 函数，就可以将一条命令加入到命令历史记录中，然后使用 readline_list_history() 就能够打印出我们之前在交互式环境中发送过的命令记录。当然，如果只是这样简单的保存再打印那就没意思了，它还能将这些历史信息保存到外部文件进行存储。

```php
// 将命令历史记录写入到一个文件中
readline_write_history('./readline_history');
// ./readline_history中
// _HiStOrY_V2_
// aaa
// bbb

// 清理命令历史记录
readline_clear_history();
print_r(readline_list_history());
// Array
// (
// )

// 从文件中读取命令历史记录
readline_read_history('./readline_history');
print_r(readline_list_history());
// Array
// (
//     [0] => bbb
//     [1] => bbb
// )
```

我们使用 readline_write_history() 函数将当前的命令历史记录保存到一个文件中，然后使用 readline_clear_history() 清理掉目前命令历史记录列表中的内容，这个时候打印 readline_list_history() 的话里面已经没有任何东西了。接着，我们再使用 readline_read_history() 将命令的历史记录从文件中加载回来进行还原。这一套功能是不是就非常有意思了，我们可以记录客户的所有命令操作，不管是安全审查还是事件回放，都非常有用。

### 查看 Readline 状态

```php
// 当前命令行内部的变量信息
print_r(readline_info());
// Array
// (
//     [line_buffer] => bbb
//     [point] => 3
//     [end] => 3
//     [mark] => 0
//     [done] => 1
//     [pending_input] => 0
//     [prompt] => 请输入命令：
//     [terminal_name] => xterm-256color
//     [completion_append_character] =>
//     [completion_suppress_append] =>
//     [library_version] => 7.0
//     [readline_name] => other
//     [attempted_completion_over] => 0
// )
```

readline_info() 函数就比较简单了，我们可以看到最后一条交互式命令的信息，里面包括了命令输入的内容 line_buffer ，内容长度 point ，提示信息 prompt 等内容。

### 命令提示效果

在 Linux 等操作系统上，我们想不起一个命令的全拼没关系，只需要记住它的前几个字符然后按两个 Tab 键就可以得到相关的命令提示了。Readline 扩展库当然也为我们准备了这样的功能。

```php
// 类似于命令行中按 Tab 键的提示效果
readline_completion_function(function ($input, $index) {
    $commands = ['next', 'exit', 'quit'];
    $matches = [];
    if ($input) {
        // 如果关键字包含在命令中，提示命令信息
        foreach ($commands as $c) {
            if (strpos($c, $input) !== false) {
                $matches[] = $c;
            }
        }
    }else{
        $matches = $commands;
    }
    return $matches;
});

// 使用 Tab 键测试一下吧
$line = trim(readline("请输入命令："));
if (!empty($line)) {
    readline_add_history($line);
}
echo $line, PHP_EOL; // 当前输入的命令信息
// 如果命令是 exit 或者 quit ，就退出程序执行
if($line == 'exit' || $line == 'quit'){
    exit;
}
```

readline_completion_function() 函数会接收一个回调函数，当在交互式命令行模式下，也就是 readline 函数调用时，按下 Tab 键的时候，就会进入到这个函数的回调函数中。$input 是当前已经输入内容的值，$index 是第几个字符了。我们在这个回调函数中定义了几个默认的命令，当你键入一个 n 时直接按 Tab 键，程序就是提示出完整的 next 命令出来。当然，多个相同的字母开头的都是可以通过这个 $matches 数组返回呈现的。

这段代码中，如果我们输入了 exit 或者 quit 。将退出程序的运行。

## 字符回调操作相关示例

最后几个函数我们将通过一个复杂的小测试来学习。

```php
// 输出的内容进入这个回调函数中
function rl_callback($ret)
{
    global $c, $prompting;

    echo "您输入的内容是: $ret\n";
    $c++;

    readline_add_history($ret);

    // 限制了就调用10次，也可以通过命令行输入的内容来判断，比如上面的 exit 那种进行退出
    if ($c > 10) {
        $prompting = false;
        // 移除上一个安装的回调函数句柄并且恢复终端设置
        readline_callback_handler_remove();
    } else {
        // 继续进行递归回调
        readline_callback_handler_install("[$c] 输入点什么内容: ", 'rl_callback');

    }
}

$c = 1;
$prompting = true;

// 初始化一个 readline 回调接口，然后终端输出提示信息并立即返回，需要等待 readline_callback_read_char() 函数调用后才会进入到回调函数中
readline_callback_handler_install("[$c] 输入点什么内容: ", 'rl_callback');

// 当 $prompting 为 ture 时，一直等待输入信息
while ($prompting) {
    $w = null;
    $e = null;
    $r = array(STDIN);
    $n = stream_select($r, $w, $e, null);
    if ($n && in_array(STDIN, $r)) {
        // 当一个行被接收时读取一个字符并且通知 readline 调用回调函数
        readline_callback_read_char();
    }
}

echo "结束，完成所有输入！\n";
// [1] 输入点什么内容: A
// 您输入的内容是: A
// [2] 输入点什么内容: B
// 您输入的内容是: B
// [3] 输入点什么内容: C
// 您输入的内容是: C
// [4] 输入点什么内容: D
// 您输入的内容是: D
// [5] 输入点什么内容: E
// 您输入的内容是: E
// [6] 输入点什么内容: F
// 您输入的内容是: F
// [7] 输入点什么内容: G
// 您输入的内容是: G
// [8] 输入点什么内容: H
// 您输入的内容是: H
// [9] 输入点什么内容: I
// 您输入的内容是: I
// [10] 输入点什么内容: J
// 您输入的内容是: J
// 结束，完成所有输入！

print_r(readline_list_history());
// Array
// (
//     [0] => A
//     [1] => B
//     [2] => C
//     [3] => D
//     [4] => E
//     [5] => F
//     [6] => G
//     [7] => H
//     [8] => I
//     [9] => J
// )
```

首先，我们先不客上面的这个自定义的函数，直接向下看到 readline_callback_read_char() 。它的作用是当一个行被接收时读取一个字符并且通知 readline 调用回调函数。也就是当一行输入完成后，键入了回车之后，这个函数将通知 Readline 组件去调用 readline_callback_handler_install() 注册的回调函数。

readline_callback_handler_install() 函数的功能是初始化一个 readline 回调接口，然后终端输出提示信息并立即返回，如果在回调函数中不进行什么操作的话，这个函数就只是输出一个提示就结束了。在我们例子中的这个回调函数 rl_callback() 中，我们根据当前接收命令的次数，判断如果接收的命令在十次内，则继续接收命令直到十次命令为止就调用 readline_callback_handler_remove() 移除上一个 readline_callback_handler_install() 安装的回调并恢复终端的默认设置。

最后执行的结果就是注释中的内容，大家也可以自己复制下代码后运行调试，只有自己进行过的调试才能理解的更加深入。

## 总结

Readline 很强大，而且也是 PHP 默认安装包中自带的扩展。一般被加入默认的扩展都是经过时间检验而且非常有用的扩展，大家可以根据这些内容再进行更加深入的学习并运用到实战中。

测试代码：

[]()

参考文档：

[https://www.php.net/manual/zh/book.readline.php](https://www.php.net/manual/zh/book.readline.php)
[https://www.php.cn/php-weizijiaocheng-339883.html](https://www.php.cn/php-weizijiaocheng-339883.html)
