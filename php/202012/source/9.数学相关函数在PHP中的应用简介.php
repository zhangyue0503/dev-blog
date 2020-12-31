<?php

// 常见数学函数
var_dump(abs(-12)); // int(12)
var_dump(abs("-12.22")); // float(12.22)

var_dump(ceil(2)); // float(2)
var_dump(ceil(2.1)); // float(3)
var_dump(ceil(2.9)); // float(3)
var_dump(ceil(-2.9)); // float(-2)

var_dump(floor(2)); // float(2)
var_dump(floor(2.1)); // float(2)
var_dump(floor(2.9)); // float(2)
var_dump(floor(-2.9)); // float(-3)

var_dump(fmod(5.7, 1.3)); // float(0.5)
var_dump(fmod(6, 3)); // float(0)

var_dump(pow(2, 5)); // int(32)
var_dump(sqrt(9)); // float(3)
var_dump(sqrt(10)); // float(3.1622776601684)

var_dump(max(10, 20, 39, 25)); // int(39)
var_dump(min(5, 3, 1, 9, 8)); // int(1)

var_dump(max([10, 20, 39, 25])); // int(39)
var_dump(min(...[5, 3, 1, 9, 8])); // int(1)

var_dump(M_SQRT2); // float(1.4142135623731)
var_dump(M_SQRT3); // float(1.7320508075689)
var_dump(M_SQRT1_2); // float(0.70710678118655)

var_dump(is_finite(M_PI)); // bool(true)
var_dump(is_infinite(M_PI)); // bool(false)
var_dump(is_finite(M_EULER)); // bool(true)

// 派

var_dump(M_PI); // float(3.1415926535898)
var_dump(pi()); // float(3.1415926535898)

var_dump(M_PI_2); // float(1.5707963267949)
var_dump(M_PI_4); // float(0.78539816339745)
var_dump(M_1_PI); // float(0.31830988618379)
var_dump(M_2_PI); // float(0.63661977236758)
var_dump(M_SQRTPI); // float(1.7724538509055)
var_dump(M_2_SQRTPI); // float(1.1283791670955)
var_dump(M_LNPI); // float(1.1447298858494)

// 对数

var_dump(log(32)); // float(3.4657359027997)
var_dump(log(32, 2)); // 5

var_dump(log10(1000)); // float(3)

var_dump(log1p(31)); // float(3.4657359027997)

var_dump(exp(12)); // float(162753.791419)

var_dump(M_E); // float(2.718281828459)
var_dump(M_LOG2E); // float(1.442695040889)
var_dump(M_LOG10E); // float(0.43429448190325)
var_dump(M_LN2); // float(0.69314718055995)
var_dump(M_LN10); // float(2.302585092994)

// 随机数
var_dump(getrandmax()); // int(2147483647)

var_dump(rand());
var_dump(rand(5, 15));

var_dump(mt_getrandmax()); // int(2147483647)
var_dump(mt_rand());
var_dump(mt_rand(5, 15));

// 三角函数

var_dump(hypot(3, 4)); // float(5)
var_dump(hypot(5, 12)); // float(13)

var_dump(sin(M_PI_2)); // float(1)
var_dump(cos(M_PI_2)); // float(6.1232339957368E-17)
var_dump(tan(M_PI_2)); // float(1.6331239353195E+16)

var_dump(sin(deg2rad(90))); // float(1)

var_dump(asin(sin(M_PI_2))); // float(1.5707963267949)
var_dump(acos(cos(M_PI_2))); // float(1.5707963267949)
var_dump(atan(tan(M_PI_2))); // float(1.5707963267949)

var_dump(sinh(sin(M_PI_2))); // float(1.1752011936438)
var_dump(cosh(cos(M_PI_2))); // float(1)
var_dump(tanh(tan(M_PI_2))); //float(1)

var_dump(asinh(sin(M_PI_2))); // float(0.88137358701954)
var_dump(acosh(cos(M_PI_2))); // float(NAN)
var_dump(atanh(tan(M_PI_2))); // float(NAN)

var_dump(atanh(tan(M_PI_2)) == atanh(tan(M_PI_2))); // bool(false)
var_dump(atanh(tan(M_PI_2)) === atanh(tan(M_PI_2))); // bool(false)

var_dump(NAN == NAN); // bool(false)
var_dump(NAN === NAN); // bool(false)

$v = json_encode([
    'test' => NAN,
]);
echo $v, PHP_EOL; //
echo json_last_error_msg(); // Inf and NaN cannot be JSON encodedbool(true)

var_dump(is_nan(atanh(tan(M_PI_2)))); // bool(true)
var_dump(is_nan(NAN)); // bool(true)

// 进制转换

var_dump(bindec("11")); // int(3)
var_dump(bindec("110011")); // int(51)

var_dump(hexdec("FF")); // int(255)
var_dump(hexdec("A37334")); // int(10711860)

var_dump(octdec('77')); // int(63)

var_dump(decbin(51)); // string(6) "110011"
var_dump(dechex(255)); // string(2) "ff"
var_dump(decoct(63)); // string(2) "77"

var_dump(base_convert("A37334", 16, 10)); // string(8) "10711860"
var_dump(base_convert("A37334", 16, 2)); // string(24) "101000110111001100110100"
