<?php

// 普通的文件读取
$fileName= './2020-02-23.sql';

// file_get_contents
$fileInfo = file_get_contents($fileName);
// Fatal error: Allowed memory size of 134217728 bytes exhausted

// file
$fileInfo = file($fileName);
// Fatal error: Allowed memory size of 134217728 bytes exhausted

// fopen + fread
$fileHandle = fopen($fileName, 'r');
$fileInfo = fread($fileHandle, filesize($fileName));
// Fatal error: Allowed memory size of 134217728 bytes exhausted

// readfile 只能直接输出
// echo readfile($fileName);

// fopen + fgetc 如果单
// $fileHandle = fopen($fileName, 'r');
// 输出单字符直到 end-of-file
// while(!feof($fileHandle)) {
//     echo fgetc($fileHandle);
// }
// fclose($fileHandle);

// SplFileObject
// $fileObject = new SplFileObject($fileName, 'r');
// while(!$fileObject->eof()){
//     echo $fileObject->fgetc();
// }



