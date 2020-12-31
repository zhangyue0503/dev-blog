# PHP的Sodium加密扩展函数了解

这是本次加密扩展系列的最后一篇文章，也是我们要学习了解的最后一个 PHP 加密扩展。Sodium 出现的目的也是为了代替 Mcrypt 这个原来的加密扩展。在 PHP7.2 之后，Mcrypt 已经被移除，在 PHP7.1 时就已经被标记为过时。不过，Sodium 扩展的应用也并不是很多，大部分情况下我们都会使用 OpenSSL 来进行加密操作，同时，Sodium 扩展提供的函数也非常多，所以，我们这篇文章只做了解即可。当然，最主要的是，关于这个扩展即使是官方文档也没有完善，大部分函数的参数说明都没有，搜索出来的资料也是非常少。

Sodium 扩展在 PHP7.2 后是跟随 PHP 源码一起发布的，只需要在编译的时候加上 --with-sodium 即可安装成功。如果是 PHP7.2 之前的版本，需要单独安装这个扩展。同时，操作系统中也需要安装 libsodium-devel 库。

## AEAD_AES_256_GCM 加解密

首先是这个 AEAD_AES_256_GCM 加解密能力函数的应用。在微信支付相关的开发中，有一个接口就是使用的这种方式进行数据加密，在官方文档中，也提供了 PHP 对应的解密方式，其中使用的就是 Sodium 扩展库中的函数。（见文末参考文档中第二条链接）

```php
$data = '测试加密'; // 原始数据
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES); // 加密证书的随机串,加密证书的随机串
$ad = 'fullstackpm'; // 加密证书的随机串
$kengen = sodium_crypto_aead_aes256gcm_keygen(); // 密钥

// 是否可用
echo sodium_crypto_aead_aes256gcm_is_available(), PHP_EOL; // 1

// 加密
$pem = sodium_crypto_aead_aes256gcm_encrypt($data, $ad, $nonce, $kengen);
var_dump($pem);
// string(28) "��VRw!�����f��l�O�tV=\x�"

// 解密
$v = sodium_crypto_aead_aes256gcm_decrypt($pem, $ad, $nonce, $kengen);
var_dump($v);
// string(12) "测试加密"
```

代码中的注释已经详细说明了相关函数及参数。在微信支付中使用这个来解密时，ad、key、nonce 等都是由微信提供过来的，而我们这里做为演示，都是自己生成的内容。

sodium_crypto_aead_aes256gcm_encrypt() 加密生成的内容也是二进制的内容，所以相对来说也是非常安全的一种加密形式。

## 信息签名

Sodium 扩展库同样也为我们带来了验证数据是否被篡改的功能，也就是对信息进行签名比对的能力。

```php
// 信息签名
$key = sodium_crypto_auth_keygen(); // 生成随机签名密钥
$message = '测试认证签名';

// 生成签名
$signature = sodium_crypto_auth($message, $key);
var_dump($signature);
// string(32) "�B�
//                9���l�wn�x���ӛc�ܙ�u^j��"

// 验证签名
var_dump(sodium_crypto_auth_verify($signature, $message, $key));
// bool(true)
```

它们需要的就是一个简单的随机签名密钥，然后通过对签名摘要和原文进行比对来确定数据在传输过程中是否被篡改。

## Hash

是的，你没看错，Sodium 扩展也为我们提供了一套 Hash 加密的函数。不过它的使用要复杂一些，生成的内容有点像 密码散列算法 生成的内容。不过我们还是更推荐使用 密码散列算法 中的 password_hash() 来生成这类的 Hash 密码。

```php
// Hash
$password = '测试Hash';
$hash = sodium_crypto_pwhash_str(
    $password,
    SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, // 最大计算量
    SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE // 最大RAM量
);
var_dump($hash);
// string(97) "$argon2id$v=19$m=65536,t=2,p=1$VFfdNV4W0MFwLiLPdr9i6g$QDmd5sQToZANYTVEkPVTbPvbY7tuf1ALKU3IXrF44R0"

// 验证 Hash 信息
var_dump(sodium_crypto_pwhash_str_verify($hash, $password));
// bool(true)
```

## 总结

虽说我们平常可能没接触过，但是确实在开发中 Sodium 扩展还是有实际应用的，既然微信都使用这种加密方式进行了数据加密，我们也应该对它有更深入的了解。不过，还是希望官方能够尽早完善文档，否则也无法系统地学习这套扩展里面的内容。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/PHP%E7%9A%84Sodium%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%87%BD%E6%95%B0%E4%BA%86%E8%A7%A3.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202008/source/PHP%E7%9A%84Sodium%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%87%BD%E6%95%B0%E4%BA%86%E8%A7%A3.php)

参考文档：

[https://www.php.net/manual/en/book.sodium.php](https://www.php.net/manual/en/book.sodium.php)

[https://pay.weixin.qq.com/wiki/doc/api/xiaowei.php?chapter=19_11](https://pay.weixin.qq.com/wiki/doc/api/xiaowei.php?chapter=19_11)