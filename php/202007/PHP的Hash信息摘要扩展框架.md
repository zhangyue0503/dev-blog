# PHP的Hash信息摘要扩展框架

今天我们主要学习的是 PHP 中一些 Hash 散列加密相关的扩展函数的使用，而不是 Hash 算法，这种加密其实也只是一种更复杂一些的密钥算法，与 Hash 算法类似的是，我们输入的一串字符串，就像一个 Hash 表一样有其对应的 Hash 散列值，本质上和普通的数据结构中的 Hash 键值映射是一个道理，只是其算法更复杂一些。其实只要做过一段时间的 PHP 开发，一定会对两个函数很熟悉，它们就是 md5() 和 sha1() 。这两个函数就是分别生成 md5 和 sha1 算法的 Hash 加密。不过，今天我们学习的相比这两个函数更加的复杂一些，算法形式也更丰富一些。

## 什么是 Hash 信息摘要算法

通常，我们将一段内容输入一个 Hash 函数后，返回的一串散列字符串就是这个输入值的 Hash 信息摘要。在 PHP 中，不管是 md5 还是 sha1 ，同样的输入会产生同样的结果。由此，如果在保存用户密码类的信息时，我们尽量不要只使用一层 Hash ，因为这种形式的加密是可以通过彩虹表暴力破解出来的。我们可以对密码进行多层 Hash 并加盐来实现散列值的复杂化。

当然，Hash 算法并不止我们常用的 md5 和 sha1 ，还有很多其它类型的算法，只是我们并不常用。但是，今天介绍的函数正是可以进行多种不同类型的 Hash 加密的一组函数，它们已经在 PHP 中集成到了默认环境中，我们并不需要单独的扩展就可以使用，这样，就为我们的加密数据多样化带来了更多的方便。

## PHP 支持的 Hash 算法

```php
print_r(hash_algos());
// Array
// (
//     [0] => md2
//     [1] => md4
//     [2] => md5
//     [3] => sha1
//     [4] => sha224
//     [5] => sha256
//     [6] => sha384
//     [7] => sha512/224
//     [8] => sha512/256
//     [9] => sha512
//     [10] => sha3-224
//     [11] => sha3-256
//     [12] => sha3-384
//     [13] => sha3-512
//     [14] => ripemd128
//     [15] => ripemd160
//     [16] => ripemd256
//     [17] => ripemd320
//     [18] => whirlpool
//     [19] => tiger128,3
//     [20] => tiger160,3
//     [21] => tiger192,3
//     [22] => tiger128,4
//     [23] => tiger160,4
//     [24] => tiger192,4
//     [25] => snefru
//     [26] => snefru256
//     [27] => gost
//     [28] => gost-crypto
//     [29] => adler32
//     [30] => crc32
//     [31] => crc32b
//     [32] => fnv132
//     [33] => fnv1a32
//     [34] => fnv164
//     [35] => fnv1a64
//     [36] => joaat
//     [37] => haval128,3
//     [38] => haval160,3
//     [39] => haval192,3
//     [40] => haval224,3
//     [41] => haval256,3
//     [42] => haval128,4
//     [43] => haval160,4
//     [44] => haval192,4
//     [45] => haval224,4
//     [46] => haval256,4
//     [47] => haval128,5
//     [48] => haval160,5
//     [49] => haval192,5
//     [50] => haval224,5
//     [51] => haval256,5
// )

$data = "我们来测试一下Hash算法！"; 

foreach (hash_algos() as $v) { 
    $r = hash($v, $data); 
    echo $v, ':', strlen($r), '::', $r, PHP_EOL; 
}
// md2:32::3d63d5f6ce9f03379fb3ae5e1436bf08
// md4:32::e9dc8afa241bae1bccb7c58d4de8b14d
// md5:32::2801b208ec396a2fc80225466e17acac
// sha1:40::0f029efe9f1115e401b781de77bf1d469ecee6a9
// sha224:56::3faf937348ec54936be13b63feee846d741f8391be0a62b4d5bbb2c8
// sha256:64::8f0bbe9288f6dfd2c6d526a08b1fed61352c894ce0337c4e432d97570ae521e3
// sha384:96::3d7d51e05076b20f07dad295b161854d769808b54b784909901784f2e76db212612ebe6fe56c6d014b20bd97e5434658
// ……

foreach (hash_hmac_algos() as $v) { 
    $r = hash_hmac($v, $data, 'secret'); 
    echo $v, ':', strlen($r), '::', $r, PHP_EOL; 
}
// md2:32::70933e963edd0dcd4666ab9253a55a12
// md4:32::d2eda43ee4fab5afc067fd63ae6390f1
// md5:32::68bf5963e1426a1feff8149da0d0b88d
// sha1:40::504bc44704b48ac75435cdccf81e0f056bac98ba
// sha224:56::8beaf35baedc2cd5725c760ec77d119e3373f14953c74818f1243f69
// sha256:64::23f2e6685fe368dd3ebe36e1d3d672ce8306500366ba0e8a19467c94e13ddace
// sha384:96::740ce7488856737ed57d7b0d1224d053905661ffca083c02c6a9a9230499a4a3d96ff0a951b8d03dbafeeeb5c84a65a6
// ……
```

通过 hash_algos() 和 hash_hmac_algos() 函数，我们就可以获取到当前 PHP 环境中所支持的所有 Hash 算法，我们可以见到熟悉的 md5 和 sha1 ，也能见到 md2 、 sha224 、 ripemd320 、fnv1a64 等这些很少见到的算法。然后我们通过遍历这两个函数返回的内容，并使用 hash() 和 hash_hmac() 函数来对数据进行 Hash 加密并查看它们的内容就可以发现每种算法都能够成功返回不同的加密信息摘要，而且有不同的位数。

hmac 相关的函数是 PHP 的 Hash 算法中的另一种形式，它是一个需要密钥的算法，也就是 hash_hmac() 的第三个参数。只有输入内容相同并且密钥也相同的内容返回的结果才会是一样的。也就是说，这个函数可以用于对称加密的信息传递验证 token 来使用。比如两个系统之间的接口互通如果需要一个固定 token 的，就可以使用这个函数来实现。

## 与 md5() 、 sha1() 的比较

这个 hash() 函数如此强大，那么它生成的内容和 md5 是一样的吗？

```php
// 与 md5 sha1 函数对比

echo hash('md5', '我们来测试一下Hash算法！'), PHP_EOL;
echo md5('我们来测试一下Hash算法！'), PHP_EOL;
// 2801b208ec396a2fc80225466e17acac
// 2801b208ec396a2fc80225466e17acac

echo hash('sha1', '我们来测试一下Hash算法！'), PHP_EOL;
echo sha1('我们来测试一下Hash算法！'), PHP_EOL;
// 0f029efe9f1115e401b781de77bf1d469ecee6a9
// 0f029efe9f1115e401b781de77bf1d469ecee6a9

echo hash('fnv164', '我们来测试一下Hash算法！'), PHP_EOL;
// b25bd7371f08cea4
```

这个当然是不用怀疑的，甚至我感觉 md5() 和 sha1() 这两个函数本身就是 hash() 函数的一个语法糖。因为这两种算法实在是太常用了，所以 PHP 就直接为我们封装好了两个现在的函数，而且它们就一个参数就行了，非常的简单方便。

## 文件 HASH

在很多下载站，都会提供下载文件的 Hash 值让我们进行校验对比来确定下载的文件是否完整相同。这种就是文件 Hash 的应用。其实说白了也是提取文件内容进行 Hash 散列之后获得的关于这个文件的信息摘要而已。这一套功能当然在我们的 PHP 中也是完美支持的。

```php
/ 文件 HASH

echo hash_file('md5', './create-phar.php'), PHP_EOL;
echo md5_file('./create-phar.php'), PHP_EOL;
// ba7833e3f6375c1101fb4f1d130cf3d3
// ba7833e3f6375c1101fb4f1d130cf3d3

echo hash_hmac_file('md5', './create-phar.php', 'secret'), PHP_EOL;
// 05d1f8eb7683e190340c04fc43eba9db
```

## hkdf 与 pbkdf2 的 HASH 算法

接下来介绍的这两种算法又是特殊的两种 Hash 算法。和 hmac 类似，但比 hmac 又更复杂一些。

```php
// hkdf pbkdf2 算法

//              算法       明文密码（原始二进制）     输出长度  应用程序/特定于上下文的信息字符串    salt值
$hkdf1 = hash_hkdf('sha256', '123456', 32, 'aes-256-encryption', random_bytes(2));
$hkdf2 = hash_hkdf('sha256', '123456', 32, 'sha-256-authentication', random_bytes(2));
var_dump($hkdf1);
var_dump($hkdf2);
// string(32) "ԇ`q��X�l�
//                      f�yð����}Ozb+�"
// string(32) "%���]�+̀�\JdG��HL��GK��
//                                   -"

//              算法       明文密码     salt值        迭代次数  数据长度
echo hash_pbkdf2("sha256", '123456', random_bytes(2), 1000, 20), PHP_EOL;
// e27156f9a6e2c55f3b72
```

hmac 只需要一个密钥就可以了，hash_hkdf() 则是增加了返回长度、应用程序/特定于上下文的信息字符串、以及盐值三个参数，而且加密后的内容是二进制的加密内容，是不是感觉很高大上！而 hash_pbkdf2() 则是增加了盐值、迭代次数和数据长度三个参数，也是一个能用于密码加密的好帮手。但是相对来说，它们的使用要更复杂一些，如果是对安全性要求非常高的密码就可以使用这两种函数。

## hash_equals() 函数进行 Hash 对比

PHP 中还为我们提供了一个对比 Hash 值是否相等的函数。有的小伙伴要问了，既然返回的是字符串形式的摘要信息，直接 === 不就可以了嘛，为啥还要一个专门的函数来比较呢？别急，我们先看下代码。

```php
// hash_equals 比较函数

$v1 = hash('md5', '测试对比');
$v2 = hash('md5', '测试对比');
$v3 = hash('md5', '测试对比1');

// 比较两个字符串，无论它们是否相等，本函数的时间消耗是恒定的
// 本函数可以用在需要防止时序攻击的字符串比较场景中， 例如，可以用在比较 crypt() 密码哈希值的场景
var_dump(hash_equals($v1, $v2));
var_dump(hash_equals($v1, $v3));
// bool(true)
// bool(false)
```

我在注释中已经写得很清楚了，hash_equals() 函数主要是可以防止时序攻击。一般来说，这个时序攻击就是根据你的系统运行时间长短来判断你的系统中使用了什么函数或者功能，这都是非常厉害的黑客高手玩的东西。比如说，我们比较用户密码的时候，假设是一位一位的进行比较，那么如果第一个字符错了信息很快就会返回，而如果比较到最后一个才错的时候，程序运行时间就会长很多，黑客就可以根据这个时长来判断当前暴力破解的内容是否一步步达到目标，也让破解难度逐步下降。(普通的字符串比较 === 就是基于位移的)。而 hash_equals() 则是不管怎么比较，相同的 Hash 算法长度的内容返回的时间都是相同的。OpenSSL 、 OpenSSH 等软件都曾出现过这种类似的时序攻击漏洞！

当然，这个我们只做了解即可，同样也是对于安全性有特殊要求的一些项目，就可以使用这个函数来避免出现这种时序攻击的漏洞提高系统安全性。

## 增量 Hash 操作

最后我们要学习的是一套增量 Hash 的操作函数。其实对于字符串来说，大部分情况下我们直接将字符串拼接好再 Hash 就可以了，并不太需要增量 Hash 的能力。但是如果是对于多个文件或者读写流来说，想要获得多文件的 Hash 值，就可以使用这一套增量 Hash 函数来进行操作了。

```php
// 增量 HASH

$fp = tmpfile();
fwrite($fp, '初始化一个流文件');
rewind($fp);

$h1 = hash_init('md5'); // 开始增量 Hash
hash_update($h1, '测试增量'); // 普通字符串
hash_update_file($h1, './create-phar.php'); // 文件
hash_update_stream($h1, $fp); // 流
$v1 = hash_final($h1); // 结束 Hash 返回结果
echo $v1, PHP_EOL;
// 373df6cc50a1d7cd53608208e91be1e7

$h2 = hash_init('md5', HASH_HMAC, 'secret'); // 使用 HMAC 算法的增量 HASH
hash_update($h2, '测试增量');
hash_update_file($h2, './create-phar.php');
hash_update_stream($h2, $fp);
$v2 = hash_final($h2);
echo $v2, PHP_EOL;
// 34857ee5d8b573f6ee9ee20723470ea4
```

我们使用 hash_init() 来获得一个增量 Hash 操作句柄并指定好加密算法。然后使用 hash_update() 添加字符串、使用 hash_update_file() 增加文件内容，使用 hash_update_stream() 来增加流内容，最后使用 hash_final() 结束句柄操作进行 Hash 计算并返回结果值。得到的结果值就是包含字符串、文件和流内容一起 Hash 的结果。

## 总结

说实话，在没有学习今天的内容之前，我也一直以为 PHP 里面只有 md5 和 sha1 这两种 Hash 算法呢。这回真是大开了眼界，我们不仅拥有丰富的算法库，而且还有很多方便的操作函数能够帮助我们方便的使用这些算法，不多说了，学习继续！

测试代码：


参考文档：

[https://www.php.net/manual/zh/book.hash.php](https://www.php.net/manual/zh/book.hash.php)
[https://www.zhihu.com/question/20156213](https://www.zhihu.com/question/20156213)
[https://baike.baidu.com/item/%E6%97%B6%E5%BA%8F%E6%94%BB%E5%87%BB/17882818?fr=aladdin](https://baike.baidu.com/item/%E6%97%B6%E5%BA%8F%E6%94%BB%E5%87%BB/17882818?fr=aladdin)