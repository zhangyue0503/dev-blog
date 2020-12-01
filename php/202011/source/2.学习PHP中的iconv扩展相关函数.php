<?php
echo PHP_VERSION, PHP_EOL;
iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "ISO-8859-1");
var_dump(iconv_get_encoding());
// array(3) {
//     ["input_encoding"]=>
//     string(5) "UTF-8"
//     ["output_encoding"]=>
//     string(10) "ISO-8859-1"
//     ["internal_encoding"]=>
//     string(5) "UTF-8"
//   }



echo iconv_strlen("测试长度测试长度"), PHP_EOL; // 8
echo iconv_strlen("测试长度测试长度", 'ISO-8859-1'), PHP_EOL; // 24
echo iconv_strlen("测试长度测试长度", 'GBK'), PHP_EOL; // 12

echo '======', PHP_EOL;

echo iconv_strpos("测试长度测试长度", "长"), PHP_EOL; // 2
echo iconv_strpos("测试长度测试长度", "长", 0, 'ISO-8859-1'), PHP_EOL; // 6
echo iconv_strpos("测试长度测试长度", "长", 0, 'GBK'), PHP_EOL; // 

echo '======', PHP_EOL;

echo iconv_strrpos("测试长度测试长度", "长"), PHP_EOL; // 6
echo iconv_strrpos("测试长度测试长度", "长", 'ISO-8859-1'), PHP_EOL; // 18
echo iconv_strrpos("测试长度测试长度", "长", 'GBK'), PHP_EOL; // 

echo '======', PHP_EOL;

echo iconv_substr("测试长度测试长度", 2, 4), PHP_EOL; // 长度测试
echo iconv_substr("测试长度测试长度", 6, 12, 'ISO-8859-1'), PHP_EOL; // 长度测试
echo iconv_substr("测试长度测试长度", 3, 6, 'GBK'), PHP_EOL; // 长度测试

$phone = file_get_contents('https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=13888888888');

print_r($phone);
// __GetZoneResult_ = {
//     mts:'1388888',
//     province:'����',
//     catName:'�й��ƶ�',
//     telString:'13888888888',
//         areaVid:'30515',
//         ispVid:'3236139',
//         carrier:'�����ƶ�'
// }

print_r(iconv('GBK', 'UTF-8', $phone));
// __GetZoneResult_ = {
//     mts:'1388888',
//     province:'云南',
//     catName:'中国移动',
//     telString:'13888888888',
//         areaVid:'30515',
//         ispVid:'3236139',
//         carrier:'云南移动'
// }

print_r(iconv('GBK', 'ISO-8859-1//IGNORE', $phone));
// __GetZoneResult_ = {
//     mts:'1388888',
//     province:'',
//     catName:'',
//     telString:'13888888888',
//         areaVid:'30515',
//         ispVid:'3236139',
//         carrier:''
// }

$headers_string = <<<EOF
Subject: =?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=
To: example@example.com
Date: Thu, 1 Jan 1970 00:00:00 +0000
Message-Id: <example@example.com>
Received: from localhost (localhost [127.0.0.1]) by localhost
    with SMTP id example for <example@example.com>;
    Thu, 1 Jan 1970 00:00:00 +0000 (UTC)
    (envelope-from example-return-0000-example=example.com@example.com)
Received: (qmail 0 invoked by uid 65534); 1 Thu 2003 00:00:00 +0000

EOF;

$headers =  iconv_mime_decode_headers($headers_string, 0, "ISO-8859-1");
var_dump($headers);
// array(5) {
//     ["Subject"]=>
//     string(15) "Pr�fung Pr�fung"
//     ["To"]=>
//     string(19) "example@example.com"
//     ["Date"]=>
//     string(30) "Thu, 1 Jan 1970 00:00:00 +0000"
//     ["Message-Id"]=>
//     string(21) "<example@example.com>"
//     ["Received"]=>
//     array(2) {
//       [0]=>
//       string(204) "from localhost (localhost [127.0.0.1]) by localhost with SMTP id example for <example@example.com>; Thu, 1 Jan 1970 00:00:00 +0000 (UTC) (envelope-from example-return-0000-example=example.com@example.com)"
//       [1]=>
//       string(57) "(qmail 0 invoked by uid 65534); 1 Thu 2003 00:00:00 +0000"
//     }
//   }

$headers_string = <<<EOF
Return-Path: <bluesky7810@163.com>
Delivered-To: bhw98@sina.com
Received: (qmail 75513 invoked by alias); 20 May 2002 02:19:53 -0000
Received: from unknown (HELO bluesky) (61.155.118.135)
    by 202.106.187.143 with SMTP; 20 May 2002 02:19:53 -0000
Message-ID: <007f01c3111c$742fec00$0100007f@bluesky>
From: "=?gb2312?B?wLbAtrXEzOwNCg==?=" <bluesky7810@163.com>
To: "bhw98" <bhw98@sina.com>
Cc: <bhwang@jlonline.com>
Subject: =?gb2312?B?ztK1xLbgtK6/2rPM0PI=?=
Date: Sat, 20 May 2002 10:03:36 +0800
MIME-Version: 1.0
Content-Type: multipart/mixed;
boundary="----=_NextPart_000_007A_01C3115F.80DFC5E0"

EOF;
$headers =  iconv_mime_decode_headers($headers_string, 0, "UTF-8");
var_dump($headers);
// array(11) {
//     ["Return-Path"]=>
//     string(21) "<bluesky7810@163.com>"
//     ["Delivered-To"]=>
//     string(14) "bhw98@sina.com"
//     ["Received"]=>
//     array(2) {
//       [0]=>
//       string(58) "(qmail 75513 invoked by alias); 20 May 2002 02:19:53 -0000"
//       [1]=>
//       string(101) "from unknown (HELO bluesky) (61.155.118.135) by 202.106.187.143 with SMTP; 20 May 2002 02:19:53 -0000"
//     }
//     ["Message-ID"]=>
//     string(40) "<007f01c3111c$742fec00$0100007f@bluesky>"
//     ["From"]=>
//     string(38) ""蓝蓝的天
//   " <bluesky7810@163.com>"
//     ["To"]=>
//     string(24) ""bhw98" <bhw98@sina.com>"
//     ["Cc"]=>
//     string(21) "<bhwang@jlonline.com>"
//     ["Subject"]=>
//     string(21) "我的多串口程序"
//     ["Date"]=>
//     string(31) "Sat, 20 May 2002 10:03:36 +0800"
//     ["MIME-Version"]=>
//     string(3) "1.0"
//     ["Content-Type"]=>
//     string(16) "multipart/mixed;"
//   }

echo iconv_mime_decode("Subject: =?gb2312?B?ztK1xLbgtK6/2rPM0PI=?=", 0, 'UTF-8'), PHP_EOL; // Subject: 我的多串口程序

$preferences = array(
    "input-charset" => "UTF-8",
    "output-charset" => "GBK",
    "line-length" => 76,
    "line-break-chars" => "\n"
);
$preferences["scheme"] = "Q";
echo iconv_mime_encode("Subject", "测试头", $preferences), PHP_EOL;
// Subject: =?GBK?Q?=B2=E2=CA=D4=CD=B7?=
$preferences["scheme"] = "B";
echo iconv_mime_encode("Subject", "测试头", $preferences), PHP_EOL;
// Subject: =?GBK?B?suLK1M23?=