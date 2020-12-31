<?php

$imgPath = '../img/4.gif';
$imagick = new \Imagick($imgPath);
$imagick = $imagick->coalesceImages();
$imageCount = $imagick->count();
echo 'image count：', $imageCount, PHP_EOL; // image count：51

$imgAttrs = [
    'width'       => $imagick->getImageWidth(),
    'height'      => $imagick->getImageHeight(),
    'frame_count' => $imageCount,
];
$column = 5;
if ($imageCount < $column) {
    $column = $imageCount;
}

$row = ceil($imageCount / $column);

$spImgWidth = $imgAttrs['width'] * $column;
$spImgHeight = $imgAttrs['height'] * $row;

 // 创建图片
$spImg = new \Imagick();
$spImg->setSize($spImgWidth, $spImgHeight);
$spImg->newImage($spImgWidth, $spImgHeight, new \ImagickPixel('#ffffff00'));
$spImg->setImageFormat('png');

$i = 0;
$h = 0;
$cursor = 0;
do {
    if ($i == $column) {
        $i = 0;
        $h++;
    }
    if($cursor == 0){ // 保存第一帧图片
        $imagick->writeImage($imgPath . '.first.png');
    }
    // 保存全部的图片帧到一张 png 图片中
    $spImg->compositeImage($imagick, \Imagick::COMPOSITE_DEFAULT, $i * $imgAttrs['width'], $h * $imgAttrs['height']);
    $i++;
    $cursor++;
} while ($imagick->nextImage());
$spImg->writeImage($imgPath . '.png');


$gifImagek = new Imagick();
$gifImagek->setFormat('GIF');

for($i=1;$i<=5;$i++){
    $img = new Imagick('../img/3'.$i.'.jpeg');
    $img->setImageDelay(100);
    $gifImagek->addImage($img);
}

$gifImagek->writeImages("../img/5.gif", true);
$gifImagek->writeImages("../img/52.gif", false);



