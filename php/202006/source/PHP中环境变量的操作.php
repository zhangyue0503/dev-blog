<?php

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


echo getenv("HOME"), PHP_EOL;
// /Users/zhangyue

// Nginx
print_r($_SERVER);
echo getenv("REQUEST_METHOD"), PHP_EOL; // GET
echo getenv("REQUEST_METHOD", true), PHP_EOL; // 

putenv("A=TestA");
echo getenv("A"), PHP_EOL;
echo getenv("A", true), PHP_EOL;

// phpinfo();