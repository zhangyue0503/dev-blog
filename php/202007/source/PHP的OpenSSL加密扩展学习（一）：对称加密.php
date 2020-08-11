<?php



$data = '测试对称加密';
$key = '加密用的key';
$algorithm =  'DES-EDE-CFB';


$ivlen = openssl_cipher_iv_length($algorithm);
$iv = openssl_random_pseudo_bytes($ivlen);


$password = openssl_encrypt($data, $algorithm, $key, OPENSSL_RAW_DATA, $iv);
echo $password, PHP_EOL;
// 4PvOc75QkIJ184/RULdOTeO8

echo openssl_decrypt($password, $algorithm, $key, OPENSSL_RAW_DATA, $iv), PHP_EOL;
// 测试对称加密

// Warning: openssl_encrypt(): Using an empty Initialization Vector (iv) is potentially insecure and not recommended



$algorithm =  'aes-128-gcm';
$password = openssl_encrypt($data, $algorithm, $key, 0, $iv, $tags);
echo $password, PHP_EOL;
// dPYsR+sdP56rQ99CNxciah+N

echo openssl_decrypt($password, $algorithm, $key, 0, $iv, $tags), PHP_EOL;
// 测试对称加密

print_r(openssl_get_cipher_methods());

// Array
// (
//     [0] => AES-128-CBC
//     [1] => AES-128-CBC-HMAC-SHA1
//     [2] => AES-128-CFB
//     [3] => AES-128-CFB1
//     [4] => AES-128-CFB8
//     [5] => AES-128-CTR
//     [6] => AES-128-ECB
//     [7] => AES-128-OFB
//     [8] => AES-128-XTS
//     [9] => AES-192-CBC
//     [10] => AES-192-CFB
//     [11] => AES-192-CFB1
//     [12] => AES-192-CFB8
//     ……
// )
