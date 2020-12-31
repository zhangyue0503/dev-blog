<?php

$imgPath = '../img/2.jpg';

$im = imagecreatefromjpeg($imgPath);

if ($_GET['img'] == -1) {
    header("Content-type: image/jpg");
    imagejpeg($im);
    imagedestroy($im);
}

if ($_GET['img'] == 1) {

    $w = imagesx($im);
    $h = imagesy($im);

    $imNew = imagecreatetruecolor($w / 2, $h / 2);

    imagecopyresized($imNew, $im, 0, 0, 0, 0, $w / 2, $h / 2, $w, $h);

    header("Content-type: image/jpg");
    imagejpeg($imNew);
    imagedestroy($imNew);
}

if ($_GET['img'] == 2) {
    $w = imagesx($im);
    $h = imagesy($im);

    $imNew = imagecreatetruecolor($w / 2, $h / 2);

    imagecopyresized($imNew, $im, 0, 0, 0, 0, $w / 2, $h / 2, $w, $h);

    header("Content-type: image/jpg");
    imagejpeg($imNew, null, 10);
    imagedestroy($imNew);
}

if ($_GET['img'] == 3) {
    $w = imagesx($im);
    $h = imagesy($im);

    $imNew = imagecreatetruecolor(202, 152);
    imagefill($imNew, 0, 0, imagecolorallocate($imNew, 255, 255, 255));
    imagerectangle($imNew, 0, 0, 201, 151, imagecolorallocate($imNew, 0, 0, 0));

    $sW = 0;
    $sH = 0;
    if ($w / $h > 200 / 150) {
        $q = 200 / $w;
        $sH = $h * $q;
        $sW = $w * $q;
        $sX = 0;
        $sY = (150 - $sH) / 2;
    } else {
        $q = 150 / $h;
        $sH = $h * $q;
        $sW = $w * $q;
        $sX = (200 - $sW) / 2;
        $sY = 0;
    }

    imagecopyresized($imNew, $im, $sX + 2, $sY + 1, 0, 0, $sW, $sH, $w, $h);

    header("Content-type: image/jpg");
    imagejpeg($imNew);
    imagedestroy($imNew);
}

if ($_GET['img'] == 4) {
    $imNew = imagecreatetruecolor(150, 30);

    imagecolortransparent($imNew, imagecolorallocatealpha($imNew, 255, 255, 255, 128));
    imagesavealpha($imNew, true);

    $font = '../font/msyh.ttf';
    imagettftext($imNew, 16, 0, 11, 21, imagecolorallocate($imNew, 255, 255, 255), $font, '硬核项目经理');
    
    if (imagesx($im) > 150 + 10 && imagesy($im) > 60 + 10) {
        imagecopy($im, $imNew, imagesx($im) - 150 - 10, imagesy($im) - 30 - 10, 0, 0, 150, 30);

        imagecopymerge($im, $imNew, imagesx($im) - 150 - 10, imagesy($im) - 60 - 10, 0, 0, 150, 30, 50);
    }

    header("Content-type: image/jpg");
    imagejpeg($im);
    imagedestroy($im);
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
    <img src="?img=-1"/><br/><br/>
    <img src="?img=1" /><br/><br/>
    <img src="?img=2" /><br/><br/>
    <img src="?img=3"/><br/><br/>
    <img src="?img=4"/><br/><br/>
</body>
</html>
