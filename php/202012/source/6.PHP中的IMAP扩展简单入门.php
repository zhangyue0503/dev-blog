<?php
// yum install -y libc-client-devel libc-client
// ln -s /usr/lib64/libc-client.so /usr/lib/libc-client.a
// ln -s /usr/lib64/libkrb5.so /usr/lib/libkrb5.so

// php/ext/imap

$host = "{imap.qq.com:993/imap2/ssl}INBOX";
$username = "xxxx";   // 不用带 @qq.com
$password = "xxxxxx"; // 开通 imap 后获得的授权登录码

$mbox = imap_open($host, $username, $password);

$rowsCount = imap_num_msg($mbox);
echo $rowsCount, PHP_EOL;
// 37

$list = imap_list($mbox, "{imap.qq.com}", "*");
var_dump($list);
// array(6) {
//     [0]=>
//     string(18) "{imap.qq.com}INBOX"
//     [1]=>
//     string(26) "{imap.qq.com}Sent Messages"
//     [2]=>
//     string(19) "{imap.qq.com}Drafts"
//     [3]=>
//     string(29) "{imap.qq.com}Deleted Messages"
//     [4]=>
//     string(17) "{imap.qq.com}Junk"
//     [5]=>
//     string(51) "{imap.qq.com}&UXZO1mWHTvZZOQ-/zhangyuecoder@139.com"
//   }

$chk = (array) imap_mailboxmsginfo($mbox);
var_dump($chk);
// array(8) {
//     ["Unread"]=>
//     int(34)
//     ["Deleted"]=>
//     int(0)
//     ["Nmsgs"]=>
//     int(37)
//     ["Size"]=>
//     int(951128)
//     ["Date"]=>
//     string(37) "Wed, 16 Dec 2020 14:31:50 +0800 (CST)"
//     ["Driver"]=>
//     string(4) "imap"
//     ["Mailbox"]=>
//     string(54) "{imap.qq.com:993/imap/notls/ssl/user="149844827"}INBOX"
//     ["Recent"]=>
//     int(0)
//   }

$all = imap_search($mbox, "ALL");
var_dump($all);
// array(37) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//     [3]=>
//     int(4)
//     [4]=>
//     int(5)
// ……
// ……

foreach ($all as $m) {
    $headers = imap_fetchheader($mbox, $m);
    $rawBody = imap_fetchbody($mbox, $m, FT_UID);

    $headers = iconv_mime_decode_headers($headers, 0, "UTF-8");

    var_dump($headers);
    if (isset($headers['Content-Transfer-Encoding']) && $headers['Content-Transfer-Encoding'] == 'base64') {
        $rawBody = imap_base64($rawBody);
    }
    var_dump($rawBody);

    if ($m == 1) {
        imap_mail_copy($mbox, $m, "Drafts"); // 拷贝到草稿箱
        imap_setflag_full($mbox, $m, "Seen"); // 设置为已读
    }

    if ($m == 2) {
        imap_delete($mbox, $m); // 删除
        imap_expunge($mbox);
    }
    if ($m == 3) {
        imap_mail_move($mbox, $m, "Junk"); // 移动
        imap_expunge($mbox);
    }
}

// 第一封邮件
// headers
// array(13) {
//     ["From"]=>
//     string(29) "QQ邮箱团队 <10000@qq.com>"
//     ["To"]=>
//     string(29) "xxx <xxxxxxx@qq.com>"
//     ["Subject"]=>
//     string(53) "更安全、更高效、更强大，尽在QQ邮箱APP"
//     ["Date"]=>
//     string(31) "Wed, 16 Dec 2020 10:08:54 +0800"
//     ["Message-ID"]=>
//     string(38) "<app_popularize.1608084534.3423313103>"
//     ["X-QQ-STYLE"]=>
//     string(1) "1"
//     ["X-QQ-SYSID"]=>
//     string(9) "100000010"
//     ["X-QQ-MIME"]=>
//     string(21) "TCMime 1.0 by Tencent"
//     ["X-QQ-Mailer"]=>
//     string(10) "QQMail 2.x"
//     ["X-QQ-mid"]=>
//     string(30) "mmnez10417t1608084534tfekjqwx0"
//     ["Content-Type"]=>
//     string(26) "text/html; charset="utf-8""
//     ["Content-Transfer-Encoding"]=>
//     string(6) "base64"
//     ["Mime-Version"]=>
//     string(3) "1.0"
//   }

// rawBody
// string(5850) "
// <!DOCTYPE html>
// <html>
// <head>
//   <meta charset="UTF-8">
//   <title>imap</title>
//   <style>
//     @media screen and (min-width: 700px) {
//       .bottomErweima {
//         display: block !important;
//       }
//       #btn {
//         display: none !important;
//       }
//       .footer {
//         display: none !important;
//       }
//     }
//     /* vivo手机width: 980px 同时 aspect-ratio小于1的,处于700px-1000px的手机*/
//     @media screen and (min-width: 700px) and (max-width: 1000px) and (max-aspect-ratio:1/1){
//       .bottomErweima {
//         display: none !important;
//       }
//       #btn {
//         display: block !important;
//       }
//       .footer {
//         display: block !important;
//       }
//     }
//   </style>
// </head>
// <body style="width: 100%;margin: 0;padding: 0;position: relative;">
//   <div id="email-box" style="max-width: 550px;margin: 0 auto;">
//     <div class="email_container">
//       <div  class="head" style="background: #f3f3f3;">
//         <span class="content" style="font-size: 14px;color: #000000;line-height: 26px;display: block;padding: 40px 20px;">QQ邮箱APP，让高效触手可及。在这里，你可以登录多个邮箱账号、便捷存储微信邮件、多窗口编辑邮件......还有更多功能，等你探索！</span>
//       </div>
// ……
// ……