# PHP多文件上传格式化

文件上传是所有web应用中最常见的功能，而PHP实现这一功能也非常的简单，只需要前端设置表单的 enctype 值为 multipart/form-data 之后，我们就可以通过 $_FILES 获得表单中的 file 控件中的内容。

同时，我们还可以将 file 控件的名称写成带 [] 的数组形式，这样我们就可以接收到多个上传的文件。比如下面这个测试用的表单：

```html
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
```

一共有9个 file 控件，其中 myfile 和 newfile 都是数组类型的表单名，而 singlefile 则是一个单独的。先简单的看一下 $_FILES 所获得的内容。

```php

print_r($_FILES);

Array
(
    [myfile] => Array
        (
            [name] => Array
                (
                    [0] => 2591d8b3eee018a0a84f671933ab6c74.png
                    [a] => Array
                        (
                            [0] => 12711584942474_.pic_hd 1.jpg
                            [b] => Array
                                (
                                    [0] => 12721584942474_.pic_hd 1.jpg
                                )

                        )

                    [c] => Array
                        (
                            [0] => 12731584942474_.pic_hd.jpg
                        )

                    [1] => background1.jpg
                    [2] => Array
                        (
                            [0] => adliu_pip_data.xlsx
                        )

                )

            [type] => Array
                (
                    [0] => image/png
                    [a] => Array
                        (
                            [0] => image/jpeg
                            [b] => Array
                                (
                                    [0] => image/jpeg
                                )

                        )

                    [c] => Array
                        (
                            [0] => image/jpeg
                        )

                    [1] => image/jpeg
                    [2] => Array
                        (
                            [0] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                        )

                )

            [tmp_name] => Array
                (
                    [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phphD88ZY
                    [a] => Array
                        (
                            [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpNY8MzY
                            [b] => Array
                                (
                                    [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php3MX5tk
                                )

                        )

                    [c] => Array
                        (
                            [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpjgrHMj
                        )

                    [1] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phppXRtnc
                    [2] => Array
                        (
                            [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpekSY1M
                        )

                )

            [error] => Array
                (
                    [0] => 0
                    [a] => Array
                        (
                            [0] => 0
                            [b] => Array
                                (
                                    [0] => 0
                                )

                        )

                    [c] => Array
                        (
                            [0] => 0
                        )

                    [1] => 0
                    [2] => Array
                        (
                            [0] => 0
                        )

                )

            [size] => Array
                (
                    [0] => 4973
                    [a] => Array
                        (
                            [0] => 3007
                            [b] => Array
                                (
                                    [0] => 1156
                                )

                        )

                    [c] => Array
                        (
                            [0] => 6068
                        )

                    [1] => 393194
                    [2] => Array
                        (
                            [0] => 36714
                        )

                )

        )

    [newfile] => Array
        (
            [name] => Array
                (
                    [0] => Array
                        (
                            [0] => 数据列表 (2).xlsx
                        )

                    [s] => background1.jpg
                )

            [type] => Array
                (
                    [0] => Array
                        (
                            [0] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                        )

                    [s] => image/jpeg
                )

            [tmp_name] => Array
                (
                    [0] => Array
                        (
                            [0] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phplSsRfM
                        )

                    [s] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpuQAvRb
                )

            [error] => Array
                (
                    [0] => Array
                        (
                            [0] => 0
                        )

                    [s] => 0
                )

            [size] => Array
                (
                    [0] => Array
                        (
                            [0] => 77032
                        )

                    [s] => 393194
                )

        )

    [singlefile] => Array
        (
            [name] => timg (8).jpeg
            [type] => image/jpeg
            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpxtSQ4J
            [error] => 0
            [size] => 10273
        )

)

```

看出有什么问题了吗？

```php
$_FILE['singlefile']['name'];
$_FILE['singlefile']['type'];
$_FILE['singlefile']['tmp_name'];
$_FILE['singlefile']['error'];
$_FILE['singlefile']['error'];

$_FILE['myfile']['name']['a']['b'][0];
$_FILE['myfile']['type']['a']['b'][0];
$_FILE['myfile']['tmp_name']['a']['b'][0];
$_FILE['myfile']['error']['a']['b'][0];
$_FILE['myfile']['error']['a']['b'][0];
```

单个表单是一个 singlefile 为键名的数组，里面是对应的 name 、 type 等属性。这个非常简单也清晰明了，但是数组形式上传的内容就比较坑了，每一个属性下面都有多个值，而且这些值还有可能是嵌套的数组。就比如说我们要获得 myfile[a][b][] 的上传文件内容，我们就要通过 $_FILE['myfile']['name']['a']['b'][0] 、 $_FILE['myfile']['type']['a']['b'][0] 这样的形式获得相关的内容。这个可真的不是很友好，那么我们今天的主题就来了，我们把这种内容进行一下格式化，让他变成和 singlefile 类似的结构，也就是一个文件的相关内容都在一个键名结构下，比如 myfile[a][b][] 的内容就全部都在 $_FILE['myfile'][a][b][0]下面。

```php
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
```

代码还是非常好理解的，就是通过一段递归来遍历整个 $_FILES 目录树，相当于一个深度遍历。当然，这样也会带来性能的下降，毕竟是需要进行循环+递归的遍历。不过好在大部分情况下我们上传的文件并不会那么的多。不过反过来说，如果不事先进行格式化，当你想获得所有的上传内容时，一样还是需要进行多层或者递归遍历的。

接下来我们看看格式化之后的输出：

```php
Array
(
    [myfile] => Array
        (
            [0] => Array
                (
                    [name] => 2591d8b3eee018a0a84f671933ab6c74.png
                    [type] => image/png
                    [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpV7A2yC
                    [error] => 0
                    [size] => 4973
                )

            [a] => Array
                (
                    [0] => Array
                        (
                            [name] => 12711584942474_.pic_hd 1.jpg
                            [type] => image/jpeg
                            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php5q2d1Z
                            [error] => 0
                            [size] => 3007
                        )

                    [b] => Array
                        (
                            [0] => Array
                                (
                                    [name] => 12721584942474_.pic_hd 1.jpg
                                    [type] => image/jpeg
                                    [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpdvv8No
                                    [error] => 0
                                    [size] => 1156
                                )

                        )

                )

            [c] => Array
                (
                    [0] => Array
                        (
                            [name] => 12731584942474_.pic_hd.jpg
                            [type] => image/jpeg
                            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/php9tfGmp
                            [error] => 0
                            [size] => 6068
                        )

                )

            [1] => Array
                (
                    [name] => background1.jpg
                    [type] => image/jpeg
                    [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phplUVpzA
                    [error] => 0
                    [size] => 393194
                )

            [2] => Array
                (
                    [0] => Array
                        (
                            [name] => adliu_pip_data.xlsx
                            [type] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpNRtiaC
                            [error] => 0
                            [size] => 36714
                        )

                )

        )

    [newfile] => Array
        (
            [0] => Array
                (
                    [0] => Array
                        (
                            [name] => 数据列表 (2).xlsx
                            [type] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpBLG7aG
                            [error] => 0
                            [size] => 77032
                        )

                )

            [s] => Array
                (
                    [name] => background1.jpg
                    [type] => image/jpeg
                    [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpjyqCFY
                    [error] => 0
                    [size] => 393194
                )

        )

    [singlefile] => Array
        (
            [name] =>
            [type] => image/jpeg
            [tmp_name] => /private/var/folders/wj/t2z1cfhs0m9gq48krm8nc0vm0000gn/T/phpuYJXiE
            [error] => 0
            [size] => 10273
        )

)
```

和上面原始的 $_FILES 相比是不是清晰明了的很多？这回我们如果需要 myfile[a][b][] 里面全部的内容时，就可以使用下面的方式方便的获取了：

```php
$files['myfile']['a']['b'][0]['name'];
$files['myfile']['a']['b'][0]['type'];
$files['myfile']['a']['b'][0]['tmp_name'];
$files['myfile']['a']['b'][0]['error'];
$files['myfile']['a']['b'][0]['size'];
```

当然，这种需求在我们的日常工作中并不多见，这里也只是提供一个思路，将数据提前转化成我们需要的格式是一种非常好的习惯，能够让我们的后续操作变得非常简单。

测试代码：

参考文档：
[https://www.php.net/manual/zh/features.file-upload.php](https://www.php.net/manual/zh/features.file-upload.php)