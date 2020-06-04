# PHP中环境变量的操作

在 PHP 中，我们可以通过 phpinfo() 查看到当前系统中的环境变量信息（Environment）。在代码中，我们也可以通过两个函数，查看和修改相应的环境变量信息。

## getenv() 获取环境变量信息

在不传参数的情况下，我们可以通过 getenv() 这个函数获得所有的环境变量信息。不过需要注意的是，在 CLI 环境和 SAPI 环境下它所返回的信息是不一样的。

```php
print_r(getenv());

// CLI
// Array
// (
//     [USER] => zhangyue
//     [PATH] => /usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Applications/VMware Fusion.app/Contents/Public:/Applications/Wireshark.app/Contents/MacOS
//     [LOGNAME] => zhangyue
//     [SSH_AUTH_SOCK] => /private/tmp/com.apple.launchd.h3szqpYfSH/Listeners
//     [HOME] => /Users/zhangyue
//     [SHELL] => /bin/zsh
//     [__CF_USER_TEXT_ENCODING] => 0x1F5:0x19:0x34
//     [TMPDIR] => /var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/
//     [XPC_SERVICE_NAME] => 0
//     [XPC_FLAGS] => 0x0
//     [OLDPWD] => /Users/zhangyue/MyDoc/博客文章
//     [PWD] => /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source
//     [SHLVL] => 1
//     [TERM_PROGRAM] => vscode
//     [TERM_PROGRAM_VERSION] => 1.45.1
//     [LANG] => en_US.UTF-8
//     [COLORTERM] => truecolor
//     [VSCODE_GIT_IPC_HANDLE] => /var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/vscode-git-a282fa5813.sock
//     [GIT_ASKPASS] => /Applications/Visual Studio Code.app/Contents/Resources/app/extensions/git/dist/askpass.sh
//     [VSCODE_GIT_ASKPASS_NODE] => /Applications/Visual Studio Code.app/Contents/Frameworks/Code Helper (Renderer).app/Contents/MacOS/Code Helper (Renderer)
//     [VSCODE_GIT_ASKPASS_MAIN] => /Applications/Visual Studio Code.app/Contents/Resources/app/extensions/git/dist/askpass-main.js
//     [TERM] => xterm-256color
//     [_] => /usr/local/bin/php
//     [__KMP_REGISTERED_LIB_9282] => 0x1138dc0f8-cafece1d-libomp.dylib
// )

// SAPI Nginx
// Array
// (
//     [USER] => zhangyue
//     [HOME] => /Users/zhangyue
// )
```

如果 PHP 在诸如 Fast CGI 之类的 SAPI 中运行，则此函数将始终返回由 SAPI 设置的环境变量的值，即使已使用 putenv() 来设置同名的本地环境变量。这个函数是有两个参数的，不过它们都是选填的（PHP7以前必须填变量名）。第一个参数是变量名，也就是可以返回具体的某一个环境变量信息。而第二个参数如果设置为 true 的话，仅返回本地环境变量（由操作系统或 putenv() 设置）。


```php
echo getenv("HOME"), PHP_EOL;
// /Users/zhangyue

// Nginx
print_r($_SERVER);
echo getenv("REQUEST_METHOD"), PHP_EOL; // GET
echo getenv("REQUEST_METHOD", true), PHP_EOL; // 
```

在第二个参数不为 true 的情况下，我们可以通过 getenv() 获得 $_SERVER 、$_ENV 中的所有内容，但是，如果第二个参数为 true 的话，那么类似于 Nginx 为我们添加的那些环境变量就无法获取了。这就是第二个参数的作用，上面代码中 REQUEST_METHOD 就是 Nginx 为我们添加的环境变量，所以第二条输出语句就不会进行输出。

## putenv() 设置环境变量信息

设置环境变量的函数就比较简单了，只有一个参数，不过写法是类似于 Linux 中环境变量的设置写法。

```php
putenv("A=TestA");
echo getenv("A"), PHP_EOL;
echo getenv("A", true), PHP_EOL;
```

对于 putenv() 的环境变量，getenv() 的第二个参数设置为 true 也是可以获取到的。环境变量仅存活于当前请求期间。 在请求结束时环境会恢复到初始状态。

设置特定的环境变量也有可能是一个潜在的安全漏洞。 safe_mode_allowed_env_vars 包含了一个以逗号分隔的前缀列表。 在安全模式下，用户可以仅能修改用该指令设定的前缀名称的指令。 默认情况下，用户仅能够修改以 PHP_ 开头的环境变量（例如 PHP_FOO=BAR）。 注意：如果此指令是空的，PHP允许用户设定任意环境变量！

safe_mode_protected_env_vars 指令包含了逗号分隔的环境变量列表，使用户最终无法通过 putenv() 修改。 即使 safe_mode_allowed_env_vars 设置允许修改，这些变量也会被保护。

所以，在 php.ini 中，默认情况下 putenv() 是定义为危险函数的，也就是在 disable_functions 中需要删除掉这个函数才能正常使用，如果要使用 Composer 的话也必须要开启这个函数才能正常使用。

测试代码：


参考文档：
[https://www.php.net/manual/zh/function.putenv.php](https://www.php.net/manual/zh/function.putenv.php)
[https://www.php.net/manual/zh/function.getenv.php](https://www.php.net/manual/zh/function.getenv.php)