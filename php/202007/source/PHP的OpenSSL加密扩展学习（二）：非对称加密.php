<?php

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



