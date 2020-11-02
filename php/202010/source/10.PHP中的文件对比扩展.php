<?php

$old_article = "我本无为野客，飘飘浪迹人间。
一时被命住名山。未免随机应变。
识破尘劳扰扰，何如乐取清闲。
流霞细酌咏诗篇。且与白云为伴。";
$new_article = "我本无为野客，飘飘浪迹人间。
一时被命住名山。未免随机应变。
识破尘劳扰扰，何如乐取清闲。一
流霞细酌咏诗篇。且与白云为伴。";
$new_article1 = "我本无为野客，飘飘浪迹人间。
一时被命住名山。未免随机应变。二
识破尘劳扰扰，何如乐取清闲。
流霞细酌咏诗篇。且与白云为伴。
三一四一";

file_put_contents('old_file.txt', $old_article);
file_put_contents('new_file.txt', $new_article);
file_put_contents('new_file1.txt', $new_article1);

echo "String Diff: ", PHP_EOL;
$diff = xdiff_string_diff($old_article, $new_article);
var_dump($diff);
// string(273) "@@ -1,4 +1,4 @@
//  我本无为野客，飘飘浪迹人间。
//  一时被命住名山。未免随机应变。
// -识破尘劳扰扰，何如乐取清闲。
// +识破尘劳扰扰，何如乐取清闲。一
//  流霞细酌咏诗篇。且与白云为伴。
// \ No newline at end of file
// "

echo "String Merge: ", PHP_EOL;
var_dump(xdiff_string_merge3($old_article, $new_article, $new_article1, $error));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"
var_dump($error); // NULL


echo "String Patch: ", PHP_EOL;
var_dump(xdiff_string_patch($old_article, $diff, XDIFF_PATCH_NORMAL, $errors));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"
var_dump($errors); // NULL

echo "String Binary Diff: ", PHP_EOL;
$patchBinary = xdiff_string_bdiff($old_article, $new_article);
var_dump($patchBinary);
// string(44) "�{�N��一
//     流霞细酌�!"

var_dump(xdiff_string_bdiff_size($patchBinary)); // int(180)
var_dump(xdiff_string_bpatch($old_article, $patchBinary));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"

echo "String RA Binary Diff: ", PHP_EOL;
$raPatchBinary = xdiff_string_rabdiff($old_article, $new_article1);
var_dump($raPatchBinary);
// string(46) "�{�N�X二XY
//     三一四一"

var_dump(xdiff_string_bdiff_size($raPatchBinary)); // int(193)
var_dump(xdiff_string_bpatch($old_article, $raPatchBinary));
// string(193) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。二
// 识破尘劳扰扰，何如乐取清闲。
// 流霞细酌咏诗篇。且与白云为伴。
// 三一四一"

echo '=================', PHP_EOL;

$old_file = 'old_file.txt';
$new_file = 'new_file.txt';
$new_file1 = 'new_file1.txt';
$diff_file = 'file.diff';
$merge_file = 'merge.txt';
$patch_file = 'patch.diff';

echo "File Diff: ", PHP_EOL;
$patch = xdiff_file_diff($old_file, $new_file, $diff_file);
var_dump($patch); // bool(true)
var_dump(file_get_contents($diff_file));
// string(273) "@@ -1,4 +1,4 @@
//  我本无为野客，飘飘浪迹人间。
//  一时被命住名山。未免随机应变。
// -识破尘劳扰扰，何如乐取清闲。
// +识破尘劳扰扰，何如乐取清闲。一
//  流霞细酌咏诗篇。且与白云为伴。
// \ No newline at end of file
// "

echo 'File Merge: ', PHP_EOL;
var_dump(xdiff_file_merge3($old_file, $new_file,  $new_file1, $merge_file));
// string(307) "@@ -1,4 +1,5 @@
//  我本无为野客，飘飘浪迹人间。
// -一时被命住名山。未免随机应变。
// +一时被命住名山。未免随机应变。二
//  识破尘劳扰扰，何如乐取清闲。
// -流霞细酌咏诗篇。且与白云为伴。+流霞细酌咏诗篇。且与白云为伴。
// +三一四一"
var_dump(file_get_contents($merge_file));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"

echo "File Patch: ", PHP_EOL;
var_dump(xdiff_file_patch($old_file, $diff_file, $patch_file, XDIFF_PATCH_NORMAL)); // bool(true)
var_dump(file_get_contents($patch_file));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"

echo "File Binary Diff: ", PHP_EOL;
$patchBinary = xdiff_file_bdiff($old_file, $new_file, $diff_file);
var_dump($patchBinary); // bool(true)
var_dump(file_get_contents($diff_file));
// string(44) "�{�N��一
//     流霞细酌�!"

var_dump(xdiff_file_bdiff_size($diff_file)); // int(180)
var_dump(xdiff_file_bpatch($old_file,$patchBinary, $patch_file)); // bool(false)
var_dump(file_get_contents($patch_file));
// string(180) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。
// 识破尘劳扰扰，何如乐取清闲。一
// 流霞细酌咏诗篇。且与白云为伴。"

echo "File RA Binary Diff: ", PHP_EOL;
$raPatchBinary = xdiff_file_rabdiff($old_file, $new_file1, $diff_file);
var_dump($raPatchBinary); // bool(true)
var_dump(file_get_contents($diff_file));
// string(46) "�{�N�X二XY
// 三一四一"

var_dump(xdiff_file_bdiff_size($diff_file)); // int(193)
var_dump(xdiff_file_bpatch($old_file, $raPatchBinary, $patch_file)); // bool(false)
var_dump(file_get_contents($patch_file));
// string(193) "我本无为野客，飘飘浪迹人间。
// 一时被命住名山。未免随机应变。二
// 识破尘劳扰扰，何如乐取清闲。
// 流霞细酌咏诗篇。且与白云为伴。
// 三一四一"