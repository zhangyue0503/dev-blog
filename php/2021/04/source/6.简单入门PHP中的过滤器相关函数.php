<?php



// 普通过滤
$int1 = 1;
$int2 = -1;
$int3 = "3";

$options = [
    'options' => [
        'min_range' => 0,
        'max_range' => 3,
    ],
];

var_dump(filter_var($int1, FILTER_VALIDATE_INT, $options)); // int(1)
var_dump(filter_var($int2, FILTER_VALIDATE_INT, $options)); // bool(false)
var_dump(filter_var($int3, FILTER_VALIDATE_INT, $options)); // int(3)

$email1 = 'a@b.com';
$email2 = 'a.b.com';
$email3 = '(a@b.com)';
var_dump(filter_var($email1, FILTER_VALIDATE_EMAIL)); // string(7) "a@b.com"
var_dump(filter_var($email2, FILTER_VALIDATE_EMAIL)); // bool(false)
var_dump(filter_var($email3, FILTER_VALIDATE_EMAIL)); // bool(false)

$sanitized = filter_var($email3, FILTER_SANITIZE_EMAIL);
var_dump($sanitized); // string(7) "a@b.com"

// 批量过滤
$data = [
    'product_id' => 'libgd<script>',
    'component' => '10',
    'versions' => '2.0.33',
    'testscalar' => ['2', '23', '10', '12'],
    'testarray' => '2',
];

$args = [
    'product_id' => FILTER_SANITIZE_ENCODED,
    'component' => [
        'filter' => FILTER_VALIDATE_INT,
        'flags' => FILTER_FORCE_ARRAY,
        'options' => ['min_range' => 1, 'max_range' => 10],
    ],
    'versions' => FILTER_SANITIZE_ENCODED,
    'doesnotexist' => FILTER_VALIDATE_INT,
    'testscalar' => [
        'filter' => FILTER_VALIDATE_INT,
        'flags' => FILTER_REQUIRE_SCALAR,
    ],
    'testarray' => [
        'filter' => FILTER_VALIDATE_INT,
        'flags' => FILTER_FORCE_ARRAY,
    ],

];

print_r(filter_var_array($data, $args));
// Array
// (
//     [product_id] => libgd%3Cscript%3E
//     [component] => Array
//         (
//             [0] => 10
//         )

//     [versions] => 2.0.33
//     [doesnotexist] =>
//     [testscalar] =>
//     [testarray] => Array
//         (
//             [0] => 2
//         )

// )

// 全局请求过滤

$_GET['a'] = "I'm the One!";

// php -S localhost:9991 6.一起学习PHP中的过滤器相关函数.php
// http://localhost:9991/?a=I'm the one

var_dump(filter_has_var(INPUT_GET, 'a')); // bool(true)
var_dump(filter_has_var(INPUT_GET, 'g')); // bool(false)

$queryA = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_ENCODED);

echo $queryA;

// I%27m%20the%20one

$args = [
    'a'=>FILTER_SANITIZE_ENCODED,
    'b'=>FILTER_VALIDATE_DOMAIN,
    'c'=>FILTER_VALIDATE_EMAIL,
    'd'=>[
        'filter'=>FILTER_SANITIZE_NUMBER_INT,
    ]
];
print_r(filter_input_array(INPUT_GET, $args));
// http://localhost:9991/?a=I'm the one@&b=opq.com.cn&c=ab.ab&d=foo baz 123
// Array
// (
//     [a] => I%27m%20the%20one%20%40
//     [b] => opq.com.cn
//     [c] => 
//     [d] => 123
// )

// 其它函数
print_r(filter_list());
// Array
// (
//     [0] => int
//     [1] => boolean
//     [2] => float
//     [3] => validate_regexp
//     [4] => validate_domain
//     [5] => validate_url
//     [6] => validate_email
//     [7] => validate_ip
//     [8] => validate_mac
//     [9] => string
//     [10] => stripped
//     [11] => encoded
//     [12] => special_chars
//     [13] => full_special_chars
//     [14] => unsafe_raw
//     [15] => email
//     [16] => url
//     [17] => number_int
//     [18] => number_float
//     [19] => magic_quotes
//     [20] => add_slashes
//     [21] => callback
// )

var_dump(FILTER_SANITIZE_FULL_SPECIAL_CHARS); // int(522)

foreach (filter_list() as $f) {
    echo filter_id($f), PHP_EOL;
}
// 257
// 258
// 259
// 272
// 277
// 273
// 274
// 275
// 276
// 513
// 513
// 514
// 515
// 522
// 516
// 517
// 518
// 519
// 520
// 521
// 523
// 1024
