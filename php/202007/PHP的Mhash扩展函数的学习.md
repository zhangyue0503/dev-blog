# PHP的Mhash扩展函数的学习

这次我们要学习的又是一个 Hash 加密扩展。不过这个扩展 Mhash 已经集成在了 Hash 扩展中。同时也需要注意的是，这个扩展已经不推荐使用了，我们应该直接使用 Hash 扩展中的函数来进行 Hash 加密操作。所以，我们今天仍然是以学习为目的的进行了解。关于 Hash 扩展的内容，我们可以查看之前的文章：[PHP的Hash信息摘要扩展框架]() 。

## 加密散列函数的使用

```php
$hash = mhash(MHASH_MD5, "测试Mhash");
echo $hash, PHP_EOL;
echo bin2hex($hash), PHP_EOL;
// /�8�><�۠�P4q�j�
// 2fcb38e93e3cc8dba09f503471846a9d

$hash = hash('md5', "测试Mhash");
echo $hash, PHP_EOL;
// 2fcb38e93e3cc8dba09f503471846a9d

$hash = mhash(MHASH_MD5, "测试Mhash", 'hmac secret');
echo $hash, PHP_EOL;
echo bin2hex($hash), PHP_EOL;
// �k�<F�m �OM����
// b86bb83c46b76d09be4f4daf18ebfe85
```

从代码中可以看出，mhash() 函数和 hash() 的使用非常像，当然，他们的作用也是一样的。不过，mhash() 函数加密出来的直接是二进制的，我们将这个内容通过 bin2hex() 转成 16 进制之后就可以看到和普通的 hash() 函数加密的结构是完全相同的了。

在进行 hmac 加密的时候直接在第三个参数上添加 key 就可以了。

## 遍历所有支持的算法类型

当然，就像 Hash 加密一样，Mhash 加密也是可以选择不同的算法的。我们也是直接使用相关的函数就可以看到当前环境中所支持的加密算法。

```php
echo mhash_count(), PHP_EOL;

$nr = mhash_count(); // 33

for ($i = 0; $i <= $nr; $i++) {
    echo sprintf("Hash：%s，块大小为： %d\n",
        mhash_get_hash_name($i),
        mhash_get_block_size($i));
}
// Hash：CRC32，块大小为： 4
// Hash：MD5，块大小为： 16
// Hash：SHA1，块大小为： 20
// Hash：HAVAL256，块大小为： 32
// Hash：，块大小为： 0
// Hash：RIPEMD160，块大小为： 20
// Hash：，块大小为： 0
// Hash：TIGER，块大小为： 24
// Hash：GOST，块大小为： 32
// Hash：CRC32B，块大小为： 4
// Hash：HAVAL224，块大小为： 28
// Hash：HAVAL192，块大小为： 24
// Hash：HAVAL160，块大小为： 20
// Hash：HAVAL128，块大小为： 16
// Hash：TIGER128，块大小为： 16
// Hash：TIGER160，块大小为： 20
// Hash：MD4，块大小为： 16
// Hash：SHA256，块大小为： 32
// Hash：ADLER32，块大小为： 4
// Hash：SHA224，块大小为： 28
// Hash：SHA512，块大小为： 64
// Hash：SHA384，块大小为： 48
// Hash：WHIRLPOOL，块大小为： 64
// Hash：RIPEMD128，块大小为： 16
// Hash：RIPEMD256，块大小为： 32
// Hash：RIPEMD320，块大小为： 40
// Hash：，块大小为： 0
// Hash：SNEFRU256，块大小为： 32
// Hash：MD2，块大小为： 16
// Hash：FNV132，块大小为： 4
// Hash：FNV1A32，块大小为： 4
// Hash：FNV164，块大小为： 8
// Hash：FNV1A64，块大小为： 8
// Hash：JOAAT，块大小为： 4
```

在 PHP 中也提供了非常多的常量来代表这些算法，比如在前一段代码中我们使用的 MHASH_MD5 。其实就是我们遍历的这些内容在前面加上 MHASH_ 就可以了。具体支持的常量列表我们可以在官方手册中找到，在这里就不进行复制粘贴了。

## Salted S2K 算法生成密码摘要

另外，Mhash 还为我们提供了一个非常方便的 Salted S2K 算法可以用来方便地生成一套非常方便地密码加密内容。

```php
// OpenPGP 指定的 Salted S2K 算法
$hashPassword = mhash_keygen_s2k(MHASH_SHA1, '我的密码', random_bytes(2), 4);
echo $hashPassword, PHP_EOL;
echo bin2hex($hashPassword), PHP_EOL;
// �-!=
// 101ab899
```

当然，这个算法也是比较安全的，有 salt 参数，并且它可以指定返回的数据长度。它返回的也是二进制的数据，如果需要保存标准的文本内容也需要将其转化为 16 进制的形式。不过相对来说，我反而觉得这种直接生成二进制内容的还更安全一些。

## 总结

不同的函数有不同的应用场景，但其实 Mhash 已经没有什么特别的应用场景了，毕竟 Hash 扩展中的相关函数已经完全能够替代它的作用了，而且还更加的丰富易用。大家如果在老的项目中见到这些函数的使用，也完全可以慢慢的通过重构替换到新的函数。

测试代码：


参考文档：

[https://www.php.net/manual/zh/book.mhash.php](https://www.php.net/manual/zh/book.mhash.php)