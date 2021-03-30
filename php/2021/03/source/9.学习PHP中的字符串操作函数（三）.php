<?php 

$arrs = explode(',', 'a,b,c,d');
print_r($arrs);
// Array
// (
//     [0] => a
//     [1] => b
//     [2] => c
//     [3] => d
// )

print_r(explode(',', 'a,b,c,d', 2));
// Array
// (
//     [0] => a
//     [1] => b,c,d
// )

echo implode('-', $arrs), PHP_EOL; // a-b-c-d

$text = "The quick brown fox jumped over the lazy dog.";
echo wordwrap($text, 20, "<br />\n"), PHP_EOL;
// The quick brown fox<br />
// jumped over the lazy<br />
// dog.


echo lcfirst('Open the door'), PHP_EOL; // open the door
echo ucfirst('open the door'), PHP_EOL; // Open the door
echo ucwords('open the door'), PHP_EOL; // Open The Door


echo levenshtein('carrot', 'carrrot'), PHP_EOL; // 1
echo levenshtein('carrot', 'banana'), PHP_EOL; // 5
echo levenshtein('carrot', 'orange'), PHP_EOL; // 6

echo similar_text('carrot', 'carrrot', $per), PHP_EOL; // 6
echo $per, PHP_EOL; // 92.307692307692
echo similar_text('carrot', 'banana', $per), PHP_EOL; // 1
echo $per, PHP_EOL; // 16.666666666667
echo similar_text('carrot', 'potato', $per), PHP_EOL; // 2
echo $per, PHP_EOL; // 33.333333333333

echo trim("  \r\n\tTest\t"), PHP_EOL; // Test

echo trim("a-Test--a", 'a'), PHP_EOL; // -Test--

echo ltrim("  \r\n\tTest\t"), PHP_EOL;
// Test	

echo rtrim("  \r\n\tTest\t"), PHP_EOL;
//  
// Test

echo number_format('12345.678'), PHP_EOL; // 12,346
echo number_format('12345.678', 1), PHP_EOL; // 12,345.7
echo number_format('12345.678', 2, ',', ' '), PHP_EOL; // 12 345,68

setlocale(LC_MONETARY, 'en_US');
echo money_format('%i', 12345.678), PHP_EOL; // USD12,345.68

setlocale(LC_MONETARY, 'zh_CN');
echo money_format('%i', 12345.678), PHP_EOL; // CNY12,345.68

setlocale(LC_MONETARY, 'de_DE');
echo money_format('%i', 12345.678), PHP_EOL; // EUR12.345,68

$str = "first=value&arr[]=foo+bar&arr[]=baz";
parse_str($str);
echo $first, PHP_EOL; // value
echo $arr[0], PHP_EOL; // foo bar
echo $arr[1], PHP_EOL; // baz

parse_str($str, $output);
print_r($output);
// Array
// (
//     [first] => value
//     [arr] => Array
//         (
//             [0] => foo bar
//             [1] => baz
//         )

// )

