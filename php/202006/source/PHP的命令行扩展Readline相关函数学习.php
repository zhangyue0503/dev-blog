<?php

# yum install -y readline-devel
# ./congiure xxxx --with-readline

$line = readline("请输入命令："); // 读取命令行交互信息
if (!empty($line)) {
    readline_add_history($line); // 需要手动加入到命令历史记录中
}
echo $line, PHP_EOL; // aaa

$line = readline("请输入命令：");
if (!empty($line)) {
    readline_add_history($line);
}

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

// 命令历史记录列表
print_r(readline_list_history());
// Array
// (
//     [0] => aaa
//     [1] => bbb
// )

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


readline_clear_history();
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