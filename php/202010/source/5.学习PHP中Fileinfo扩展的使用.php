<?php

$finfo = new finfo(FILEINFO_MIME);

echo $finfo->file("./1.PHP中的日期相关函数（三）.php"), PHP_EOL;
// text/x-php; charset=us-ascii


echo $finfo->buffer(file_get_contents("https://www.baidu.com")) . "\n";
// text/html; charset=utf-8


$finfo->set_flags(FILEINFO_EXTENSION);
echo $finfo->file('timg.jpeg') . "\n";
// jpeg/jpg/jpe/jfif


$finfo = finfo_open(FILEINFO_MIME);
echo finfo_file($finfo,"./1.PHP中的日期相关函数（三）.php"), PHP_EOL;
// text/x-php; charset=us-ascii

echo finfo_buffer($finfo, file_get_contents("https://www.baidu.com")), PHP_EOL;
// text/html; charset=utf-8

finfo_set_flags($finfo, FILEINFO_EXTENSION);
echo finfo_file($finfo, 'timg.jpeg') . "\n";
// jpeg/jpg/jpe/jfif

finfo_close($finfo);


echo mime_content_type('./1.PHP中的日期相关函数（三）.php'), PHP_EOL;
// text/x-php

echo mime_content_type('./timg.jpeg'), PHP_EOL;
// image/jpeg

$image = exif_imagetype("./timg.jpeg"); 
echo image_type_to_mime_type($image), PHP_EOL;
// image/jpeg