<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/5-zyarticle-test1.ini");
$search = $xs->search;

if ($argv[1] == 1){

    print_r($search->getHotQuery());
    // Array
    // (
    //     [敏捷] => 44
    //     [算法] => 6
    //     [数据结构与算法] => 21
    //     [数据库] => 2
    //     [项目] => 2
    //     [最强] => 1
    // )
    
    print_r($search->getHotQuery(4, 'latnum'));
    // Array
    // (
    //     [敏捷] => 44
    //     [算法] => 6
    //     [数据结构与算法] => 21
    //     [数据库] => 2
    // )

    print_r($search->getHotQuery(3, 'currnum'));
    // Array
    // (
    //     [数据结构与算法] => 21
    //     [数据库] => 2
    //     [项目] => 2
    // )
}else if ($argv[1]==2){
    $search->setQuery('算法');
    print_r($search->getRelatedQuery());
    // Array
    // (
    //     [0] => 数据结构与算法
    // )
    
    
    print_r($search->getRelatedQuery('编程', 10));
    // Array
    // (
    //     [0] => 编程语言
    //     [1] => 网络编程
    // )
}else if($argv[1]==3){

    $search->setQuery('蒜法')->search();
    $corrected = $search->getCorrectedQuery();
    if (count($corrected) !== 0)
    {
        echo "您是不是要找：\n";
        foreach ($corrected as $word)
        {
            echo $word . "\n";
        }
    }
    // 您是不是要找：
    // 算法

    print_r($search->getCorrectedQuery('sf'));
    // Array
    // (
    //     [0] => 算法
    // )
    print_r($search->getCorrectedQuery('suanfa'));
    // Array
    // (
    //     [0] => 算法
    // )
    print_r($search->getCorrectedQuery('pmp'));
    // Array
    // (
    //     [0] => php
    // )
    print_r($search->getCorrectedQuery('pmp 蒜法'));
    // Array
    // (
    //     [0] => php算法
    // )

    print_r($search->getExpandedQuery('s'));
    // Array
    // (
    //     [0] => 算法
    //     [1] => 数据结构与算法
    //     [2] => 数据库
    // )
    print_r($search->getExpandedQuery('sf'));
    // Array
    // (
    //     [0] => 算法
    // )
    print_r($search->getExpandedQuery('算'));
    // Array
    // (
    //     [0] => 算法
    // )

    print_r($search->getExpandedQuery('最'));
    // Array
    // (
    //     [0] => 最强
    //     [1] => 最好
    // )

}else if($argv[1]==4){
    $xs2 = new XS('demo');
    $xs2->setScheme(XSFieldScheme::logger());
    $search = $xs2->search;
    $docs = $search->setDb(XSSearch::LOG_DB)->setLimit(1000)->search();
    print_r($docs);
    // …………
    // [0] => XSDocument Object
    //     (
    //         [_data:XSDocument:private] => Array
    //             (
    //                 [chrono] => �
    //                 [4] => �
    //                 [5] => �
    //                 [6] => 2022-W48
    //                 [message] => demo
    //             )
    // …………

    $search->addSearchLog("大学",20);
    $search->addSearchLog("中学");
    $search->addSearchLog("小学");
    $search->addSearchLog("大学");

    $xs->index->flushLogging();

    print_r($search->getHotQuery());                                                     
    // Array
    // (
    //     [小学] => 1
    //     [中学] => 1
    //     [大学] => 21
    // )

}

// $str = "科学\n数学\t12\n物理\t10\n化学\n生物";
// file_put_contents("./14.txt", $str);