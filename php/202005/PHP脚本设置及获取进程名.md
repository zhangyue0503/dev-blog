# PHP脚本设置及获取进程名

今天来学习的是两个非常简单的函数，一个可以用来设置我们执行脚本时运行的进程名。而另一个就是简单的获取当前运行的进程名。这两个函数对于大量的脚本运行代码有很大的作用，比如我们需要 kill 掉某个进程时，可以直接使用我们自己定义的进程名来进行操作。

## 设置进程名

```php
cli_set_process_title("test");
```

非常简单吧，只有一个参数，那就是要定义的变量名称。在运行起来后，我们使用 sleep() 让程序挂载一段时间，然后再开一个终端来查看当前的进程信息。

```php
ps -ef | grep test
# root     32172 31511  0 09:03 pts/0    00:00:00 test

top -p 32172 -c
# 32198 root      20   0  113100  18052  13088 S   0.0   0.2   0:00.00 test
```

可以看到，不管是使用 ps 还是使用 top ，都可以看到相应的进程名称为 test 的进程。这样，就完成了进程名称的自定义。

## 获取进程名

```php
echo "Process title: " . cli_get_process_title() . "\n";
// Process title: test
```

同样的，获取当前进程名的函数也非常地简单，直接调用即可。它就会正常输出当前执行脚本的进程名称。

如果我们没有自定义进程名称呢？这里就不会有任何的输出，大家可以自己尝试一下。

## 注意事项

最后来说说这两个函数的注意事项。

一是如果使用的是 Mac OS 系统，会提示：

```php
// Warning: cli_set_process_title(): cli_set_process_title had an error: Not initialized correctly 
```

也就是说这两个函数在 Mac 下面是无法正常使用的，我的测试环境是 CentOS ，是可以正常使用的。Windows 环境没有进行测试，正常情况下也很少会有人在 Windows 环境下挂后台执行脚本，所以有兴趣的同学可以自己测试下。

二是进程名可以是中文！！！是不是感觉很高大上。

三是这两个函数仅针对 CLI 运行环境。也就是说，在 CGI 正常网页运行的状态下这两个函数是没有效果的。

测试代码：


参考文档：
[https://www.php.net/manual/zh/function.cli-set-process-title.php](https://www.php.net/manual/zh/function.cli-set-process-title.php)
[https://www.php.net/manual/zh/function.cli-get-process-title.php](https://www.php.net/manual/zh/function.cli-get-process-title.php)