<?php
// https://pay.weixin.qq.com/wiki/doc/api/xiaowei.php?chapter=19_11

$data = '测试加密'; // 原始数据
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES); // 加密证书的随机串,加密证书的随机串
$ad = 'fullstackpm'; // 加密证书的随机串
$kengen = sodium_crypto_aead_aes256gcm_keygen(); // 密钥

// 是否可用
echo sodium_crypto_aead_aes256gcm_is_available(), PHP_EOL;

// 加密
$pem = sodium_crypto_aead_aes256gcm_encrypt($data, $ad, $nonce, $kengen);
var_dump($pem);
// string(28) "��VRw!�����f��l�O�tV=\x�"

// 解密
$v = sodium_crypto_aead_aes256gcm_decrypt($pem, $ad, $nonce, $kengen);
var_dump($v);
// string(12) "测试加密"



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

