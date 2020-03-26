<?php
// file_get_contents进行post提交
$postdata = http_build_query(
    [
        'var1' => 'some content',
        'var2' => 'doh',
    ]
);

$opts = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata,
    ],
];

$context = stream_context_create($opts);
$result = file_get_contents('http://localhost:8088/?a=1', false, $context);
// var_dump($http_response_header);
echo $http_response_header;exit;

// 使用fopen获取响应头及内容
$url = "http://localhost:8088/?a=1";

$opts = [
    'http' => [
        'method' => 'GET',
        'max_redirects' => '0',
        'ignore_errors' => '1',
    ],
];

$context = stream_context_create($opts);
$stream = fopen($url, 'r', false, $context);

// 返回响应头
var_dump(stream_get_meta_data($stream));

// 返回内容
var_dump(stream_get_contents($stream));
fclose($stream);
