<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/5-zyarticle-test1.ini");
$search = $xs->search;

if ($argv[1] == 1){

    // $xs->index->addSynonym("最好","最强");
    // $xs->index->addSynonym("最好","最棒");
    // $xs->index->addSynonym("最棒","最强");

    // getAllSynonyms()
    print_r($search->allSynonyms);

    // getCorrectedQuery()
    $search->query = 'sf';
    print_r($search->correctedQuery);

    // setFacets()、getFacets()
    $search->facets = ['category_name'];
    $search->search('算法');
    print_r($search->facets);

    // getHotQuery()
    print_r($search->hotQuery);

    // getRelatedQuery()
    print_r($search->relatedQuery);



    
}else if($argv[1]==2){

    echo $search->count('算法'), PHP_EOL; // 63
    echo $search->setCutOff(95)->count('算法'), PHP_EOL; // 12
    echo $search->setCutOff(95,2)->count('算法'), PHP_EOL; // 7
    $search->setCutOff(0,0);

    
    print_r($search->setCharset('gb2312')->search('算法'));
    // Array
    // (
    // )
    $search->setCharset('utf8');



    echo $search->setDocOrder()->search('算法')[0]->id, PHP_EOL; // 1
    echo $search->setDocOrder(true)->search('算法')[0]->id, PHP_EOL; // 1

    echo $search->setDocOrder()->search()[0]->id, PHP_EOL; // 1
    echo $search->setDocOrder(true)->search()[0]->id, PHP_EOL; // 844

    $docs = $search->setRequireMatchedTerm()->setLimit(1000)->setFuzzy()->setQuery('数据结构与算法')->search();
    foreach($docs as $d){
        print_r($d->matched());
    }
    // Array
    // (
    //     [0] => 数据结构
    //     [1] => 与
    //     [2] => 算法
    //     [3] => 数据
    //     [4] => 结构
    // )
    // …………………………
    // …………………………
    // Array
    // (
    //     [0] => 与
    //     [1] => 数据
    // )
    $search->setRequireMatchedTerm(false);
    $search->setFuzzy(false);

    echo $search->setScwsMulti(15)->setQuery('我爱北京天安门，天安门上太阳升')->getQuery(), PHP_EOL;
    // Query((我爱@1 AND 北京@2 AND (天安门@3 SYNONYM (天安@80 AND 安门@81)) AND 天安@4 AND 门上@5 AND (太阳升@6 SYNONYM (太阳@83 AND 阳升@84))))

    echo $search->setScwsMulti(1)->setQuery('我爱北京天安门，天安门上太阳升')->getQuery(), PHP_EOL;
    // Query((我爱@1 AND 北京@2 AND (天安门@3 SYNONYM 天安@80) AND 天安@4 AND 门上@5 AND (太阳升@6 SYNONYM 太阳@83)))


    // $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最好的Web编程语言',
    //     'content'=>'你敢信？',
    //   ]));
    //   $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最强的Web编程语言',
    //     'content'=>'你敢信？',
    //   ]));
    //   $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最棒的Web编程语言',
    //     'content'=>'你敢信？',
    //   ]));
    print_r($search->setFuzzy()->setAutoSynonyms()->setQuery('敏捷最好')->search());
    print_r($search->setAutoSynonyms()->setSynonymScale(0.01)->setQuery('敏捷最好')->search());
    // 没效果
// exit;
    $search->setFuzzy(false)->setAutoSynonyms(false);
    
    echo $search->setWeightingScheme(0)->search('算法')[0]->id, PHP_EOL; // 238
    echo $search->setWeightingScheme(1)->search('算法')[0]->id, PHP_EOL; // 234
    echo $search->setWeightingScheme(2)->search('算法')[0]->id, PHP_EOL; // 234
// exit;
    print_r($search->terms()); 
    // Array
    // (
    //     [0] => 敏捷
    //     [1] => 最好
    //     [2] => 最强
    //     [3] => 最棒
    // )

    print_r($search->setQuery('数据结构与算法')->terms()); 
    // Array
    // (
    //     [0] => 数据结构
    //     [1] => 与
    //     [2] => 算法
    //     [3] => 数据
    //     [4] => 结构
    // )

// exit;
    // setGeodistSort
    $xs = new XS("./config/5-zyarticle-test1.ini");
$search = $xs->search;

    $scheme = $xs->scheme;
    $scheme->addField(new XSFieldMeta('lon', ['type'=>'numeric']));
    $scheme->addField(new XSFieldMeta('lat', ['type'=>'numeric']));

//     $xs->index->clean();
//     $xs->index->add(new XSDocument([
//         'id'=>uniqid(),
//         'title'=>'五一广场',
//         'content'=>'五一广场',
//         'lon'=>112.983037,
//         'lat'=>28.198986,
//     ]));
//     $xs->index->add(new XSDocument([
//         'id'=>uniqid(),
//         'title'=>'长沙火车站',
//         'content'=>'长沙火车站',
//         'lon'=>113.017496,
//         'lat'=>28.199495,
//     ]));
//     $xs->index->add(new XSDocument([
//         'id'=>uniqid(),
//         'title'=>'南门口',
//         'content'=>'南门口',
//         'lon'=>112.982875,
//         'lat'=>28.188591,
//     ]));
//     $xs->index->flushIndex();

    // 长沙南站    长沙火车站->南门口->五一广场
    print_r($search->setGeodistSort(['lon'=>113.071808,'lat'=>28.153261])->setQuery('')->search());
    // 黄兴广场    五一广场->南门口->长沙火车站
    print_r($search->setGeodistSort(['lon'=>112.982947,'lat'=>28.195389])->setQuery('')->search());
    // 贺龙体育馆  南门口->五一广场>长沙火车站
    print_r($search->setGeodistSort(['lon'=>112.989442,'lat'=>28.183982])->setQuery('')->search());

    $helong = ['lon'=>112.989442,'lat'=>28.183982];
    $docs = $search->setGeodistSort($helong)->setQuery('')->search();
    foreach($docs as $d){
        $dis = XS::geoDistance($helong['lon'], $helong['lat'], $d->lon, $d->lat);
        echo '贺龙体育馆距离 '.$d->title.' '.$dis.' 米！ ', PHP_EOL;
    }
    // 贺龙体育馆距离 南门口 822.2271880921 米！ 
    // 贺龙体育馆距离 五一广场 1781.4304737794 米！ 
    // 贺龙体育馆距离 长沙火车站 3243.6888814142 米！ 

}
