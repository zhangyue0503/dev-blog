# 在PHP中操作临时文件

关于文件相关的操作，想必大家已经非常了解了，在将来我们刷到手册中相关的文件操作函数时也会进行详细的讲解。今天，我们先来了解一下在 PHP 中关于临时文件相关的一些内容。

## 获取 PHP 的默认临时创建文件目录

学习过 Linux 操作系统的都会知道有一个目录是 /tmp 目录（ Windows 中一般是：C:\Windows\Temp\ ），它是用来存放系统的一些临时文件的，所以，这个目录也叫做临时文件目录。很多软件都会将一些临时保存的文件放在这个目录里面，包括一些缓存、一些临时生成的脚本之类的。PHP 在默认情况下也会将临时文件目录指向这个目录，包括 SESSION 文件之类的临时文件都会保存在这里。它可以在 php.ini 文件中通过 sys_tmp_dir 进行设置。

当然，在动态运行的 PHP 程序中，我们也可以通过一个函数来获得当前的临时文件目录。

```php
print_r(sys_get_temp_dir());
// /tmp
```

## 创建一个临时文件

既然有了临时文件目录，PHP 当然也贴心的为我们准备好了直接去创建一个临时文件的函数。

```php
$tmpFile = tmpfile();
fwrite($tmpFile, "I'm tmp file.");
// ll /tmp
// vim phpbnAjbE

sleep(10);

fclose($tmpFile);
// ll /tmp
```

tmpfile() 函数就是用来创建这个临时文件的，我们不需要为它指定文件名，也不需要为它指定路径，同时，它创建的文件是 w+ 类型的，也就是直接就是可读写的文件。当调用 fclose() 的时候，这个临时文件将自动删除掉。手册中说使用这个函数创建的文件在脚本运行结束后也会自动删除，但是在测试后发现脚本结束时文件并不会删除。

在调用函数并写入内容后，我们暂停了十秒。其实就是为了去 /tmp 目录里看一下这个文件是否生成成功。根据文件创建的时间，我们找到了生成的这个对应的文件。然后在十秒后执行了 fclose() 之后，再次到目录查看，就会发现文件已经被自动删除了。

## 根据目录状态创建一个唯一名称的临时文件

最后，PHP 还为我们提供了一个非常人性化的创建临时文件的函数。

```php
$tmpFile = tempnam('/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source', 'testtmp');
$f = fopen($tmpFile, "w");
fwrite($f, "I'm tmp file.");
// ll /tmp
// vim testtmpH7bptZ

// etc目录没有写权限
$tmpFile = tempnam('/etc', 'testtmp');
$f = fopen($tmpFile, "w");
fwrite($f, "I'm tmp file.");
// ll /etc
// ll /tmp
// vim testtmpTUNucM
```

tempnam() 函数，它会根据目录的状态去生成一个唯一名称的临时文件。什么叫根据目录状态呢？从上面的代码注释中可以看出，第二段的 /etc 目录一般是 root 权限的目录，没有 root 帐户权限的话我们是无法创建修改文件的。如果是这种没有权限的目录，或者是压根就不存在的目录，tempnam() 函数就会将文件生成到临时文件目录中去。如果目录是正常存在并且可以写的，就像第一段代码一样，文件就会正常在这个目录进行创建。

tempnam() 函数的第二个参数是指定生成文件名的前缀。tmpfile() 函数是无法指定文件名的，而这个函数则是可以给文件名一个固定的前缀，并保证前缀之后自动生成的文件名部分是唯一的。

## 总结

又发现了这几个非常好玩的函数，不管是做为临时缓存还是进行一些文件的创建，这两个临时文件操作的函数都非常有用。在日后的开发中我们可以多多尝试使用这样的函数，或许它们能够为我们带来不少的生产力提升。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/%E5%9C%A8PHP%E4%B8%AD%E6%93%8D%E4%BD%9C%E4%B8%B4%E6%97%B6%E6%96%87%E4%BB%B6.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202006/source/%E5%9C%A8PHP%E4%B8%AD%E6%93%8D%E4%BD%9C%E4%B8%B4%E6%97%B6%E6%96%87%E4%BB%B6.php)

参考文档：

[https://www.php.net/manual/zh/function.sys-get-temp-dir.php](https://www.php.net/manual/zh/function.sys-get-temp-dir.php)

[https://www.php.net/manual/zh/function.tmpfile.php](https://www.php.net/manual/zh/function.tmpfile.php)

[https://www.php.net/manual/zh/function.tempnam.php](https://www.php.net/manual/zh/function.tempnam.php)
