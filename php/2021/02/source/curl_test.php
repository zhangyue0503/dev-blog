<?php

$post = $_POST['a'];
echo "测试数据", PHP_EOL;
echo $post, PHP_EOL;

if($_FILES){
    print_r($_FILES);
}
