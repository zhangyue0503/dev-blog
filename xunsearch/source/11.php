<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");
$search = $xs->search;

if ($argv[1] == 1){
    
    
    $search->setQuery('敏捷')->search();

    $search->search('敏捷');
    print_r($search->lastCount); // 37

    $search->search('算法');
    print_r($search->lastCount); // 63

    $search->setQuery('敏捷')->search('算法');
    print_r($search->lastCount); // 63

    print_r($search->setQuery('敏捷')->setLimit(1000)->search('算法'));
    // ……………………
    print_r($search->setLimit(1000)->search());
    // exit;

    print_r($search->setLimit(2)->search(''));
    print_r($search->setLimit(1,1)->search(''));

    print_r($search->count()); // 37
    print_r($search->count('算法')); // 63
    print_r($search->count()); // 37

    $search->setQuery('算法');
    print_r($search->count()); // 63

    print_r($search->dbTotal); // 339

    
}else if ($argv[1] == 2){
    // 高亮
    $doc = $search->setLimit(1)->search('数据结构与算法')[0];
    echo $search->highlight($doc->title);
    // PHP<em><em>数据</em><em>结构</em></em><em>与</em><em>算法</em>1】在学<em><em>数据</em><em>结构</em></em>和<em>算法</em>的时候我们究竟学的是啥？
    echo PHP_EOL;
    echo $search->highlight($doc->content);
    echo PHP_EOL;

    echo $search->highlight($doc->title,true);
    // PHP<em>数据结构</em><em>与</em><em>算法</em>1】在学<em>数据结构</em>和<em>算法</em>的时候我们究竟学的是啥？
    echo PHP_EOL;
    echo $search->highlight($doc->content,true);
    echo PHP_EOL;

    $doc = $search->setLimit(1)->search('敏捷', false)[0];
    echo $search->highlight($doc->title);
    // 【敏捷1.4】敏捷开发环境：领导<em>与</em>团队
    echo PHP_EOL;

    $search->setLimit(1)->search('');
    echo $search->highlight($doc->title);
    // 【敏捷1.4】敏捷开发环境：领导与团队
    echo PHP_EOL;

    // 折叠

    $docs = $search->setCollapse('category_name')->search('工程');
    foreach ($docs as $doc)
    {
        echo '分类：'.$doc->category_name.' 下有 ' . ($doc->ccount() + 1)  . ' 条匹配结果。',PHP_EOL;
    }
    // 分类：PHP 下有 287 条匹配结果。
    // 分类： 下有 1 条匹配结果。
    // 分类： 下有 1 条匹配结果。
    // 分类：随笔 下有 2 条匹配结果。
    // 分类：项目产品 下有 48 条匹配结果。

    // select count(*),category_name from zy_articles_xs_test group by category_name
    // 287	PHP
    // 2	
    // 2	随笔
    // 49	项目产品
}else if($argv[1] == 3){
    $xs = new XS("demo");
    $xs->index->openBuffer();
    for($i=100000;$i>=1;$i--){
        $xs->index->update(new XSDocument([
            'pid'=>'pid'.$i,
            'subject'=>'sub'.$i,
            'message'=>'msg'.$i,
        ]));
    }
    $xs->index->closeBuffer();
}