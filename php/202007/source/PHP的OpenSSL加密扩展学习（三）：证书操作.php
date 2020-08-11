<?php
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



var_dump(openssl_x509_check_private_key($certout_string, $privkey));
// bool(true)

// var_dump(openssl_x509_verify($certout_string, $info['key']));
// bool(true)

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