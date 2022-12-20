<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");

if ($argv[1] == 1) {
    // $xs->index->clean();
    // $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最好的Web编程语言',
    //     'content'=>'你敢信？',
    // ]));
    // $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最强的Web编程语言',
    //     'content'=>'你敢信？',
    // ]));
    // $xs->index->add(new XSDocument([
    //     'id'=>uniqid(),
    //     'title'=>'PHP是最棒的Web编程语言',
    //     'content'=>'你敢信？',
    // ]));
    

    // $xs->index->addSynonym("最好","最强");
    // $xs->index->addSynonym("最好","最棒");

    // $xs->index->addSynonym("最棒","最强");

    

    print_r($xs->search->setAutoSynonyms()->search('最好'));
    // 三条数据

    print_r($xs->search->search('最棒'));
    // 两条数据

    print_r($xs->search->search('最强'));
    // 只有最后一条

   

    print_r($xs->search->setQuery('最好')->getQuery());
    // Query((最好@1 SYNONYM 最强@78 SYNONYM 最棒@79))

    $xs->search->setAutoSynonyms(false);
    print_r($xs->search->search('最好')); // 恢复成一条了

    print_r($xs->search->setQuery('最好')->getQuery());
    // Query(最好@1)
    


    print_r($xs->search->getAllSynonyms());
    // Array
    // (
    //     [最好] => Array
    //         (
    //             [0] => 最强
    //             [1] => 最棒
    //         )
    
    //     [最棒] => Array
    //         (
    //             [0] => 最强
    //         )
    
    // )


    print_r($xs->search->getAllSynonyms(0,0,true));
    // Array
    // (
    //     [最好] => Array
    //         (
    //             [0] => 最强
    //             [1] => 最棒
    //         )

    //     [最棒] => Array
    //         (
    //             [0] => 最强
    //         )

    // )


    $xs->index->delSynonym('最好', '最强');

    print_r($xs->search->getAllSynonyms(0,0,true));
    // Array
    // (
    //     [最好] => Array
    //         (
    //             [0] => 最棒
    //         )

    //     [最棒] => Array
    //         (
    //             [0] => 最强
    //         )

    // )
    print_r($xs->search->setAutoSynonyms()->search('最好'));
    // 只能查到两条了

    


}else if($argv[1] == 2){
    var_dump($xs->index->customDict); // string(0) ""
    var_dump($xs->index->scwsMulti); // int(3)
}else if($argv[1] == 3){
    $id = uniqid();
    $xs->index->add(new XSDocument([
        'id'=>$id,
        'title'=>'JavaScript才是最牛X的',
        'content'=>'服不服？',
    ]));
    var_dump($xs->index->flushIndex());

}else if($argv[1] == 4){
    var_dump($xs->index->flushLogging());
}else if($argv[1] == 5){
    $xs->index->setDb(XSSearch::LOG_DB)->clean();
}
