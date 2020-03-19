<?php

// stdin
if (PHP_SAPI == 'cli') {
    while ($line = fopen('php://stdin', 'r')) {
        $info = fgets($line);
        echo $info;
        if ($info == "exit\n") {
            break;
        }
    }

    while ($info = fgets(STDIN)) {
        echo $info;
        if ($info == "exit\n") {
            break;
        }
    }
}

// std相关的不会在浏览器输出
$stdout = fopen('php://stdout', 'w');
fputs($stdout, 'fopen:stdout');
echo PHP_EOL;
file_put_contents("php://stdout", "file_put_contents:stdout");
echo PHP_EOL;

file_put_contents("php://stderr", "file_put_contents:stderr");
echo PHP_EOL;

// output
$output = fopen('php://output', 'w');
fputs($output, 'fopen:output');
echo PHP_EOL;
file_put_contents("php://output", "file_put_contents:output");
echo PHP_EOL;



// 浏览器访问的话会一直等待输入
// echo file_get_contents("php://stdin");
// 使用 php://input 获取 post body 内容
echo file_get_contents("php://input");

// memory temp
$mem = fopen('php://memory', 'r+');
for ($i = 0; $i < 10; $i++) {
    fwrite($mem, 'fopen:memory');
}
rewind($mem);
while ($info = fgets($mem)) {
    echo $info, PHP_EOL;
}
fclose($mem);

// filter
readfile("php://filter/read=string.toupper/resource=http://www.baidu.com");
echo file_get_contents("php://filter/read=convert.base64-encode/resource=http://www.baidu.com");
