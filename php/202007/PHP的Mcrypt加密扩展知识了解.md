# PHP的Mcrypt加密扩展知识了解

今天我们来学习的是 PHP 中的一个过时的扩展 Mcrypt 。在 PHP7 之前，这个扩展是随 PHP 安装包一起内置发布的，但是现在新版本的 PHP 中已经没有了，需要使用这个扩展的话我们需要单独安装，并且在使用的时候也是会报出过时的警告的。所以，我们学习使用这些函数的时候，就需要使用 @ 来抑制错误信息。当然，之所以会对这套扩展发出过时警告，是因为 PHP 更加推荐使用 OpenSSL 来处理类似的加密能力。

## 模块和算法

Mcrypt 主要是使用的 Mcrypt 工具来进行加密操作的，所以在 CentOS 或者其它操作系统中，我们需要安装 libmcrypt-devel 来使用这个扩展。如果 yum 中无法安装的话，直接更新 yum 源即可。

Mcrypt 包含很多的模块和算法。算法就不用多解释了，就是用来对数据进行加密的方式。而模块，包括 CBC， OFB，CFB 和 ECB 这几种，是一系列的分组、流式加密的模式，有推荐的模块，也有安全的模块，具体的区分大家可以自行查阅相关的资料，这里我们先看一下我们的环境中所支持的模块和算法。

```php
$algorithms = @mcrypt_list_algorithms();
print_r($algorithms);
// Array
// (
//     [0] => cast-128
//     [1] => gost
//     [2] => rijndael-128
//     [3] => twofish
//     [4] => arcfour
//     [5] => cast-256
//     [6] => loki97
//     [7] => rijndael-192
//     [8] => saferplus
//     [9] => wake
//     [10] => blowfish-compat
//     [11] => des
//     [12] => rijndael-256
//     [13] => serpent
//     [14] => xtea
//     [15] => blowfish
//     [16] => enigma
//     [17] => rc2
//     [18] => tripledes
// )

$modes = @mcrypt_list_modes();
print_r($modes);
// Array
// (
//     [0] => cbc
//     [1] => cfb
//     [2] => ctr
//     [3] => ecb
//     [4] => ncfb
//     [5] => nofb
//     [6] => ofb
//     [7] => stream
// )
```

mcrypt_list_algorithms() 函数可以获得当前环境下所有支持的 Mcrypt 算法。而 mcrypt_list_modes() 则打印出了当前环境下所有可支持的模块。注意在某些版本的 PHP 或者某些系统中，这些内容会有所不同，在使用 Mcrypt 相关的加密能力的时候，这两项都是相互配合使用的。因此，我们有必要在需要运行 Mcrypt 的环境中预先确定好当前环境下所支持的模块和算法。

## 加密解密数据

```php
$key = hash('sha256', 'secret key', true);
$input = json_encode(['id'=>1, 'data'=>'Test mcrypt!']);

$td = @mcrypt_module_open('rijndael-128', '', 'cbc', '');
$iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
@mcrypt_generic_init($td, $key, $iv);
$encrypted_data = @mcrypt_generic($td, $input);
@mcrypt_generic_deinit($td);
@mcrypt_module_close($td);

echo $encrypted_data, PHP_EOL;
// ��I      $�3���gE�ǣu(�9n�����
//                            p�>P

$td = @mcrypt_module_open('rijndael-128', '', 'cbc', '');

@mcrypt_generic_init($td, $key, $iv);
$data = @mdecrypt_generic($td, $encrypted_data);
echo $data, PHP_EOL;
// {"id":1,"data":"Test mcrypt!"}

@mcrypt_generic_deinit($td);
@mcrypt_module_close($td);
```

代码比较多也较乱，我们一块一块来看。

首先是我们确定一个加密的 key ，然后 input 就是我们要加密的数据。比如我们要加密一个 json 数据。这个 key 其实用字符串就可以，但我们这里也对 key 进行了一次 hash 处理，这个 hash 相关的内容在上一篇文章我们已经详细的讲解过了。

接下来就是使用 mcrypt_module_open() 打开一个加密模块句柄，这里我们使用 rijndael-128 算法和 cbc 模块。然后使用 mcrypt_create_iv() 创建一个 iv ，这个 iv 就是一个初始化向量。初始化向量的值依密码算法而不同。最基本的要求是“唯一性”，也就是说同一把密钥不重复使用同一个初始化向量。这个特性无论在分组加密或流加密中都非常重要。相信大家要是做过微信或支付宝相关的接口通信，在解密验证数据的时候一定会见过这个 iv 属性。

使用 mcrypt_generic() 生成加密结果，使用 mcrypt_generic_deinit() 结束生成初始化，最后通过 mcrypt_module_close() 关闭加密模块句柄。这样，一套 Mcrypt 加密流程就完成了。

同样的，解密流程和加密流程也是类似的，只是我们使用 mdecrypt_generic() 这个函数来进行解密就可以了。

## 另一种加密解密数据方式

上面的加密流程非常麻烦而且复杂，其实在 Mcrypt 中还提供了一种更简单的加密函数。

```php
$string = 'Test MCrypt2';
$algorithm = 'rijndael-128';
$key = md5( "mypassword", true);
$iv_length = @mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
$iv = @mcrypt_create_iv( $iv_length, MCRYPT_RAND );

$encrypted = @mcrypt_encrypt( $algorithm, $key, $string, MCRYPT_MODE_CBC, $iv );
$result = @mcrypt_decrypt( $algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv );

echo $encrypted, PHP_EOL; // \<�`�U��Uf)�Y
echo $result, PHP_EOL; // Test MCrypt2
```

我们依然要准备好要加密的数据，算法，key ，以及 iv 向量。然后直接使用 mcrypt_encrypt() 和 mcrypt_decrypt() 来进行加/解密就可以了，是不是方便很多。

## 总结

相对于 Hash 来说，Mcrypt 是可解密的对称加密形式。关于什么是对称和非对称加密，我们将在 OpenSSL 扩展的学习中详细地讲解，而 Hash 加密则是单向的加密形式，是无法通过加密后的数据反向计算获得原始数据的。它们都有不同的应用场景，不过就像 PHP 提示的那样，Mcrypt 已经是不推荐使用的扩展了，所以我们在这里只是简单的进行了加/解官的测试而已，如果有用到的小伙伴，可以根据手册进行更深入地学习。

测试代码：

参考文档：

[https://www.php.net/manual/zh/book.mcrypt.php](https://www.php.net/manual/zh/book.mcrypt.php)
[https://ask.csdn.net/questions/700696](https://ask.csdn.net/questions/700696)