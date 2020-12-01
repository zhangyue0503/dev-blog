<?php

$str = "abc测试一下";

echo strlen($str), PHP_EOL; // 15
echo mb_strlen($str), PHP_EOL; // 7
echo mb_strlen($str, 'GB2312'), PHP_EOL; // 11

var_dump(mb_strpos($str, "测")); // int(3)

var_dump(mb_convert_case($str, MB_CASE_UPPER)); // string(15) "ABC测试一下"
var_dump(mb_convert_case($str, MB_CASE_LOWER)); // string(15) "abc测试一下"

var_dump(mb_substr($str, 5)); // string(6) "一下"

$str = iconv('UTF-8', 'GB2312', $str);

var_dump(preg_match("/[a-z]*测试/i", $str)); // int(0)
var_dump(preg_replace("/[a-z]*测试/i","试试", $str)); // string(11) "abc����һ��"

mb_regex_encoding('GB2312');
$pattern = iconv('UTF-8', 'GB2312', "[a-z]*测试");
var_dump(mb_ereg($pattern, $str)); // int(1)
var_dump(mb_eregi($pattern, $str)); // int(1)

var_dump(mb_ereg_replace($pattern,"试试", $str)); // string(10) "试试һ��"
var_dump(mb_eregi_replace($pattern,"试试", $str)); // string(10) "试试һ��"

mb_internal_encoding("UTF-8");

$phone = file_get_contents('https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=13888888888');

print_r($phone);
// __GetZoneResult_ = {
//     mts:'1388888',
//     province:'����',
//     catName:'�й��ƶ�',
//     telString:'13888888888',
// 	areaVid:'30515',
// 	ispVid:'3236139',
// 	carrier:'�����ƶ�'
// }

var_dump(mb_convert_encoding($phone, 'UTF-8', "GBK"));
// string(183) "__GetZoneResult_ = {
//     mts:'1388888',
//     province:'云南',
//     catName:'中国移动',
//     telString:'13888888888',
// 	areaVid:'30515',
// 	ispVid:'3236139',
// 	carrier:'云南移动'
// }
// "

echo mb_detect_encoding($phone, 'UTF-8,GBK'), PHP_EOL; // CP936

// // localhost:9991/?a=我上
var_dump(mb_http_input('GPC')); // bool(false)
var_dump(mb_http_output()); // string(5) "UTF-8"

mb_internal_encoding("CP936");
mb_parse_str($_SERVER['QUERY_STRING'], $result);
print_r($result);
// Array
// (
//     [a] => 我上
// )

var_dump(mb_language());
// string(7) "neutral"

var_dump(mb_list_encodings());
// array(86) {
//     [0]=>
//     string(4) "pass"
//     [1]=>
//     string(5) "wchar"
//     [2]=>
//     string(7) "byte2be"
//     [3]=>
//     string(7) "byte2le"
//     [4]=>
//     string(7) "byte4be"
//     [5]=>
//     string(7) "byte4le"
//     [6]=>
//     string(6) "BASE64"
//     [7]=>
//     string(8) "UUENCODE"
//     [8]=>
//     string(13) "HTML-ENTITIES"
//     [9]=>
//     string(16) "Quoted-Printable"
//     [10]=>
//     string(4) "7bit"
//     [11]=>
//     string(4) "8bit"
//     [12]=>
//     string(5) "UCS-4"
//     [13]=>
//     string(7) "UCS-4BE"
//     [14]=>
//     string(7) "UCS-4LE"
//     [15]=>
//     string(5) "UCS-2"
//     [16]=>
//     string(7) "UCS-2BE"
//     [17]=>
//     string(7) "UCS-2LE"
//     [18]=>
//     string(6) "UTF-32"
//     [19]=>
//     string(8) "UTF-32BE"
//     [20]=>
//     string(8) "UTF-32LE"
//     [21]=>
//     string(6) "UTF-16"
//     [22]=>
//     string(8) "UTF-16BE"
//     [23]=>
//     string(8) "UTF-16LE"
//     [24]=>
//     string(5) "UTF-8"
//     [25]=>
//     string(5) "UTF-7"
//     [26]=>
//     string(9) "UTF7-IMAP"
//     [27]=>
//     string(5) "ASCII"
//     [28]=>
//     string(6) "EUC-JP"
//     [29]=>
//     string(4) "SJIS"
//     [30]=>
//     string(9) "eucJP-win"
//     [31]=>
//     string(11) "EUC-JP-2004"
//     [32]=>
//     string(8) "SJIS-win"
//     [33]=>
//     string(18) "SJIS-Mobile#DOCOMO"
//     [34]=>
//     string(16) "SJIS-Mobile#KDDI"
//     [35]=>
//     string(20) "SJIS-Mobile#SOFTBANK"
//     [36]=>
//     string(8) "SJIS-mac"
//     [37]=>
//     string(9) "SJIS-2004"
//     [38]=>
//     string(19) "UTF-8-Mobile#DOCOMO"
//     [39]=>
//     string(19) "UTF-8-Mobile#KDDI-A"
//     [40]=>
//     string(19) "UTF-8-Mobile#KDDI-B"
//     [41]=>
//     string(21) "UTF-8-Mobile#SOFTBANK"
//     [42]=>
//     string(5) "CP932"
//     [43]=>
//     string(7) "CP51932"
//     [44]=>
//     string(3) "JIS"
//     [45]=>
//     string(11) "ISO-2022-JP"
//     [46]=>
//     string(14) "ISO-2022-JP-MS"
//     [47]=>
//     string(7) "GB18030"
//     [48]=>
//     string(12) "Windows-1252"
//     [49]=>
//     string(12) "Windows-1254"
//     [50]=>
//     string(10) "ISO-8859-1"
//     [51]=>
//     string(10) "ISO-8859-2"
//     [52]=>
//     string(10) "ISO-8859-3"
//     [53]=>
//     string(10) "ISO-8859-4"
//     [54]=>
//     string(10) "ISO-8859-5"
//     [55]=>
//     string(10) "ISO-8859-6"
//     [56]=>
//     string(10) "ISO-8859-7"
//     [57]=>
//     string(10) "ISO-8859-8"
//     [58]=>
//     string(10) "ISO-8859-9"
//     [59]=>
//     string(11) "ISO-8859-10"
//     [60]=>
//     string(11) "ISO-8859-13"
//     [61]=>
//     string(11) "ISO-8859-14"
//     [62]=>
//     string(11) "ISO-8859-15"
//     [63]=>
//     string(11) "ISO-8859-16"
//     [64]=>
//     string(6) "EUC-CN"
//     [65]=>
//     string(5) "CP936"
//     [66]=>
//     string(2) "HZ"
//     [67]=>
//     string(6) "EUC-TW"
//     [68]=>
//     string(5) "BIG-5"
//     [69]=>
//     string(5) "CP950"
//     [70]=>
//     string(6) "EUC-KR"
//     [71]=>
//     string(3) "UHC"
//     [72]=>
//     string(11) "ISO-2022-KR"
//     [73]=>
//     string(12) "Windows-1251"
//     [74]=>
//     string(5) "CP866"
//     [75]=>
//     string(6) "KOI8-R"
//     [76]=>
//     string(6) "KOI8-U"
//     [77]=>
//     string(9) "ArmSCII-8"
//     [78]=>
//     string(5) "CP850"
//     [79]=>
//     string(6) "JIS-ms"
//     [80]=>
//     string(16) "ISO-2022-JP-2004"
//     [81]=>
//     string(23) "ISO-2022-JP-MOBILE#KDDI"
//     [82]=>
//     string(7) "CP50220"
//     [83]=>
//     string(10) "CP50220raw"
//     [84]=>
//     string(7) "CP50221"
//     [85]=>
//     string(7) "CP50222"
//   }

var_dump(mb_get_info());
// array(14) {
//     ["internal_encoding"]=>
//     string(5) "UTF-8"
//     ["http_output"]=>
//     string(5) "UTF-8"
//     ["http_output_conv_mimetypes"]=>
//     string(31) "^(text/|application/xhtml\+xml)"
//     ["func_overload"]=>
//     int(0)
//     ["func_overload_list"]=>
//     string(11) "no overload"
//     ["mail_charset"]=>
//     string(5) "UTF-8"
//     ["mail_header_encoding"]=>
//     string(6) "BASE64"
//     ["mail_body_encoding"]=>
//     string(6) "BASE64"
//     ["illegal_chars"]=>
//     int(0)
//     ["encoding_translation"]=>
//     string(3) "Off"
//     ["language"]=>
//     string(7) "neutral"
//     ["detect_order"]=>
//     array(2) {
//       [0]=>
//       string(5) "ASCII"
//       [1]=>
//       string(5) "UTF-8"
//     }
//     ["substitute_character"]=>
//     int(63)
//     ["strict_detection"]=>
//     string(3) "Off"
//   }