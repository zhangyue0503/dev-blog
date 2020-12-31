<?php

var_dump(gd_info());
// array(13) {
//     ["GD Version"]=>
//     string(26) "bundled (2.1.0 compatible)"
//     ["FreeType Support"]=>
//     bool(true)
//     ["FreeType Linkage"]=>
//     string(13) "with freetype"
//     ["GIF Read Support"]=>
//     bool(true)
//     ["GIF Create Support"]=>
//     bool(true)
//     ["JPEG Support"]=>
//     bool(true)
//     ["PNG Support"]=>
//     bool(true)
//     ["WBMP Support"]=>
//     bool(true)
//     ["XPM Support"]=>
//     bool(false)
//     ["XBM Support"]=>
//     bool(true)
//     ["WebP Support"]=>
//     bool(true)
//     ["BMP Support"]=>
//     bool(true)
//     ["JIS-mapped Japanese Font Support"]=>
//     bool(false)
//   }

var_dump(getimagesize("../img/1.png"));
// array(6) {
//     [0]=>
//     int(150)
//     [1]=>
//     int(150)
//     [2]=>
//     int(3)
//     [3]=>
//     string(24) "width="150" height="150""
//     ["bits"]=>
//     int(8)
//     ["mime"]=>
//     string(9) "image/png"
//   }

var_dump(getimagesize("../img/2.jpg", $info));
// array(7) {
//     [0]=>
//     int(300)
//     [1]=>
//     int(244)
//     [2]=>
//     int(2)
//     [3]=>
//     string(24) "width="300" height="244""
//     ["bits"]=>
//     int(8)
//     ["channels"]=>
//     int(3)
//     ["mime"]=>
//     string(10) "image/jpeg"
//   }

var_dump($info);
// array(1) {
//     ["APP0"]=>
//     string(14) "JFIF��"
//   }


var_dump(getimagesize("https://upload-images.jianshu.io/upload_images/1074666-8df66a94d61cac74.png?imageMogr2/auto-orient/strip|imageView2/2/w/374/format/webp"));
// array(6) {
//     [0]=>
//     int(374)
//     [1]=>
//     int(617)
//     [2]=>
//     int(18)
//     [3]=>
//     string(24) "width="374" height="617""
//     ["bits"]=>
//     int(8)
//     ["mime"]=>
//     string(10) "image/webp"
//   }

$data = file_get_contents('../img/1.png');
var_dump(getimagesizefromstring($data));
// array(6) {
//     [0]=>
//     int(150)
//     [1]=>
//     int(150)
//     [2]=>
//     int(3)
//     [3]=>
//     string(24) "width="150" height="150""
//     ["bits"]=>
//     int(8)
//     ["mime"]=>
//     string(9) "image/png"
//   }

var_dump(image_type_to_extension(IMAGETYPE_PNG)); // string(4) ".png"
var_dump(image_type_to_extension(IMAGETYPE_JPEG, FALSE)); // string(4) "jpeg"

var_dump(image_type_to_mime_type(IMAGETYPE_PNG)); // string(9) "image/png"
var_dump(image_type_to_mime_type(IMAGETYPE_JPEG)); // string(10) "image/jpeg"

var_dump(imagetypes()); // int(111)
var_dump(imagetypes() & IMAGETYPE_PNG); // int(3)


$im = @imagecreate(100, 50) or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  "Test 测试", $text_color);
imagepng($im, '../img/test.png');
imagedestroy($im);