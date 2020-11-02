# PHP的OpenSSL加密扩展学习（二）：非对称加密

上篇文章，我们了解了关于对称和非对称加密的一些相关的理论知识，也学习了使用 OpenSSL 来进行对称加密的操作。今天，我们就更进一步，学习 OpenSSL 中的非对称加密是如何实现的。

## 生成私钥

通过之前的学习，我们知道非对称加密是分别需要一个公钥和一个私钥的。我们就先来生成一个私钥，也就是存放在我们这一端一个密钥。请记住，在任何时候，私钥都是不能给别人的哦！

```php
$config = array(
    "private_key_bits" => 4096, // 指定应该使用多少位来生成私钥
);

$res = openssl_pkey_new($config); // 根据配置信息生成私钥

openssl_pkey_export($res, $privateKey); // 将一个密钥的可输出表示转换为字符串
var_dump($privateKey); 
// -----BEGIN PRIVATE KEY-----
// MIIJQgIBADANBgkqhkiG9w0BAQEFAASCCSwwggkoAgEAAoICAQDFMLW+9t3fNX4C
// YBuV0ILSyPAdSYVXtE4CLv32OvNk9yQZgF2nL/ZuIbBGRcYo2Hf5B31doGrAFDGu
// NoTR+WA7CBjKROFr/+yValsMFIeiKNtttWMkmBciysDJoEoyd6wjDD+kcHQdoJVo
// ……
// -----END PRIVATE KEY-----
```

非常简单的一个函数 openssl_pkey_new() ，它接收一个参数，这个参数是可配置项并且是可选参数。生成的结果是一个私钥句柄，不是我们能直接读取的内容，所以我们再使用 openssl_pkey_export() 来提取可输出的字符串。

注释中的内容就是我们生成的私钥信息了，私钥信息一般会相对多些，所以省略了后面的内容。

## 抽取公钥

接下来就是生成公钥了，其实，公钥是从私钥中抽取出来的。所以我们使用进行加解密的时候，都可以使用私钥或者公钥互相操作。

```php
$publicKey = openssl_pkey_get_details($res); // 抽取公钥信息
var_dump($publicKey);
// array(4) {
//     ["bits"]=>
//     int(4096)
//     ["key"]=>
//     string(800) "-----BEGIN PUBLIC KEY-----
//   MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAtOIImDdS0W0vAr5Ra1+E
//   hR2AJwQQwxntYKgTku8EmJRBX2vU+x8th8W8SnoGiVM/sOItG0HIe4Egf1UxoZHt
//   gI6r+jpAp7JbTN0sD/VTPDE09F21+hFGjIVBqrkcLPjuEbf7+tjmgAx8cG8WLGId
//   G8Hsub70kRANKJe1bCXIBUggRFk0sQGllxA/hxiG5wANqHTrdpJgJba+ahSi2+4H
//   UWnyCV1O3AaPyz6a12HNUsG4Eio/tWv/hOB9POt6nAqwPHuIbhp56i5bv1ijMJZM
//   jwRen5f/kwdZ01Ig2fi0uBoTR2y/EEaus7xBYpF/gGzZ/uM7cNUXcDyG5YluM/4R
//   MEv4msPMVGB72izItED+C6Cqftxl98iBFRDc+PISFbRSgOU/HsuBhKkM5SYzyi3I
//   Ypaej25++qLPqcA+EDr3JNDhNZ0GOhofCRtPq4dsr7iLLLRnZ0TnhIYe9wAbmO49
//   uthABNBkM54bG+omOfY4Bkn5n39CKpELbhIiXgOd+lA684XUS/2Aw3Dvelc9Gbag
//   oIFvb/wljPYsd0Zmd64CXBpTWbfwXC8K4vCKvFLjytcz2Yp4T6fVjbLT5RA6u8su
//   E0WwE4QTFNKhnM5OvfiMN+NMc3Y/esVfcin3eyvotdz4N6Tt45dkybkf6aQE3Scg
//   E/JBLIEEA+gjGTveY4cNUiECAwEAAQ==
//   -----END PUBLIC KEY-----
//   "
//     ["rsa"]=>
// ……

$publicKey = $publicKey['key'];
```

使用 openssl_pkey_get_details() 抽取出来的内容包含很多内容。不过我们所需要的最主要的内容就是 key 下面的这个公钥。

大家再回过头来好好看一下公钥和私钥的内容，是不是和我们去申请的 HTTPS 证书中的公私钥内容长得一样，而且也和我们自己在系统中使用 openssl 命令行生成的本机的密钥证书一样。它们本身就是一样的东西啦，只是在不同的场景应用的不同而已。HTTPS 证书除了非对称加密的密钥之外，还包含有 CA 信息，如果 CA 不通过，浏览器也会认为证书是无效的，因此，我们使用自己生成的证书来充当 HTTPS 证书是不可以的。而本身生成的一般会用在 SSH 免密登录上，或者是 GitHub 的免密代码仓库操作上。

## 加密解密数据

好了，公钥和私钥都生成完成了，那么我们就要进行最重要的加密和解密操作了。

```php
$data = '测试非对称加密';

// 公钥加密数据
openssl_public_encrypt($data, $encrypted, $publicKey);
var_dump($encrypted);
// string(512) "��E��2��~��\d����q�O�=(��Y���3L����0�,�J����s�V��V߬G~'�20���@��6�d�����#Z]�.��<Z��8G�����-ʝ�M�0](2��+$�*����\e�7ҕʴ��|SUw�#rFb�8"�s4K�B�Y�'�\S���~!<�"���!U��S(���S ��?e�֜r��/���c��L�YL�'ŖE*S��[�J�"�n��`(ʿoF$�|kC�*j_y�E�D�O����H5���6�t�TY����b5l^)�`�v�>�1��a��r�̹�D��������@�S�>�t|���匓�z~K�,���y��Gܬ��
//                                                              yXZ�L#��c `rj睅,nX���@{7�:�qy�ʲnv�o§�@�@,�n&���I�~ǧ�z6���oe!8,T�����;җ�6�J@A��f����S]��!����2�b��+Oګ��o�<�
//                                                                                                                                                                        ����-�+et��})�KG��$���,�Z|�"

// 私钥解密数据
openssl_private_decrypt($encrypted, $decrypted, $privateKey);
var_dump($decrypted);
// string(21) "测试非对称加密"
```

在这里，我们使用的就是最标准的公钥加密，私钥解密来进行的测试。其实反过来也是可以的，OpenSSL 分别都为我们提供了公钥的加解密和私钥的加解密函数。

就像上篇文章的图示那样，对方获得我们的公钥，然后加密数据传输过来，我们通过自己的私钥解密数据获得原文。而我方也可以获得对方的公钥，并将返回的数据加密后传输给对方，然后对方使用自己的私钥进行解密获得我们传递给它的原文数据。

而 HTTPS 是通过 CA 颁发的证书来获取公钥的，浏览器通过公钥加密请求数据传输给服务器，服务器也是通过相同的原理来向浏览器客户端发送密文数据。因此，在数据传输过程中，使用 HTTPS 的传输会更加地安全，即使被截获了，对方也没有证书提供的密钥来进行解密。这就是现在所有 App 和 小程序 应用都要求使用 HTTPS 的原因，当然，我们如果做网站开发也最好使用 HTTPS ，就连百度对 HTTPS 的收录也有相应的调整。

## 签名及验证

接下来我们再接触一个签名的概念。当两端进行通信时，我们怎么知道当前传输过来的数据一定是对端发送过来的的呢，中间有没有黑客进行了篡改呢？这个就可以通过签名机制来进行验证。

```php
// 利用私钥生成签名
openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
var_dump($signature);
// ��<�~�k�٭N����M�тq��;��h�dŬ�Ğ�m�3�nj��/i���U�_�E2z���>B�N�WM!TN�c�F�/��,5�|���%��c~O)"
// ��      >��)y�fn��q��}
//                       �`
//                         �z��{��_D�s`�����|y�,g>R�D��%�
//                                                       �gͯ0�@Λ|��|z}���bZI2,����~Q_���I�LW~���G&���f�|eq�s�D���L���bC'D��~8:�Z����\�9]C�Kd~F96�S� 0��y>�(T��S}��1�謃T
//                                                                                                                                                                    �!��!!�ǈ�<�ǺfM�o7�3��������� 8ZR<Vya4����V��Wט����L�QZbv��7?�v`}��?v ǿ�0`�OF��F��@�$b�PBI�o\�v���D���"

// 公钥验证签名
$r = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA256);
var_dump($r);
// int(1)
```

我们通过 openssl_sign() 来生成一个对原始数据的私钥签名，然后就可以使用 openssl_verify() 通过公钥验证数据签名是否一致。

在使用的时候，发送方通过自己的私钥生成签名，由于签名内容是乱码的，我们可以将它 base64_encode() 一下，然后连同加密数据一起传递给接收方。然后接收方使用公钥并根据签名内容来验证原文数据是否被篡改过。

```php
// 发送方签名
$resquestSign = base64_encode($signature);

// 假设通过网络请求发送了数据
// ……
// 接收到获得签名及原始数据
// $signature = $_POST['sign'];
// openssl_private_decrypt($_POST['data'], $data, $privateKey); 

$responseSign = base64_decode($signature);
// 验证数据有没有被篡改
$r = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA256);
var_dump($r);
// int(1)

// 假设被篡改
$data = '我被修改了';
$r = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA256);
var_dump($r);
// int(0)
```

## 总结

今天的内容是不是感觉比对称加密复杂了许多。特别新引入的签名的这个概念，其实很多证书相关的内容都会和数据签名有关系。也就是说，看似简单的一个 HTTPS ，其实浏览器和服务端的 openssl 帮我们做了很多事情，远不止你去 CA 申请一套证书然后在 Nginx 配好那么简单。那么，接下来，我们将要学习的就是生成证书相关的内容了，系好安全带，车还要继续飙。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84OpenSSL%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%AD%A6%E4%B9%A0%EF%BC%88%E4%BA%8C%EF%BC%89%EF%BC%9A%E9%9D%9E%E5%AF%B9%E7%A7%B0%E5%8A%A0%E5%AF%86.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84OpenSSL%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%AD%A6%E4%B9%A0%EF%BC%88%E4%BA%8C%EF%BC%89%EF%BC%9A%E9%9D%9E%E5%AF%B9%E7%A7%B0%E5%8A%A0%E5%AF%86.php)

参考文档：

[https://www.php.net/manual/zh/function.openssl-pkey-new.php](https://www.php.net/manual/zh/function.openssl-pkey-new.php)

[https://www.php.net/manual/zh/function.openssl-pkey-get-details.php](https://www.php.net/manual/zh/function.openssl-pkey-get-details.php)

[https://www.php.net/manual/zh/function.openssl-pkey-export.php](https://www.php.net/manual/zh/function.openssl-pkey-export.php)

[https://www.php.net/manual/zh/function.openssl-public-encrypt.php](https://www.php.net/manual/zh/function.openssl-public-encrypt.php)

[https://www.php.net/manual/zh/function.openssl-private-decrypt.php](https://www.php.net/manual/zh/function.openssl-private-decrypt.php)

[https://www.php.net/manual/zh/function.openssl-sign.php](https://www.php.net/manual/zh/function.openssl-sign.php)

[https://www.php.net/manual/zh/function.openssl-verify.php](https://www.php.net/manual/zh/function.openssl-verify.php)