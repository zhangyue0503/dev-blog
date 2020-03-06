<?php

// 解析 HTML
$baidu = file_get_contents('https://www.baidu.com');

$doc = new DOMDocument();
@$doc->loadHTML($baidu);

// 百度输出框
$inputSearch = $doc->getElementById('kw');
var_dump($inputSearch);

// object(DOMElement)#2 
//     ....

echo $inputSearch->getAttribute('name'), PHP_EOL; // wd

// 获取所有图片的链接
$allImageLinks = [];
$imgs = $doc->getElementsByTagName('img');
foreach($imgs as $img){
    $allImageLinks[] = $img->getAttribute('src');
}

print_r($allImageLinks);

// Array
// (
//     [0] => //www.baidu.com/img/baidu_jgylogo3.gif
//     [1] => //www.baidu.com/img/bd_logo.png
//     [2] => http://s1.bdstatic.com/r/www/cache/static/global/img/gs_237f015b.gif
// )

// 利用 parse_url 分析链接
foreach($allImageLinks as $link){
    print_r(parse_url($link));
}

// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/baidu_jgylogo3.gif
// )
// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/bd_logo.png
// )
// Array
// (
//     [scheme] => http
//     [host] => s1.bdstatic.com
//     [path] => /r/www/cache/static/global/img/gs_237f015b.gif
// )

// 生成一个XML文档
$xml = new DOMDocument('1.0', 'UTF-8');

$node1 = $xml->createElement('First', 'This is First Node.');
$node1->setAttribute('type', '1');

$node2 = $xml->createElement('Second');
$node2->setAttribute('type', '2');
$node2_child = $xml->createElement('Second-Child', 'This is Second Node Child.');
$node2->appendChild($node2_child);

$xml->appendChild($node1);
$xml->appendChild($node2);
print $xml->saveXML();

/*
<?xml version="1.0" encoding="UTF-8"?>
<First type="1">This is First Node.</First>
<Second type="2"><Second-Child>This is Second Node Child.</Second-Child></Second>
*/