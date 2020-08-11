<?php

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

// OpenPGP 指定的 Salted S2K 算法
$hashPassword = mhash_keygen_s2k(MHASH_SHA1, '我的密码', random_bytes(2), 4);
echo $hashPassword, PHP_EOL;
echo bin2hex($hashPassword), PHP_EOL;
// �-!=
// 101ab899