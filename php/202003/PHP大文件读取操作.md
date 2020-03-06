# PHP大文件读取操作

简单的文件读取，一般我们会使用 file_get_contents() 这类方式来直接获取文件的内容。不过这种函数有个严重的问题是它会把文件一次性地加载到内存中，也就是说，它会受到内存的限制。因此，加载大文件的时候是绝对不能使用这种方式的。我们还是先看看这种方式加载的例子。

```php
// 普通的文件读取 一个2.4G的SQL导出文件
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
```

上述三种形式的文件加载读取方式都是不能加载这么大的文件的，当然，你也可以修改 php.ini 中的相关配置让他们能够加载成功，但我们并不推荐这样使用，毕竟内存资源相比硬盘资源还是要宝贵的多。

以下的方式是可以直接读取这种大文件的：

```php
// readfile 只能直接输出
echo readfile($fileName);

// fopen + fgetc 如果单
$fileHandle = fopen($fileName, 'r');
// 输出单字符直到 end-of-file
while(!feof($fileHandle)) {
    echo fgetc($fileHandle);
}
fclose($fileHandle);

// SplFileObject
$fileObject = new SplFileObject($fileName, 'r');
while(!$fileObject->eof()){
    echo $fileObject->fgetc();
}
```

第一个 readfile() ，读取文件后就直接打印了，不能进行其他操作，适用于直接显示大文件内容时使用。

第二个 fopen() 配合 fgetc() 或 fgets() 是读取这种大文件的标配。fopen() 获取文件句柄，fgetc() 按字符读取，fgets() 按行读取。像这个 mysqldump 出来的文件，一行也可能非常的大，所以我们就只能直接按字符读取。

第三个是SPL扩展库为我们提供的面向对象式的 fopen() 操作，建议新的开发中如果有读取大文件的需求最好使用这种形式的写法，毕竟SPL函数库已经是PHP的标准函数库了，而且面向对象的操作形式也更加的主流。

上面三种读取方式都有一个要注意的点是，我们将大文件读取后不应该再保存到变量中，应该直接打印显示、入库或者写到其他文件中。因为直接读取到一个变量中就和前面的直接读取到内存的方式一样了，那还不如直接去修改下 php.ini 的配置然后使用最上方的方式直接读取到内存方便。还是那句话，内存留给真正需要它的地方，这种大文件，最好还是进行硬盘的IO操作。

测试代码：


参考文档：
《PHP7编程实战》