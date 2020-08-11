<?php

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

// 文件 HASH

echo hash_file('md5', './create-phar.php'), PHP_EOL;
echo md5_file('./create-phar.php'), PHP_EOL;
// ba7833e3f6375c1101fb4f1d130cf3d3
// ba7833e3f6375c1101fb4f1d130cf3d3

echo hash_hmac_file('md5', './create-phar.php', 'secret'), PHP_EOL;
// 05d1f8eb7683e190340c04fc43eba9db

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

