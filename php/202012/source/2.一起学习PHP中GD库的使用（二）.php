<?php

if ($_GET['img'] == 1) {
    
    // 创建一个 200X200 的图像
    $img = imagecreatetruecolor(200, 200);
    // 分配颜色
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    $red = imagecolorallocate($img, 255, 0, 0);

    // 带透明通道的颜色
    $alphaRed = imagecolorclosestalpha($img, 255, 0, 0, 50);

    // 填充背景色
    imagefill($img, 0, 0, $black);
    // 画一个白色的圆
    imagearc($img, 100, 100, 150, 150, 0, 360, $white);

    // 画一条线段
    imageline($img, 20, 180, 120, 120, $white);

    // 填充一个带透明的矩形
    imagefilledrectangle($img, 30, 30, 70, 70, $alphaRed);

    $string = "I Like PHP!";

    // 水平写一个字符
    imagechar($img, 5, 70, 50, $string, $red);
    // 垂直写一个字符
    imagecharup($img, 3, 120, 50, $string, $red);

    // 水平写字符串
    imagestring($img, 5, 70, 150, $string, $red);
    // 垂直写字符串
    imagestringup($img, 3, 120, 150, $string, $red);

    // 用 TrueType 字体向图像写入文本
    $font = '../font/arial.ttf';
    imagettftext($img, 20, 0, 11, 21, $white, $font, $string);

    // 将图像输出到浏览器
    header("Content-type: image/png");
    imagepng($img);
    // 释放内存
    imagedestroy($img);
} else if ($_GET['img'] == 2) {
    $img = imagecreatetruecolor(120, 50);
    imagefill($img, 0, 0, imagecolorallocate($img, 255, 255, 255));

    $colors = [
        imagecolorallocate($img, 0, 0, 0),
        imagecolorallocate($img, 255, 0, 0),
        imagecolorallocate($img, 0, 255, 0),
        imagecolorallocate($img, 0, 0, 255),
    ];

    $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

    for ($i = 0; $i < 10; $i++) {
        imageline(
            $img,
            random_int(0, 120),
            random_int(0, 50),
            random_int(0, 120),
            random_int(0, 50),
            $colors[array_rand($colors)]
        );
    }
    $font = '../font/arial.ttf';
    for ($i = 0; $i < 4; $i++) {
        $char = $chars[array_rand($chars)];
        $fontSize = random_int(18, 24);
        $c = random_int(-20, 20);
        $x = $i * 26;
        if ($x == 0) {
            $x = 5;
        }
        imagettftext(
            $img, 
            $fontSize, 
            $c, 
            $x, 
            40, 
            $colors[array_rand($colors)], 
            $font, 
            $char
        );
    }
    header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="?img=1"/><br/><br/>
    <img src="?img=2" onclick="this.src='/?img=2&rand='+Math.random();return false;" style="cursor: pointer;"/>
</body>
</html>
