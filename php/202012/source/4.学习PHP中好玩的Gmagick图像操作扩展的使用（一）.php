<?php

$image = new Gmagick('./img/2.jpg');

echo 'Copyright：', $image->getcopyright(), PHP_EOL;
// Copyright：Copyright (C) 2002-2020 GraphicsMagick Group.
// Additional copyrights and licenses apply to this software.
// See http://www.GraphicsMagick.org/www/Copyright.html for details.

echo 'Filename：', $image->getimagefilename(), PHP_EOL; // Filename：./img/2.jpg

echo 'Image Format：', $image->getimageformat(), PHP_EOL; // Image Format：JPEG

echo 'Image Width and Height：', $image->getimagewidth(), ' * ', $image->getimageheight(), PHP_EOL; // Image Width and Height：300 * 244

echo 'Image type：', $image->getimagetype(), PHP_EOL; // Image type：6

// 加边框
$image = new Gmagick('./img/2.jpg');
$image->borderimage("green", 2, 2)->oilpaintimage(0.3);
$image->write('./img/2-border.jpg');

// 缩放图像
$image = new Gmagick('./img/2.jpg');
$image->resizeimage(150, 150, 10, 1);
$image->write('./img/2-resize.jpg');

$image = new Gmagick('./img/2.jpg');
$image->scaleimage(150, 150);
$image->write('./img/2-scale.jpg');

// 缩略图
$image = new Gmagick('./img/2.jpg');
$image->thumbnailimage(100, 0);
$image->write('./img/2-thumbnail.jpg');

// 裁剪缩略图
$image = new Gmagick('./img/2.jpg');
$image->cropthumbnailimage(100,90);
$image->write('./img/2-cropthumbnaili.jpg');

// 按比例缩小一半
$image = new Gmagick('./img/2.jpg');
$image->minifyimage();
$image->write('./img/2-minify.jpg');

// 垂直翻转
$image = new Gmagick('./img/2.jpg');
$image->flipimage();
$image->write('./img/2-flip.jpg');

// 水平翻转
$image = new Gmagick('./img/2.jpg');
$image->flopimage();
$image->write('./img/2-flop.jpg');

// 旋转图像
$image = new Gmagick('./img/2.jpg');
$image->rotateimage('#ffffff', 60);
$image->write('./img/2-rotate.jpg');

// 偏移图像
$image = new Gmagick('./img/2.jpg');
$image->rollimage(150, 150);
$image->write('./img/2-roll.jpg');




// 调高度、饱和度、色调
$image = new Gmagick('./img/2.jpg');
$image->modulateimage(80, 80, 80);
$image->write('./img/2-modulate.jpg');

// 颜色对比度
$image = new Gmagick('./img/2.jpg');
$image->normalizeimage(30);
$image->write('./img/2-normalize.jpg');





// 模糊效果
$image = new Gmagick('./img/2.jpg');
$image->blurimage(30, 10);
$image->write('./img/2-blur.jpg');

// 运动模糊效果
$image = new Gmagick('./img/2.jpg');
$image->motionblurimage(30, 50, 10);
$image->write('./img/2-motionblur.jpg');

// 径向模糊效果
//$image = new Gmagick('./img/2.jpg');
//$image->radialblurimage(12.5);
//$image->write('./img/2-radialblur.jpg');



// 模拟油画效果
$image = new Gmagick('./img/2.jpg');
$image->oilpaintimage(5);
$image->write('./img/2-oilpaint.jpg');

// 创建模拟3D按扭
$image = new Gmagick('./img/2.jpg');
$image->raiseimage(50, 50, 150, 150, true);
$image->write('./img/2-raise.jpg');

// 木炭效果
$image = new Gmagick('./img/2.jpg');
$image->charcoalimage(10, 3);
$image->write('./img/2-charcoal.jpg');

// 图像应用日光效果
$image = new Gmagick('./img/2.jpg');
$image->solarizeimage(60);
$image->write('./img/2-solarize.jpg');

// 随机移动图中的像素
$image = new Gmagick('./img/2.jpg');
$image->spreadimage(10);
$image->write('./img/2-spread.jpg');

// 围绕中心旋转像素
$image = new Gmagick('./img/2.jpg');
$image->swirlimage(100);
$image->write('./img/2-swirl.jpg');

