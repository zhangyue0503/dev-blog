<?php

print_r(password_algos());
// Array
// (
//     [0] => 2y
// )

echo password_hash("this is password", PASSWORD_DEFAULT), PHP_EOL;
// $2y$10$vOI56sADJPhebhzq5Bj1quM7grMex3Y4NlI99C3qP83iveEGnfdd.

$options = [
    'cost' => 12,
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options), PHP_EOL;
// $2y$12$YjEdiCJHAmPCoidNvgrZq.k4VH3ShoELWlyU9POHD5sV3L1WW4.vS

$options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);
// $2y$11$syLcOhq1Mfc32cWVi1zyLOvSn.AtcCre.kY999uUXZ6pS3nXNv1lmPHP

$p = password_hash('this is password', PASSWORD_DEFAULT, $options);
print_r(password_get_info($p));
// Array
// (
//     [algo] => 2y
//     [algoName] => bcrypt
//     [options] => Array
//         (
//             [cost] => 11
//         )

// )

var_dump(password_needs_rehash($p, PASSWORD_DEFAULT, $options)); // bool(false)
var_dump(password_needs_rehash($p, PASSWORD_DEFAULT, ['cost'=>5])); // bool(true)


var_dump(password_verify('this is password', $p)); // bool(true)
var_dump(password_verify('1this is password', $p)); // bool(false)