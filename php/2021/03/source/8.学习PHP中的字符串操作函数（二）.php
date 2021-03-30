<?php

$str = "abcdefGHIjklMnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ";
$strC = "测试中文数据";


echo str_replace('abc', 'cba', $str, $count), PHP_EOL; // cbadefGHIjklMnOpQRSTUVWXYZcbadefGHIjklMnOpQRSTUVWXYZ
echo $count, PHP_EOL; // 2

echo str_replace('fgh', 'hgf', $str), PHP_EOL; // abcdefGHIjklMnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ
echo str_ireplace('fgh', 'hgf', $str), PHP_EOL; // abcdehgfIjklMnOpQRSTUVWXYZabcdehgfIjklMnOpQRSTUVWXYZ



echo str_pad('abc', 10), PHP_EOL; // abc       
echo str_pad('abc', 10, '-=', STR_PAD_LEFT), PHP_EOL; // -=-=-=-abc
echo str_pad('abc', 10, '|', STR_PAD_BOTH), PHP_EOL; // |||abc||||
echo str_pad('abc',  4, "*"), PHP_EOL; // abc*
echo str_pad('abc',  2, "*"), PHP_EOL; // abc

echo str_repeat('abc', 5), PHP_EOL; // abcabcabcabcabc

print_r(str_getcsv("a,b,c,d"));
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
//     [3] => d
// )

echo str_rot13($str), PHP_EOL; // nopqrsTUVwxyZaBcDEFGHIJKLMnopqrsTUVwxyZaBcDEFGHIJKLM

echo str_shuffle($str), PHP_EOL; // jaYpZMWIYSbpRacMenQOSGTWTekHlZcdGVVkbOXdHlXUfQnURfIj

print_r(str_split($str, 5));
// Array
// (
//     [0] => abcde
//     [1] => fGHIj
//     [2] => klMnO
//     [3] => pQRST
//     [4] => UVWXY
//     [5] => Zabcd
//     [6] => efGHI
//     [7] => jklMn
//     [8] => OpQRS
//     [9] => TUVWX
//     [10] => YZ
// )

echo str_word_count('This is a test.'), PHP_EOL; // 4
print_r(str_word_count('This is a test.', 1));
// Array
// (
//     [0] => This
//     [1] => is
//     [2] => a
//     [3] => test
// )

print_r(str_word_count('This is a test.', 2));
// Array
// (
//     [0] => This
//     [5] => is
//     [8] => a
//     [10] => test
// )


print_r(count_chars('This is a test.', 1));
// Array
// (
//     [32] => 3
//     [46] => 1
//     [84] => 1
//     [97] => 1
//     [101] => 1
//     [104] => 1
//     [105] => 2
//     [115] => 3
//     [116] => 2
// )

echo chr(84), PHP_EOL; // T
echo ord('a'), PHP_EOL; // 97

echo  chunk_split(base64_encode(str_repeat($str, 5)));
// YWJjZGVmR0hJamtsTW5PcFFSU1RVVldYWVphYmNkZWZHSElqa2xNbk9wUVJTVFVWV1hZWmFiY2Rl
// ZkdISWprbE1uT3BRUlNUVVZXWFlaYWJjZGVmR0hJamtsTW5PcFFSU1RVVldYWVphYmNkZWZHSElq
// a2xNbk9wUVJTVFVWV1hZWmFiY2RlZkdISWprbE1uT3BRUlNUVVZXWFlaYWJjZGVmR0hJamtsTW5P
// cFFSU1RVVldYWVphYmNkZWZHSElqa2xNbk9wUVJTVFVWV1hZWmFiY2RlZkdISWprbE1uT3BRUlNU
// VVZXWFlaYWJjZGVmR0hJamtsTW5PcFFSU1RVVldYWVo=


$uu = convert_uuencode($str);
echo $uu, PHP_EOL;
// M86)C9&5F1TA):FML36Y/<%%24U155E=865IA8F-D969'2$EJ:VQ-;D]P45)3
// '5%565UA96@``
// `

echo convert_uudecode($uu), PHP_EOL; // abcdefGHIjklMnOpQRSTUVWXYZabcdefGHIjklMnOpQRSTUVWXYZ


// 转义字符
echo addslashes("It's my test."), PHP_EOL; // It\'s my test.
echo addcslashes("It's my test.", 'A..z'), PHP_EOL; // \I\t'\s \m\y \t\e\s\t.








$html = htmlspecialchars("<a href='test'>Test</a>");
echo $html, PHP_EOL; // &lt;a href='test'&gt;Test&lt;/a&gt;

$html = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
echo $html, PHP_EOL; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;

echo htmlspecialchars_decode($html), PHP_EOL; // <a href=&#039;test&#039;>Test</a>
echo htmlspecialchars_decode($html, ENT_QUOTES), PHP_EOL; // <a href='test'>Test</a>

$html = htmlentities("<a href='test'>Test</a>");
echo $html, PHP_EOL; // &lt;a href='test'&gt;Test&lt;/a&gt;

$html = htmlentities("<a href='test'>Test</a>", ENT_QUOTES);
echo $html, PHP_EOL; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;

echo html_entity_decode($html), PHP_EOL; // <a href=&#039;test&#039;>Test</a>
echo html_entity_decode($html, ENT_QUOTES), PHP_EOL; // <a href='test'>Test</a>

// php5.6后中文没区别
echo htmlspecialchars("<a href='test'>测试</a>"), PHP_EOL;
echo htmlentities("<a href='test'>测试</a>"), PHP_EOL;


echo htmlspecialchars("<a href='test'>Ψ</a>"), PHP_EOL; // &lt;a href='test'&gt;Ψ&lt;/a&gt;
echo htmlentities("<a href='test'>Ψ</a>"), PHP_EOL; // &lt;a href='test'&gt;&Psi;&lt;/a&gt;

print_r(get_html_translation_table(HTML_ENTITIES));
// Array
// (
//     ["] => &quot;
//     [&] => &amp;
//     [<] => &lt;
//     [>] => &gt;
//     [ ] => &nbsp;
//     [¡] => &iexcl;
//     [¢] => &cent;
//     [£] => &pound;
//     [¤] => &curren;
//     [¥] => &yen;
//     [¦] => &brvbar;
//     [§] => &sect;
//     [¨] => &uml;
//     [©] => &copy;
//     [ª] => &ordf;
//     [«] => &laquo;
//     [¬] => &not;
//     [­] => &shy;
//     [®] => &reg;
//     [¯] => &macr;
//     [°] => &deg;
//     [±] => &plusmn;
//     [²] => &sup2;
//     [³] => &sup3;
//     [´] => &acute;
//     [µ] => &micro;
//     [¶] => &para;
//     [·] => &middot;
//     [¸] => &cedil;
//     [¹] => &sup1;
//     [º] => &ordm;
//     [»] => &raquo;
//     [¼] => &frac14;
//     [½] => &frac12;
//     [¾] => &frac34;
//     [¿] => &iquest;
//     [À] => &Agrave;
//     [Á] => &Aacute;
//     …………………………
//     …………………………
//     …………………………

print_r(get_html_translation_table(HTML_SPECIALCHARS));
// Array
// (
//     ["] => &quot;
//     [&] => &amp;
//     [<] => &lt;
//     [>] => &gt;
// )