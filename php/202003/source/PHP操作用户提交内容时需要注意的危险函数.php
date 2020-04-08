<?php

$g = $_GET['g'];

// http://localhost:8088/?g=/etc/passwd
include($g); // requeire等

// http://localhost:8088/?g=ls -la /
echo system($g); // exec等等

// 删除任意文件
// http://localhost:8088/?g=../../../xxxxx
unlink('./' . $g);
