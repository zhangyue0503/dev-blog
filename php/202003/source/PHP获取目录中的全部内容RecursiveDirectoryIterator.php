<?php

$path = $argv[1];

// 获取目录下所有内容
$dirs = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);

foreach($dirs as $k=>$d){
    echo 'key:'. $k, PHP_EOL;
    if($d->isDir()){
        echo $d->getPathname(), PHP_EOL;
    }else{
        echo $d->getFilename(), PHP_EOL;
    }
}
echo '=================', PHP_EOL;

// 获取所有php文件
$regIts = new RegexIterator($dirs, '/^.+\.php$/i');
$fileSize = 0;
foreach($regIts as $k=>$p){
    echo $p->getSize() . ' ' .  $k, PHP_EOL;
    $fileSize += $p->getSize();
}
echo 'Total ', $fileSize, PHP_EOL;