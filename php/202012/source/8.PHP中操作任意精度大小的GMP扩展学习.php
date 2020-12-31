<?php
// yum install gmp-devel

echo PHP_INT_MAX; // 92233720368547758071.2312312312312E+26

$a = 123123123123123123123123123;
echo $a, PHP_EOL; // 1.2312312312312E+26
echo $a + 1, PHP_EOL; // 1.2312312312312E+26

$b = gmp_init("123123123123123123123123123");
echo $b, PHP_EOL; // 123123123123123123123123123
echo gmp_add($b, 1), PHP_EOL; // 123123123123123123123123124

var_dump($b);
// object(GMP)#1 (1) {
//     ["num"]=>
//     string(27) "123123123123123123123123123"
//   }
echo $b + 1, PHP_EOL; // 123123123123123123123123124

echo gmp_sub($b, 1), PHP_EOL; // 123123123123123123123123122
echo gmp_mul($b, 2), PHP_EOL; // 246246246246246246246246246
echo gmp_div("123123123123123123123123123", 3), PHP_EOL; // 41041041041041041041041041
echo gmp_mod($b, 5), PHP_EOL; // 3

echo gmp_abs("-123123123123123123123123123"), PHP_EOL; // 123123123123123123123123123
echo gmp_pow($b, 3), PHP_EOL; // 1866460784838622135378351047886265184644645186267890058355382138624840786461867
echo gmp_sqrt($b), PHP_EOL; // 11096085937082

echo gmp_and($b, "2222222222"), PHP_EOL; // 2151965570
echo gmp_or($b, "2222222222"), PHP_EOL; // 123123123123123123193379775
echo gmp_xor($b, "3333333333"), PHP_EOL; // 123123123123123120012088038

echo gmp_export($b), PHP_EOL; // e�U��(c�O�

$pop1 = gmp_init("10000101", 2); // 3
echo gmp_popcount($pop1), PHP_EOL;
$pop2 = gmp_init("11111110", 2); // 7
echo gmp_popcount($pop2), PHP_EOL;


$s1 = gmp_init("10111", 2);
echo gmp_scan0($s1, 0), PHP_EOL; // 3

$s2 = gmp_init("101110000", 2);
echo gmp_scan0($s2, 0), PHP_EOL; // 0

$s1 = gmp_init("10111", 2);
echo gmp_scan1($s1, 0), PHP_EOL; // 0

$s2 = gmp_init("101110000", 2);
echo gmp_scan1($s2, 0), PHP_EOL; // 4

echo gmp_random_range("10000000000000", "99999999999999999"), PHP_EOL; // 83490559526159213
// 12500000000
echo gmp_random_bits(99999),PHP_EOL; // 289814632948807684404778811091812938699609………………

echo gmp_fact(5), PHP_EOL; // 120
echo gmp_fact(50), PHP_EOL; // 30414093201713378043612608166064768844377641568960512000000000000


echo gmp_nextprime(10), PHP_EOL; // 11
echo gmp_nextprime(1000), PHP_EOL; // 1009
echo gmp_prob_prime(6), PHP_EOL; // 0
echo gmp_prob_prime("1111111111111111111"), PHP_EOL; // 1
echo gmp_prob_prime(7), PHP_EOL; // 2



echo gmp_sign("500"), PHP_EOL; // 1
echo gmp_sign("-500"), PHP_EOL; // -1
echo gmp_sign("0"), PHP_EOL; // 0