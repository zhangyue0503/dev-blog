<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");
$search = $xs->search;

if ($argv[1] == 1){

    print_r($search->setQuery('数据结构与算法')->getQuery());
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 与@2 AND 算法@3))

    echo PHP_EOL;

    print_r($search->getQuery('数据结构 算法'));
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 算法@2))


    echo PHP_EOL;

    $search->query = "设计模式之门面模式";
    echo $search->query, PHP_EOL;
    // Query(((设计模式@1 SYNONYM (设计@78 AND 模式@79)) AND 之@2 AND 门面@3 AND 模式@4))

}else if($argv[1] == 2){
    print_r($search->getQuery('数据结构 OR 算法'));
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) OR 算法@2))
    echo PHP_EOL;
    print_r($search->getQuery('数据结构 or 算法'));
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND Zor@2 AND 算法@3))
    echo PHP_EOL;
    print_r($search->setFuzzy()->getQuery('数据结构与算法'));
    // Query(((数据结构@1 SYNONYM (数据@78 OR 结构@79)) OR 与@2 OR 算法@3))

    echo PHP_EOL;

    $search->setFuzzy(false);
    echo $search->count("数据结构 算法"), PHP_EOL; // 37
    echo $search->count("数据结构 OR 算法"), PHP_EOL; // 140
    echo $search->setFuzzy()->count("数据结构 算法"), PHP_EOL; // 300


    echo $search->setFuzzy(false)->getQuery('数据结构 XOR 算法'), PHP_EOL;
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) XOR 算法@2))
    echo $search->count('数据结构 XOR 算法'), PHP_EOL;  // 66


    echo $search->getQuery('title:数据结构与算法'), PHP_EOL;
    // Query(((B数据结构@1 SYNONYM (B数据@78 AND B结构@79)) AND B与@2 AND B算法@3))
    echo $search->getQuery('title:数据结构 算法'), PHP_EOL;
    // Query(((B数据结构@1 SYNONYM (B数据@78 AND B结构@79)) AND 算法@2))
    echo $search->getQuery('title:数据结构 title:算法'), PHP_EOL;
    // Query(((B数据结构@1 SYNONYM (B数据@78 AND B结构@79)) AND B算法@2))
    echo $search->getQuery('title:数据结构 tags:算法'), PHP_EOL;
    // Query(((B数据结构@1 SYNONYM (B数据@78 AND B结构@79)) FILTER E算法))
    echo $search->getQuery('数据结构 tags:算法'), PHP_EOL;
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) FILTER E算法))
    echo $search->getQuery('森林 category_name:PHP tags:数据结构 title:二叉树'), PHP_EOL;
    // Query(((森林@1 AND (B二叉@2 AND B叉树@3)) FILTER (Dphp AND E数据结构)))
    // print_r($search->search('森林 category_name:项目产品 tags:数据结构 title:二叉树'));

    echo $search->getQuery('设计模式 -工厂'),PHP_EOL; 
    // Query(((设计模式@1 SYNONYM (设计@78 AND 模式@79)) AND_NOT 工厂@2))
    echo $search->count('设计模式 -工厂'), PHP_EOL; // 42
    echo $search->count('设计模式 NOT 简单工厂'), PHP_EOL; // 47

    echo $search->getQuery('((森林 OR 迷宫) AND tags:数据结构) OR (title:二叉树 NOT title:遍历)'), PHP_EOL;
    // Query((((森林@1 OR 迷宫@2) AND 0 * E数据结构) OR ((B二叉@3 AND B叉树@4) AND_NOT B遍历@5)))


    $search->setQuery("设计");
    // $search->addQueryString("存储"); // Query((设计@1 AND 存储@1))
    // $search->addQueryString("存储", XS_CMD_QUERY_OP_OR); // Query((设计@1 OR 存储@1))
    $search->addQueryString("存储");
    $search->addQueryString("效果", XS_CMD_QUERY_OP_AND_NOT);
    // Query(((设计@1 AND 存储@1) AND_NOT 效果@1))
    echo $search->getQuery(), PHP_EOL;

    $search->setQuery("设计");
    $search->addQueryString("存储");
    $search->addQueryString("效果", XS_CMD_QUERY_OP_AND_NOT);
    $search->search();
    // …………
    $search->setQuery("设计");
    $search->addQueryString("试试看");
    echo $search->getQuery(), PHP_EOL;
    // Query((((设计@1 AND 存储@1) AND_NOT 效果@1) AND (试试看@1 SYNONYM (试试@78 AND 试看@79))))
    exit;

    $search->setQuery("设计");

    $search->addQueryString("设计模式");
    $search->addQueryTerm('title',"设计模式");

    echo $search->getQuery(), PHP_EOL;
    // Query(((设计@1 AND (设计模式@1 SYNONYM (设计@78 AND 模式@79))) AND B设计模式))


}else if ($argv[1] == 3){
    echo $search->count('数据结构与算法'), PHP_EOL; // 35
    echo $search->count('"数据结构与算法"'), PHP_EOL; // 26
    echo $search->count('"算法与数据结构"'), PHP_EOL; // 1
    // print_r( $search->search('"算法与数据结构"'));
    echo $search->getQuery('"数据结构与算法"'), PHP_EOL; // Query((数据结构@1 PHRASE 3 与@2 PHRASE 3 算法@3))
    echo $search->getQuery('"算法与数据结构"'), PHP_EOL; // Query((算法@1 PHRASE 3 与@2 PHRASE 3 数据结构@3))

    echo $search->count('title:数据结构与算法'), PHP_EOL; // 22
    echo $search->count('title:"数据结构与算法"'), PHP_EOL; // 22
    echo $search->count('title:"算法与数据结构"'), PHP_EOL; // 0



    echo $search->getQuery('方法 NEAR 约束'), PHP_EOL;
    // Query((数据@1 AND near@2 AND 算法@3))

    echo $search->getQuery('方法 ADJ 约束'), PHP_EOL;
    // Query((方法@1 AND adj@2 AND 约束@3))

    echo $search->addRange('pub_time', '20221031', '20221104')->search(''), PHP_EOL;
    // Query(pub_time:[20221031,20221104])
    echo $search->getQuery(''), PHP_EOL;
    // Query(pub_time:[20221031,20221104])

    echo $search->addRange('id', '100', '200')->getQuery(''), PHP_EOL;
    // Query((pub_time:[20221031,20221104 FILTER VALUE_RANGE 0 100 200]))
    echo $search->addRange('id', '1', '100')->getQuery('数据结构与算法'), PHP_EOL;
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 与@2 AND 算法@3))

    echo $search->setQuery('数据结构与算法')->getQuery(), PHP_EOL;
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 与@2 AND 算法@3))
    echo $search->addRange('id', '1', '100')->setQuery('数据结构与算法')->getQuery(), PHP_EOL;
    // Query(((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 与@2 AND 算法@3))
    echo $search->setQuery('数据结构与算法')->addRange('id', '1', '100')->getQuery(), PHP_EOL;
    // Query((((数据结构@1 SYNONYM (数据@78 AND 结构@79)) AND 与@2 AND 算法@3) FILTER id:[1,100]))

    print_r($search->setQuery('数据结构与算法')->setLimit(1)->search()); // id 1 
    print_r($search->setQuery('数据结构与算法')->addWeight('content', '设计', 10)->setLimit(1)->getQuery()); // id 232




}else if($argv[1] == 4){
    $search->setQuery('PHP')->setFacets(['category_name', 'tags'])->search();

    print_r($search->setQuery('PHP category_name:项目产品')->search());

    $cates = $search->getFacets('category_name');
    foreach($cates as $c=>$count){
        echo $c.':'.$count,PHP_EOL;
    }
    // PHP:282
    // 随笔:5
     echo '==========', PHP_EOL;

    $tags = $search->getFacets('tags');
    foreach($tags as $t=>$count){
        echo $t.':'.$count,PHP_EOL;
    }
    // PHP基础:161
    // PHP基础,PHP魔术:5
    // PHP基础,压缩:5
    // PHP基础,命名空间:10
    // PHP基础,文件操作:5
    // PHP基础,文件操作,PHP SPL:5
    // 数据结构,算法:90
    // 设计模式:5

}