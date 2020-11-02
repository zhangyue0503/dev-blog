<?php

echo DIRECTORY_SEPARATOR, PHP_EOL; // /
echo PATH_SEPARATOR, PHP_EOL; // :

$directory = dir('../');

while(($dir = $directory->read())!== false){
    echo $dir, PHP_EOL;
}
// .
// ..
// 1.PHP中的日期相关函数（三）.md
// source

echo $directory->read(), PHP_EOL;
//

$directory->rewind();
while(($dir = $directory->read())!== false){
    echo $dir, PHP_EOL;
}
// .
// ..
// 1.PHP中的日期相关函数（三）.md
// source

$directory->close();
// while($dir = $directory->read()){
//     echo $dir, PHP_EOL;
// }
// Warning: Directory::read(): supplied resource is not a valid Directory resource 


// 改变PHP当前目录
echo getcwd(), PHP_EOL;
// /Users/zhangyue/MyDoc/博客文章

chdir('dev-blog/php/202010');

echo getcwd(), PHP_EOL;
// /Users/zhangyue/MyDoc/博客文章/dev-blog/php/202010

// chdir('dev-blog/php/202013'); 
// Warning: chdir(): No such file or directory (errno 2) 

chdir('/home');
echo getcwd(), PHP_EOL;
// /System/Volumes/Data/home


$dirPath = __DIR__;
if(is_dir($dirPath)){
    if ($dh = opendir($dirPath)) {
        while(($dir = readdir($dh)) !== false){ 
            echo $dir, PHP_EOL;
        }
        echo readdir($dh), PHP_EOL;
        

        rewinddir($dh);
        while(($dir = readdir($dh)) !== false){ 
            echo $dir, PHP_EOL;
        }

        closedir($dh);
    }
}
// .
// ..
// 2.学习PHP中的目录操作.php
// 1.PHP中的日期相关函数（三）.php
//
// .
// ..
// 2.学习PHP中的目录操作.php
// 1.PHP中的日期相关函数（三）.php

print_r(scandir($dirPath));
// Array
// (
//     [0] => .
//     [1] => ..
//     [2] => 1.PHP中的日期相关函数（三）.php
//     [3] => 2.学习PHP中的目录操作.php
// )

print_r(scandir('/Users'));
// Array
// (
//     [0] => .
//     [1] => ..
//     [2] => .localized
//     [3] => Guest
//     [4] => Shared
//     [5] => share
//     [6] => zhangyue
// )
