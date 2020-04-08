<?php

print_r($_FILES);

// Array
// (
//     [myfile] => Array
//         (
//             [name] => Array
//                 (
//                     [0] => 2591d8b3eee018a0a84f671933ab6c74.png
//                     [a] => Array
//                         (
//                             [0] => 12711584942474_.pic_hd 1.jpg
//                             [b] => Array
//                                 (
//                                     [0] => 12721584942474_.pic_hd 1.jpg
//                                 )

//                         )

//                     [c] => Array
//                         (
//                             [0] => 12731584942474_.pic_hd.jpg
//                         )

//                     [1] => background1.jpg
//                     [2] => Array
//                         (
//                             [0] => adliu_pip_data.xlsx
//                         )

//                 )

//             [type] => Array
//                 (
//                     [0] => image/png
//                     [a] => Array
//                         (
//                             [0] => image/jpeg
//                             [b] => Array
//                                 (
//                                     [0] => image/jpeg
//                                 )

//                         )

//                     [c] => Array
//                         (
//                             [0] => image/jpeg
//                         )

//                     [1] => image/jpeg
//                     [2] => Array
//                         (
//                             [0] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//                         )

//                 )

//             [tmp_name] => Array
//                 (
//                     [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phphD88ZY
//                     [a] => Array
//                         (
//                             [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpNY8MzY
//                             [b] => Array
//                                 (
//                                     [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php3MX5tk
//                                 )

//                         )

//                     [c] => Array
//                         (
//                             [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpjgrHMj
//                         )

//                     [1] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phppXRtnc
//                     [2] => Array
//                         (
//                             [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpekSY1M
//                         )

//                 )

//             [error] => Array
//                 (
//                     [0] => 0
//                     [a] => Array
//                         (
//                             [0] => 0
//                             [b] => Array
//                                 (
//                                     [0] => 0
//                                 )

//                         )

//                     [c] => Array
//                         (
//                             [0] => 0
//                         )

//                     [1] => 0
//                     [2] => Array
//                         (
//                             [0] => 0
//                         )

//                 )

//             [size] => Array
//                 (
//                     [0] => 4973
//                     [a] => Array
//                         (
//                             [0] => 3007
//                             [b] => Array
//                                 (
//                                     [0] => 1156
//                                 )

//                         )

//                     [c] => Array
//                         (
//                             [0] => 6068
//                         )

//                     [1] => 393194
//                     [2] => Array
//                         (
//                             [0] => 36714
//                         )

//                 )

//         )

//     [newfile] => Array
//         (
//             [name] => Array
//                 (
//                     [0] => Array
//                         (
//                             [0] => 数据列表 (2).xlsx
//                         )

//                     [s] => background1.jpg
//                 )

//             [type] => Array
//                 (
//                     [0] => Array
//                         (
//                             [0] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//                         )

//                     [s] => image/jpeg
//                 )

//             [tmp_name] => Array
//                 (
//                     [0] => Array
//                         (
//                             [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phplSsRfM
//                         )

//                     [s] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpuQAvRb
//                 )

//             [error] => Array
//                 (
//                     [0] => Array
//                         (
//                             [0] => 0
//                         )

//                     [s] => 0
//                 )

//             [size] => Array
//                 (
//                     [0] => Array
//                         (
//                             [0] => 77032
//                         )

//                     [s] => 393194
//                 )

//         )

//     [singlefile] => Array
//         (
//             [name] => timg (8).jpeg
//             [type] => image/jpeg
//             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpxtSQ4J
//             [error] => 0
//             [size] => 10273
//         )

// )

$files = [];
// 开始数据格式化
foreach ($_FILES as $uploadKey => $uploadFiles) {
    // 需要将 $_FILES 中的五个字段都拿出来
    $files[$uploadKey] = formatUploadFiles($uploadFiles['name'], $uploadFiles['type'], $uploadFiles['tmp_name'], $uploadFiles['error'], $uploadFiles['size']);
}

// 格式化上传文件数组
function formatUploadFiles($fileNamesArray, $type, $tmp_name, $error, $size)
{
    $tmpFiles = [];
    // 文件名是否是数组，如果不是数组，就是单个文件上传
    if (is_array($fileNamesArray)) {
        // 数组形式上传
        foreach ($fileNamesArray as $idx => $fileName) {
            // 如果还是嵌套的数组，递归遍历接下来的内容
            if (is_array($fileName)) {
                $tmpFiles[$idx] = formatUploadFiles($fileName, $type[$idx] ?? [], $tmp_name[$idx] ?? [], $error[$idx] ?? [], $size[$idx] ?? []);
            } else {
                // 组合多维的格式化内容
                $tmpFiles[$idx] = [
                    'name' => $fileName,
                    'type' => $type[$idx] ?? '',
                    'tmp_name' => $tmp_name[$idx] ?? '',
                    'error' => $error[$idx] ?? '',
                    'size' => $size[$idx] ?? '',
                ];
            }
        }
    } else {
        // 组合单个的内容
        $tmpFiles = [
            'name' => $fileName,
            'type' => $type ?? '',
            'tmp_name' => $tmp_name ?? '',
            'error' => $error ?? '',
            'size' => $size ?? '',
        ];
    }

    return $tmpFiles;
}

print_r($files);

// Array
// (
//     [myfile] => Array
//         (
//             [0] => Array
//                 (
//                     [name] => 2591d8b3eee018a0a84f671933ab6c74.png
//                     [type] => image/png
//                     [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpV7A2yC
//                     [error] => 0
//                     [size] => 4973
//                 )

//             [a] => Array
//                 (
//                     [0] => Array
//                         (
//                             [name] => 12711584942474_.pic_hd 1.jpg
//                             [type] => image/jpeg
//                             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php5q2d1Z
//                             [error] => 0
//                             [size] => 3007
//                         )

//                     [b] => Array
//                         (
//                             [0] => Array
//                                 (
//                                     [name] => 12721584942474_.pic_hd 1.jpg
//                                     [type] => image/jpeg
//                                     [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpdvv8No
//                                     [error] => 0
//                                     [size] => 1156
//                                 )

//                         )

//                 )

//             [c] => Array
//                 (
//                     [0] => Array
//                         (
//                             [name] => 12731584942474_.pic_hd.jpg
//                             [type] => image/jpeg
//                             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php9tfGmp
//                             [error] => 0
//                             [size] => 6068
//                         )

//                 )

//             [1] => Array
//                 (
//                     [name] => background1.jpg
//                     [type] => image/jpeg
//                     [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phplUVpzA
//                     [error] => 0
//                     [size] => 393194
//                 )

//             [2] => Array
//                 (
//                     [0] => Array
//                         (
//                             [name] => adliu_pip_data.xlsx
//                             [type] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//                             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpNRtiaC
//                             [error] => 0
//                             [size] => 36714
//                         )

//                 )

//         )

//     [newfile] => Array
//         (
//             [0] => Array
//                 (
//                     [0] => Array
//                         (
//                             [name] => 数据列表 (2).xlsx
//                             [type] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//                             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpBLG7aG
//                             [error] => 0
//                             [size] => 77032
//                         )

//                 )

//             [s] => Array
//                 (
//                     [name] => background1.jpg
//                     [type] => image/jpeg
//                     [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpjyqCFY
//                     [error] => 0
//                     [size] => 393194
//                 )

//         )

//     [singlefile] => Array
//         (
//             [name] =>
//             [type] => image/jpeg
//             [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpuYJXiE
//             [error] => 0
//             [size] => 10273
//         )

// )

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" enctype="multipart/form-data" method="post">

    myfile1：<input type="file" name="myfile[]"/><br/>
    myfile2：<input type="file" name="myfile[a][]"/><br/>
    myfile3：<input type="file" name="myfile[a][b][]"/><br/>
    myfile4：<input type="file" name="myfile[c][]"/><br/>
    myfile5：<input type="file" name="myfile[]"/><br/>
    myfile6：<input type="file" name="myfile[][]"/><br/>
    <br/>
    newfile1：<input type="file" name="newfile[][]"/><br/>
    newfile2：<input type="file" name="newfile[s]"/><br/>

    singlefile: <input type="file" name="singlefile"/><br/>
        <input type="submit" value="submit"/>
    </form>
</body>
</html>
