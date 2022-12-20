<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");
$search = $xs->search;

if ($argv[1] == 1){

    $search->setScwsMulti(15);
    echo $search->setQuery("我是中国人，中华人民共和国")->getQuery(), PHP_EOL;
    // Query((我是@1 AND (中国人@2 SYNONYM (中国@79 AND 国人@80)) AND (中华人民共和国@3 SYNONYM (中华@80 AND 华人@81 AND 人民@82 AND 民共@83 AND 共和@84 AND 和国@85))))
}else if ($argv[1] == 2){

    $tokenizer = new XSTokenizerScws;   // 直接创建实例
    $words = $tokenizer->getResult("我是中国人，中华人民共和国");
    foreach($words as $w){
        echo $w['word']."/".$w['attr']."/".$w['off'],"\t";
    }
    // 我是/v/0        是/v/3  中国人/n/6      中国/ns/6       国人/n/9        ，/un/15        中华人民共和国/ns/18中华/nz/18      人民/n/24       共和国/ns/30    

    echo PHP_EOL;
    // $tokenizer = new XSTokenizerScws(SCWS_MULTI_SHORT+SCWS_MULTI_ZMAIN); 
    $tokenizer->setMulti(SCWS_MULTI_NONE); // 设置复合分词等级
    $tokenizer->setDuality(false); // 关闭散字二元，默认是开启的
    $words = $tokenizer->getResult("我是中国人，中华人民共和国");
    foreach($words as $w){
        echo $w['word']."/".$w['attr']."/".$w['off'],"\t";
    }
    // 我是/v/0        是/v/3  中国人/n/6      ，/un/15        中华人民共和国/ns/18 

    echo PHP_EOL;
    $words = $tokenizer->getTops('我是中国人，中华人民共和国');
    foreach($words as $w){
        echo $w['word']."/".$w['attr']."/".$w['times'],"\t";
    }
    // 中华人民共和国/ns/      中国人/n/  

    echo PHP_EOL;
    var_dump($tokenizer->hasWord('我是中国人，中华人民共和国', 'v')); // bool(true)
    var_dump($tokenizer->hasWord('我是中国人，中华人民共和国', 'n')); // bool(true)
    var_dump($tokenizer->hasWord('我是中国人，中华人民共和国', 'Ag')); // bool(false)

    echo PHP_EOL;
    echo $tokenizer->getVersion(); // 1.2.3
}
