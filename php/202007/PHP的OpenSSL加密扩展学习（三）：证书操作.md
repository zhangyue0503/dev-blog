# PHP的OpenSSL加密扩展学习（三）：证书操作

关于对称和非对称的加密操作，我们已经学习完两篇文章的内容了，接下来，我们就继续学习关于证书的生成。

## 生成 CSR 证书签名请求

CSR 是用于生成证书的签名请求，在 CSR 中，我们需要一些 dn 信息。其实也就是当前这个证书的服务对象，包含公司名、邮箱之类的内容。

```php
$privkey = openssl_pkey_new([
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
]);

$dn = [
    "countryName" => "CN", // 国家
    "stateOrProvinceName" => "Hunan", // 省
    "localityName" => "Changsha", // 市
    "organizationName" => "zyblog", // 公司单位名称
    "organizationalUnitName" => "zyblog", // 公司单位名称
    "commonName" => "zyblog.xxx", // 公用名称，一般可以填域名
    "emailAddress" => "zy@zyblog.xxx" // 邮箱地址
];

$csr = openssl_csr_new($dn, $privkey, ['digest_alg' => 'sha256']);

openssl_csr_export($csr, $csr_string);

var_dump($csr_string);
// string(1102) "-----BEGIN CERTIFICATE REQUEST-----
// MIIC9DCCAdwCAQAwga4xCzAJBgNVBAYTAkdCMREwDwYDVQQIDAhTb21lcnNldDEU
// MBIGA1UEBwwLR2xhc3RvbmJ1cnkxHzAdBgNVBAoMFlRoZSBCcmFpbiBSb29tIExp
// bWl0ZWQxHzAdBgNVBAsMFlBIUCBEb2N1bWVudGF0aW9uIFRlYW0xFDASBgNVBAMM
// C1dleiBGdXJsb25nMR4wHAYJKoZIhvcNAQkBFg93ZXpAZXhhbXBsZS5jb20wggEi
// MA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCh+kxDtR7+YMOCJP+s77YJmbt2
// AigtVnoy3iOj+JvP3VXCU9dIehw4deT/TBpmlpxVWPfhZF2VmpoCZNhNWFbv+6sz
// tMPhALoconSHABh+5K5UvVRGfm7Zv+0wts/8l/ZXz/pL9wpB0bCpuSXb2CjY+CkN
// hM5AYc53PHPOYU5ZC1B+z96a7gsNE+6A9qJSFRPAKWIR8QlX1ewPe23EmY2yscSC
// 6bqVkq1BFBuezim+pstWU0AQYASgSzTEtBBD4h4PHo82BmFfhHlWPWU3BZTUL8u1
// 4JJ2MBsK1F/G047EckPhrHDO9zwp6mFf5KPNr6oIwAyzvw8K8CdazpFeX863AgMB
// AAGgADANBgkqhkiG9w0BAQsFAAOCAQEALFZB3Jcc7dkt5yGPhjsxct/qyGcLJl4V
// rS1uDhHSI49FUauJOKoVnuSHblMkrWaWUr5PmETf6kVYZ8uZdiuXcswDF5Ax8CTc
// uRy+3kGB3Oswm/35RyiKV2oi1LHLhGXaiKdZvNl41wOqNobFAYPbTXWSkcbpmw+1
// KfEsmMwpYGYXX/zC1CzHf2t7OsPhsAyvDW5EqYhaKn+oNXFiL22pQDzM1MM8xwhB
// akpqZPHGIpJDUdoI3o8CSIlRI2BxWGcDTUh2OViOroS8O6gAmmD7uvmMOnNwiZIN
// 90FkKMpYyEsfo+Bj8DL0RjLpUDhYLJOXf0rs+yMkrU4FW2naiaWnbg==
// -----END CERTIFICATE REQUEST-----
// "

$public_key = openssl_csr_get_public_key($csr);
$info = openssl_pkey_get_details($public_key);
var_dump($info['key']);
// string(451) "-----BEGIN PUBLIC KEY-----
// MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvDBrEHxkWucb/YQlzccO
// bbgzlTficOAglSEDPBybnWXGfQRiqRij/QGyCPGVH9Ex7UTogsOp67+Jj0h8ikCD
// rCeomRfM7U95NBXrJJdELZFf6twXNBBNB4d8PL96LIatSGpjCDbBXemuIVi2T7Rl
// i6towHxNjQuSILnUadMceGsehB9Ao699rAqRtmrnyPbcAACbpZq50haYTl62gtuu
// hOPHlDpGlWIEaj7hHzBsI3kMky0Fo35TLini2pDPSZhdIyJucDJNw5MMjcky9FWx
// cvje1cx+rQtk1ez41nda9YkDlFIEQjS2X3YVTqSrxPZbfYG4Vavp2yZe2Pz6rw5W
// mQIDAQAB
// -----END PUBLIC KEY-----
// "
```

使用 openssl_csr_new() 通过私钥来生成 CSR 句柄，然后通过 openssl_csr_export() 抽取证书请求内容。可以看出，在 CSR 中是包含公钥信息的，因为我们可以通过 openssl_csr_get_public_key() 和 openssl_pkey_get_details() 来抽取公钥。

当然，我们也可以通过一个函数来获取 CSR 中的 dn 信息，这个函数也是可以获得外部下载的 CSR 中的信息的。

```php
print_r(openssl_csr_get_subject($csr));
// Array
// (
//     [C] => CN
//     [ST] => Hunan
//     [L] => Changsha
//     [O] => zyblog
//     [OU] => zyblog
//     [CN] => zyblog.xxx
//     [emailAddress] => zy@zyblog.xxx
// )
```

## 证书签名及生成 x509 证书

x509 是标准的公钥证书规范，并且只包含公钥信息。

```php
$usercert = openssl_csr_sign($csr, NULL, $privkey, 365, array('digest_alg'=>'sha256'));

// 证书签名，返回 x509 证书资源
openssl_x509_export($usercert, $certout_string);
var_dump($certout_string);
// string(1391) "-----BEGIN CERTIFICATE-----
// MIID1zCCAr+gAwIBAgIBADANBgkqhkiG9w0BAQsFADCBhTELMAkGA1UEBhMCQ04x
// DjAMBgNVBAgMBUh1bmFuMREwDwYDVQQHDAhDaGFuZ3NoYTEPMA0GA1UECgwGenli
// bG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzARBgNVBAMMCnp5YmxvZy54eHgxHDAaBgkq
// hkiG9w0BCQEWDXp5QHp5YmxvZy54eHgwHhcNMjAwODAzMDMxNDMyWhcNMjEwODAz
// MDMxNDMyWjCBhTELMAkGA1UEBhMCQ04xDjAMBgNVBAgMBUh1bmFuMREwDwYDVQQH
// DAhDaGFuZ3NoYTEPMA0GA1UECgwGenlibG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzAR
// BgNVBAMMCnp5YmxvZy54eHgxHDAaBgkqhkiG9w0BCQEWDXp5QHp5YmxvZy54eHgw
// ggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCpHxkrDFpO6Nl6BlP/ia4W
// KX90bPYcR7JTdtFUm6zvz/YMVFPogJ0SVFR0B8H2ZG1f/HZW8hi1SspjhUsBR4Bc
// wJ4LTh49qMENiiRPicmvHnYZIojedBw2E8TrQMW/08c5W76dU1EdRJX+MOmlRG4a
// bwcHC607PfKSmHlFirR7URt5lSe5fT6nBzBr1nlrqcGhhDncZGI6/xbOt3Lpc3Ql
// yCyJqPGCNdeugkKCdGDobghP9RqfjhrJwQiV9lFGx4AuopgTw1B55CeS0fOnObgA
// 6JQ8bujKp9Ng1ySUpHIu753dnxN/m1/VLHDqbsfPsfwnBmEbrspETio+s8BYuDcn
// AgMBAAGjUDBOMB0GA1UdDgQWBBTor00GqjgVXyuXrRLutraLRw+eYzAfBgNVHSME
// GDAWgBTor00GqjgVXyuXrRLutraLRw+eYzAMBgNVHRMEBTADAQH/MA0GCSqGSIb3
// DQEBCwUAA4IBAQAcOZYmM14yTBSgIM5MbKI4xlp8/pxsvU08937hv6B0J5Ug2Lgn
// Q3hog7+6XMZGAiN9imZZUdl+TOGjG7apz7YXv3cRsguhHn3tn74GzbaySAwyn5eC
// sbHkoYlVui4HNkxS1ddttYnCrnLLfSZ+3N3mWOmzvkcDe/XvTVlmIFHVvA0BiewL
// y/b9RFyraq41CSDRQ9OKgVZfkYnNA7Xm/pHjyQfRVm43D3WK5mCIEdkFA+G1BHXh
// sJ30M6IR02Sg4bIe6GPvUBhcTzR4BZdQM7RMFJGrSQwtahohwB8ZwCXOJKsgoL7m
// 6e5YOL0deuZDTNWfoq3hOwnPfisNsL9v0moy
// -----END CERTIFICATE-----
// "
```

通过 openssl_csr_sign() 这个函数，为 CSR 进行签名后获得的就是 x509 规范的一个证书内容。在这个证书中是可以提取出公钥信息的，我们可以将这个证书颁发给用户或者客户端，然后由客户端从证书中抽取公钥信息来进行数据加密。

```php
var_dump(openssl_x509_check_private_key($certout_string, $privkey));
// bool(true)

// var_dump(openssl_x509_verify($certout_string, $info['key']));
// bool(true)
```

当然，我们也可以验证当前的 x509 证书内容和我们的私钥是否匹配。下面的 openssl_x509_verify() 是 PHP7.4 以后才支持的函数。

## pkcs 证书操作

最后，我们来看一下 pkcs 签名证书。pkcs 分为 pkcs7 和 pkcs12 两种，pkcs7 一般用于数字信封加密，可以往里面添加 x509 ，会生成 PEM 和 DER 两种编码方式，一般我们会使用 PEM ，它其实包含的就是公钥信息。

pkcs12 一般导出的就是 PFX 文件，pkcs12 还需要另外添加一个证书密码，所以 pkcs12 是可以包含私钥的。它一般用于消息交换与打包语法。

```php
openssl_pkcs12_export ($usercert,$pkcs_string, $privkey, '123123' );
var_dump($pkcs_string);
// string(2585) "0�
// 0�p0�l0�e�      *�H��   �0�     *�H��
// *�H��
// g�ʙݔ��8���|�D��v.D��7�i@���     4�߹����
//                                        �`��xd�Wؿhݐ�6Y   3�_F�h�\�3,H{�ȁ+��L��lo1�-���I>i�
//                                                                                          ��Ahۈ��IY
// ~�3���Pƶ#v4��1����[0W|  �V<��hqh�?Q���^�K       ���


openssl_pkcs12_read($pkcs_string, $certs, '123123');
var_dump($certs);
// array(2) {
//     ["cert"]=>
//     string(1391) "-----BEGIN CERTIFICATE-----
//   MIID1zCCAr+gAwIBAgIBADANBgkqhkiG9w0BAQsFADCBhTELMAkGA1UEBhMCQ04x
//   DjAMBgNVBAgMBUh1bmFuMREwDwYDVQQHDAhDaGFuZ3NoYTEPMA0GA1UECgwGenli
//   bG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzARBgNVBAMMCnp5YmxvZy54eHgxHDAaBgkq
//   hkiG9w0BCQEWDXp5QHp5YmxvZy54eHgwHhcNMjAwODAzMDcwOTE2WhcNMjEwODAz
//   MDcwOTE2WjCBhTELMAkGA1UEBhMCQ04xDjAMBgNVBAgMBUh1bmFuMREwDwYDVQQH
//   DAhDaGFuZ3NoYTEPMA0GA1UECgwGenlibG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzAR
//   BgNVBAMMCnp5YmxvZy54eHgxHDAaBgkqhkiG9w0BCQEWDXp5QHp5YmxvZy54eHgw
//   ggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCrbNHa2lFTBMwwzO0roPBL
//   ugmNa7Yij6zsIPYIdIm3x5oFCaZKsnMrynlZGZquEjs6ZXVVALB3tTKxwefIjl5P
//   FJ4Iw1dUbYTk324Cu+ZCZ8wo2LegcxXq95uyRzRvMwr1gxicWxUhNuoZ6mavHnU0
//   hiDR7w9FaZM3Pj1LPNW7fJKyr4vIF8sHH+ebS0+bZAps4Zqw9ey+llnHQYZYhbF8
//   Crf7Gh7Phg/86h3Ozbe1vwOfKZetf7+1vzwqI4y6ATwOoiqcxMegn8m5hoDlUqov
//   T/GwaRTUwUg37XUlEYvVuLtvTlwuSXL9WUkvvkWB1EbimNPsET4ZZMykcUWd+BMr
//   AgMBAAGjUDBOMB0GA1UdDgQWBBSRShEEnJT8VYskN7l8HkBT3whS8jAfBgNVHSME
//   GDAWgBSRShEEnJT8VYskN7l8HkBT3whS8jAMBgNVHRMEBTADAQH/MA0GCSqGSIb3
//   DQEBCwUAA4IBAQASAIhSQrXMnKVR+m7KXFhrqvVemUwnI6+v0trsBpFqgORVJehM
//   NSQ7Du+6z0RWdL7puQN5OeTZmFRDS16RrrBc30Y/hv/Zv8e2/YSmqIoQY0SIWdLu
//   NaEbINLpeUMUTz3LXCRAzOv1JecGD2Jz18Gia/W/N+1b/H0EP7ZmL0/WTlmjCejf
//   ncr9o6wkB+STtZervPUbSOBF3Pq4dxEKE/G0E8Qk6oyMBR76DUJwutCwoSrd6F68
//   xEGjmrBHgPqNJqy28cbCh1enEnPORec0ZJBuQ3Vqv5MQRNmqikpqDak6nHLGOQu+
//   //IJ5JICwm29xnOCKpyohbEg4KFg4shBY66y
//   -----END CERTIFICATE-----
//   "
//     ["pkey"]=>
//     string(1704) "-----BEGIN PRIVATE KEY-----
//   MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCrbNHa2lFTBMww
//   zO0roPBLugmNa7Yij6zsIPYIdIm3x5oFCaZKsnMrynlZGZquEjs6ZXVVALB3tTKx
//   wefIjl5PFJ4Iw1dUbYTk324Cu+ZCZ8wo2LegcxXq95uyRzRvMwr1gxicWxUhNuoZ
//   6mavHnU0hiDR7w9FaZM3Pj1LPNW7fJKyr4vIF8sHH+ebS0+bZAps4Zqw9ey+llnH
//   QYZYhbF8Crf7Gh7Phg/86h3Ozbe1vwOfKZetf7+1vzwqI4y6ATwOoiqcxMegn8m5
//   hoDlUqovT/GwaRTUwUg37XUlEYvVuLtvTlwuSXL9WUkvvkWB1EbimNPsET4ZZMyk
//   cUWd+BMrAgMBAAECggEAPbsCFv1nK64embQx8/QQlDR6HCMdg3SZoK596q2MqlGG
//   dSn0aBG6x5ox+JPvz59hFLZUeje1VGY7yyc4gFBERdX20tEFMbH+mSycQP/I+0DF
//   lC/2cCEBU4u21YwupZyL5b0/r45dHYjY5Fw0fftJ2ZAzYWXk6eoKyWnwSJevn8O1
//   GYLBR3dHsbXp7L1SEMVbPzJ/IbR4AQYZetSbVbp/3Vow2WbMJtwQtFt0/gRJyQ67
//   wnjAcZ1Duej2ol8bi1+vG1tTh7YYNrO0zzwlXKib2vBxpUjk++4Y5lVEd+GynWAv
//   zRE6uBw0mmA7dWesld/Ns9eIxxg1SHqIWccmSXzTAQKBgQDf+Cn8AOEcW/oK/o/8
//   AIh2OSm2/Xi4BwFrcU8DfZKSP+7aexS3MUDnQAUnE91YcHjNPxs7G6s9rA6WCO7N
//   cAKGiWqn18IE9ZKv6iuz9VhOm8tlYc2iZvUnxYT99rt0vQYmjfjFJY7KeqYE+oJg
//   4nc6+XVlrtA2ql8FXHH+JzxsSQKBgQDD8O8kaFt8aZGEEXVlJ7UXiXspbSiTxJ6J
//   UGoG0mHKzL+NGmftHFvQN9DnLkFW9/KtmO9DSoWncuckAsVYQTH4DCIAZMEn41Qi
//   oS1zoeX1fCCdbWLtxvkzJKxiNhRe9cgiL/IOV3Mv/S5Bt4sDt1qT8RC5DucqI1pK
//   90wqTIY70wKBgQCWg8VbWQ/vqhRJDTigR49tvA6/rmpRakvW8+gA1YQKCzMu2uZa
//   EpymjEyqLVxkkfltHcrkFz0mjhmjVM9/epYH6hOmRoZaJNr2o+3I28oD0gmH0YmL
//   aZu5pbExp33k/x9CC8kyXIIwquolkGDMUYWFOZ5evnOpOSfwh2cIQUAHGQKBgQCX
//   Ko1E+GIEdOm4C0QXu2+h7gYf6sBQaHOrGmgCRVL/A8GQWdvt+V/4HufDQ1NThk0q
//   kv+cWaUNj781cBHSSdIEPVAKH7FJVb/2S4TmXfQs1QvQiLC3IzfkthlsV66VqGcz
//   wOutFtieIGUMfE76mf1+f4/YReAgCVBC39FaHNm+0wKBgANeWcdh2atSMIliyCXG
//   v0nZ7o4ffj+epAXocW1kmdOmUy154swsEdzUwWatj1//OU5S0O/HzeTTn4YbYhR2
//   einGRvz5POin3L7enePSescV4ooUESB5mLwNmqANu94uYHuVNyMwolsIOgkkLxNm
//   HtCaz0u0MZLJY6R6pAtT5KpN
//   -----END PRIVATE KEY-----
//   "
//   }

openssl_x509_export($certs['cert'], $certout_string);
var_dump($certout_string);
// string(1391) "-----BEGIN CERTIFICATE-----
// MIID1zCCAr+gAwIBAgIBADANBgkqhkiG9w0BAQsFADCBhTELMAkGA1UEBhMCQ04x
// DjAMBgNVBAgMBUh1bmFuMREwDwYDVQQHDAhDaGFuZ3NoYTEPMA0GA1UECgwGenli
// bG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzARBgNVBAMMCnp5YmxvZy54eHgxHDAaBgkq
// hkiG9w0BCQEWDXp5QHp5YmxvZy54eHgwHhcNMjAwODAzMDcwOTE2WhcNMjEwODAz
// MDcwOTE2WjCBhTELMAkGA1UEBhMCQ04xDjAMBgNVBAgMBUh1bmFuMREwDwYDVQQH
// DAhDaGFuZ3NoYTEPMA0GA1UECgwGenlibG9nMQ8wDQYDVQQLDAZ6eWJsb2cxEzAR
// BgNVBAMMCnp5YmxvZy54eHgxHDAaBgkqhkiG9w0BCQEWDXp5QHp5YmxvZy54eHgw
// ggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCrbNHa2lFTBMwwzO0roPBL
// ugmNa7Yij6zsIPYIdIm3x5oFCaZKsnMrynlZGZquEjs6ZXVVALB3tTKxwefIjl5P
// FJ4Iw1dUbYTk324Cu+ZCZ8wo2LegcxXq95uyRzRvMwr1gxicWxUhNuoZ6mavHnU0
// hiDR7w9FaZM3Pj1LPNW7fJKyr4vIF8sHH+ebS0+bZAps4Zqw9ey+llnHQYZYhbF8
// Crf7Gh7Phg/86h3Ozbe1vwOfKZetf7+1vzwqI4y6ATwOoiqcxMegn8m5hoDlUqov
// T/GwaRTUwUg37XUlEYvVuLtvTlwuSXL9WUkvvkWB1EbimNPsET4ZZMykcUWd+BMr
// AgMBAAGjUDBOMB0GA1UdDgQWBBSRShEEnJT8VYskN7l8HkBT3whS8jAfBgNVHSME
// GDAWgBSRShEEnJT8VYskN7l8HkBT3whS8jAMBgNVHRMEBTADAQH/MA0GCSqGSIb3
// DQEBCwUAA4IBAQASAIhSQrXMnKVR+m7KXFhrqvVemUwnI6+v0trsBpFqgORVJehM
// NSQ7Du+6z0RWdL7puQN5OeTZmFRDS16RrrBc30Y/hv/Zv8e2/YSmqIoQY0SIWdLu
// NaEbINLpeUMUTz3LXCRAzOv1JecGD2Jz18Gia/W/N+1b/H0EP7ZmL0/WTlmjCejf
// ncr9o6wkB+STtZervPUbSOBF3Pq4dxEKE/G0E8Qk6oyMBR76DUJwutCwoSrd6F68
// xEGjmrBHgPqNJqy28cbCh1enEnPORec0ZJBuQ3Vqv5MQRNmqikpqDak6nHLGOQu+
// //IJ5JICwm29xnOCKpyohbEg4KFg4shBY66y
// -----END CERTIFICATE-----

var_dump(openssl_x509_check_private_key($certout_string, $privkey));
// bool(true)
```

在这里的测试我们就是简单地通过 openssl_pkcs12_export() 来导出一个 pkcs12 证书，可以看到这个函数包含了 CSR 、私钥 和一个自定义的证书密码。导出的内容是二进制的内容，我们可以直接将这些内容保存为一个 PFX 文件。

通过 openssl_pkcs12_read() 就可以读取一个 PFX 文件内容，获得证书的 certs 信息，也就是 CSR 信息。可以看到我们用 openssl_x509_export() 导出后的结果中的私钥与我们最开始创建的是私钥是匹配的。

## 总结

关于证书的内容还有不少函数没有讲到，不过我们通过上面这些代码已经可以生成一些简单的证书了。并且也可以读取不少证书的内容并获得它们的信息。本身加密这一块就是一门非常高深的学科，有兴趣的同学可以继续深入地研究。上面提到的 CSR 、 x509 、 pkcs 相关的内容以及生成的文件在许多地方都可以见到，比如 HTTPS 申请成功后下载的证书，微信、支付宝相关第三方接口等。大家可以自己尝试读取解析这些证书，这样动手才能对相关的知识有更深入地了解。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84OpenSSL%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%AD%A6%E4%B9%A0%EF%BC%88%E4%B8%89%EF%BC%89%EF%BC%9A%E8%AF%81%E4%B9%A6%E6%93%8D%E4%BD%9C.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E7%9A%84OpenSSL%E5%8A%A0%E5%AF%86%E6%89%A9%E5%B1%95%E5%AD%A6%E4%B9%A0%EF%BC%88%E4%B8%89%EF%BC%89%EF%BC%9A%E8%AF%81%E4%B9%A6%E6%93%8D%E4%BD%9C.php)

参考文档：

[https://www.php.net/manual/zh/book.openssl.php](https://www.php.net/manual/zh/book.openssl.php)

[https://www.cnblogs.com/jinxiblog/p/7905315.html](https://www.cnblogs.com/jinxiblog/p/7905315.html)