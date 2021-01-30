<?php

$url = "https://www.zyblog.net?opt=dev&mail=zyblog@net.net&comments=aaa bbb ccc %dfg &==*() cdg&value=“中文也有呀，还有中文符号！！”";

echo $url, PHP_EOL;
// https://www.zyblog.net?opt=dev&mail=zyblog@net.net&comments=aaa bbb ccc %dfg &==*() cdg&value=“中文也有呀，还有中文符号！！”

$enurl = urlencode($url);
echo $enurl, PHP_EOL;
// https%3A%2F%2Fwww.zyblog.net%3Fopt%3Ddev%26mail%3Dzyblog%40net.net%26comments%3Daaa+bbb+ccc+%25dfg+%26%3D%3D%2A%28%29+cdg%26value%3D%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D

echo urldecode($enurl), PHP_EOL;
// https://www.zyblog.net?opt=dev&mail=zyblog@net.net&comments=aaa bbb ccc %dfg &==*() cdg&value=“中文也有呀，还有中文符号！！”

$rawenurl = rawurlencode($enurl);
echo $rawenurl, PHP_EOL;
// https%253A%252F%252Fwww.zyblog.net%253Fopt%253Ddev%2526mail%253Dzyblog%2540net.net%2526comments%253Daaa%2Bbbb%2Bccc%2B%2525dfg%2B%2526%253D%253D%252A%2528%2529%2Bcdg%2526value%253D%25E2%2580%259C%25E4%25B8%25AD%25E6%2596%2587%25E4%25B9%259F%25E6%259C%2589%25E5%2591%2580%25EF%25BC%258C%25E8%25BF%2598%25E6%259C%2589%25E4%25B8%25AD%25E6%2596%2587%25E7%25AC%25A6%25E5%258F%25B7%25EF%25BC%2581%25EF%25BC%2581%25E2%2580%259D

echo rawurldecode($rawenurl), PHP_EOL;
// https%3A%2F%2Fwww.zyblog.net%3Fopt%3Ddev%26mail%3Dzyblog%40net.net%26comments%3Daaa+bbb+ccc+%25dfg+%26%3D%3D%2A%28%29+cdg%26value%3D%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D

echo rawurlencode($url), PHP_EOL;
// https%3A%2F%2Fwww.zyblog.net%3Fopt%3Ddev%26mail%3Dzyblog%40net.net%26comments%3Daaa%20bbb%20ccc%20%25dfg%20%26%3D%3D%2A%28%29%20cdg%26value%3D%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D


echo rawurldecode($enurl), PHP_EOL;
// https://www.zyblog.net?opt=dev&mail=zyblog@net.net&comments=aaa+bbb+ccc+%dfg+&==*()+cdg&value=“中文也有呀，还有中文符号！！”

$base64url = base64_encode($enurl);
echo $base64url, PHP_EOL;
// aHR0cHMlM0ElMkYlMkZ3d3cuenlibG9nLm5ldCUzRm9wdCUzRGRldiUyNm1haWwlM0R6eWJsb2clNDBuZXQubmV0JTI2Y29tbWVudHMlM0RhYWErYmJiK2NjYyslMjVkZmcrJTI2JTNEJTNEJTJBJTI4JTI5K2NkZyUyNnZhbHVlJTNEJUUyJTgwJTlDJUU0JUI4JUFEJUU2JTk2JTg3JUU0JUI5JTlGJUU2JTlDJTg5JUU1JTkxJTgwJUVGJUJDJThDJUU4JUJGJTk4JUU2JTlDJTg5JUU0JUI4JUFEJUU2JTk2JTg3JUU3JUFDJUE2JUU1JThGJUI3JUVGJUJDJTgxJUVGJUJDJTgxJUUyJTgwJTlE

echo base64_decode($base64url), PHP_EOL;
// https%3A%2F%2Fwww.zyblog.net%3Fopt%3Ddev%26mail%3Dzyblog%40net.net%26comments%3Daaa+bbb+ccc+%25dfg+%26%3D%3D%2A%28%29+cdg%26value%3D%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D


$urls = parse_url($url);
var_dump($urls);
// array(3) {
//     ["scheme"]=>
//     string(5) "https"
//     ["host"]=>
//     string(14) "www.zyblog.net"
//     ["query"]=>
//     string(119) "opt=dev&mail=zyblog@net.net&comments=aaa bbb ccc %dfg &==*() cdg&value=“中文也有呀，还有中文符号！！”"
//   }

$parseTestUrl = 'http://username:password@hostname/path?arg=value#anchor';

print_r(parse_url($parseTestUrl));
// Array
// (
//     [scheme] => http
//     [host] => hostname
//     [user] => username
//     [pass] => password
//     [path] => /path
//     [query] => arg=value
//     [fragment] => anchor
// )

echo parse_url($parseTestUrl, PHP_URL_PATH); // /path

$querys = [];
parse_str($urls['query'], $querys);
var_dump($querys);
// array(4) {
//     ["opt"]=>
//     string(3) "dev"
//     ["mail"]=>
//     string(14) "zyblog@net.net"
//     ["comments"]=>
//     string(15) "aaa bbb ccc �g "
//     ["value"]=>
//     string(48) "“中文也有呀，还有中文符号！！”"
//   }

parse_str($urls['query']);
echo $value, PHP_EOL; // “中文也有呀，还有中文符号！！”

echo http_build_query($querys), PHP_EOL;
// opt=dev&mail=zyblog%40net.net&comments=aaa+bbb+ccc+%DFg+&value=%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D

echo http_build_query($querys, null, '$||$', PHP_QUERY_RFC3986), PHP_EOL;
// opt=dev$||$mail=zyblog%40net.net$||$comments=aaa%20bbb%20ccc%20%DFg%20$||$value=%E2%80%9C%E4%B8%AD%E6%96%87%E4%B9%9F%E6%9C%89%E5%91%80%EF%BC%8C%E8%BF%98%E6%9C%89%E4%B8%AD%E6%96%87%E7%AC%A6%E5%8F%B7%EF%BC%81%EF%BC%81%E2%80%9D


$url = 'https://www.sina.com.cn';

print_r(get_headers($url));
// Array
// (
//     [0] => HTTP/1.1 200 OK
//     [1] => Server: nginx
//     [2] => Date: Mon, 25 Jan 2021 02:08:35 GMT
//     [3] => Content-Type: text/html
//     [4] => Content-Length: 530418
//     [5] => Connection: close
//     [6] => Vary: Accept-Encoding
//     [7] => ETag: "600e278a-7c65e"V=5965C31
//     [8] => X-Powered-By: shci_v1.13
//     [9] => Expires: Mon, 25 Jan 2021 02:09:12 GMT
//     [10] => Cache-Control: max-age=60
//     [11] => X-Via-SSL: ssl.22.sinag1.qxg.lb.sinanode.com
//     [12] => Edge-Copy-Time: 1611540513080
//     [13] => Age: 24
//     [14] => Via: https/1.1 cmcc.guangzhou.union.82 (ApacheTrafficServer/6.2.1 [cRs f ]), https/1.1 cmcc.jiangxi.union.175 (ApacheTrafficServer/6.2.1 [cRs f ])
//     [15] => X-Via-Edge: 1611540515462770a166fee55a97524d289c7
//     [16] => X-Cache: HIT.175
//     [17] => X-Via-CDN: f=edge,s=cmcc.jiangxi.union.166.nb.sinaedge.com,c=111.22.10.119;f=edge,s=cmcc.jiangxi.union.168.nb.sinaedge.com,c=117.169.85.166;f=Edge,s=cmcc.jiangxi.union.175,c=117.169.85.168
// )

print_r(get_headers($url, 1));
// Array
// (
//     [0] => HTTP/1.1 200 OK
//     [Server] => nginx
//     [Date] => Mon, 25 Jan 2021 02:08:35 GMT
//     [Content-Type] => text/html
//     [Content-Length] => 530418
//     [Connection] => close
//     [Vary] => Accept-Encoding
//     [ETag] => "600e278a-7c65e"V=5965C31
//     [X-Powered-By] => shci_v1.13
//     [Expires] => Mon, 25 Jan 2021 02:09:12 GMT
//     [Cache-Control] => max-age=60
//     [X-Via-SSL] => ssl.22.sinag1.qxg.lb.sinanode.com
//     [Edge-Copy-Time] => 1611540513080
//     [Age] => 24
//     [Via] => https/1.1 cmcc.guangzhou.union.82 (ApacheTrafficServer/6.2.1 [cRs f ]), https/1.1 cmcc.jiangxi.union.175 (ApacheTrafficServer/6.2.1 [cRs f ])
//     [X-Via-Edge] => 1611540515593770a166fee55a97568f1a9d6
//     [X-Cache] => HIT.175
//     [X-Via-CDN] => f=edge,s=cmcc.jiangxi.union.165.nb.sinaedge.com,c=111.22.10.119;f=edge,s=cmcc.jiangxi.union.175.nb.sinaedge.com,c=117.169.85.165;f=Edge,s=cmcc.jiangxi.union.175,c=117.169.85.175
// )

var_dump(get_meta_tags($url));
// array(11) {
//     ["keywords"]=>
//     string(65) "新浪,新浪网,SINA,sina,sina.com.cn,新浪首页,门户,资讯"
//     ["description"]=>
//     string(331) "新浪网为全球用户24小时提供全面及时的中文资讯，内容覆盖国内外突发新闻事件、体坛赛事、娱乐时尚、产业资讯、实用信息等，设有新闻、体育、娱乐、财经、科技、房产、汽车等30多个内容频道，同时开设博客、视频、论坛等自由互动交流空间。"
//     ["referrer"]=>
//     string(6) "always"
//     ["stencil"]=>
//     string(10) "PGLS000022"
//     ["publishid"]=>
//     string(8) "30,131,1"
//     ["verify-v1"]=>
//     string(44) "6HtwmypggdgP1NLw7NOuQBI2TW8+CfkYCoyeB8IDbn8="
//     ["application-name"]=>
//     string(12) "新浪首页"
//     ["msapplication-tileimage"]=>
//     string(42) "//i1.sinaimg.cn/dy/deco/2013/0312/logo.png"
//     ["msapplication-tilecolor"]=>
//     string(7) "#ffbf27"
//     ["baidu_ssp_verify"]=>
//     string(32) "c0e9f36397049594fb9ac93a6316c65b"
//     ["sudameta"]=>
//     string(20) "dataid:wpcomos:96318"
//   }