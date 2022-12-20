<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");
$search = $xs->search;

if ($argv[1] == 1){

    echo $search->setSort('pub_time', true)->setLimit(1)->search()[0]->id, PHP_EOL; // 1
    echo $search->setSort('pub_time', false)->setLimit(1)->search()[0]->id, PHP_EOL; // 844
    echo $search->setSort('pub_time')->setLimit(1)->search()[0]->id, PHP_EOL; // 844

    echo $search->setSort('id', true)->setLimit(1)->search()[0]->id,PHP_EOL; // 1
    echo $search->setSort('id', false)->setLimit(1)->search()[0]->id, PHP_EOL; // 99

    echo $search->setMultiSort(['pub_time'=>true,'id'=>false])->setLimit(1)->search()[0]->id, PHP_EOL; // 99
    echo $search->setMultiSort(['pub_time','id'])->setLimit(1)->search()[0]->id, PHP_EOL; // 844
    echo $search->setMultiSort(['pub_time','id'],true)->setLimit(1)->search()[0]->id, PHP_EOL; // 1




}else if($argv[1] == 2){
    print_r($search->search('数据结构与算法')[0]);
    // XSDocument Object
    // (
    //     [_data:XSDocument:private] => Array
    //         (
    //             [id] => 1
    //             [title] => 【PHP数据结构与算法1】在学数据结构和算法的时候我们究竟学的是啥？
    //             [category_name] => PHP
    //             [tags] => 数据结构,算法
    //             [pub_time] => 20220723
    //             [content] => 在学数据结构和算法的时候我们究竟学的是啥？一说到数据结构与算法，大家都会避之不及。这本来是一门专业基础课，但是大部分人都并没有学好，更不用说我这种半路出家的码农了。说实话，还是很羡慕科班出身的程序员，...
    //         )

    //     [_terms:XSDocument:private] => 
    //     [_texts:XSDocument:private] => 
    //     [_charset:XSDocument:private] => UTF-8
    //     [_meta:XSDocument:private] => Array
    //         (
    //             [docid] => 1
    //             [rank] => 1
    //             [ccount] => 0
    //             [percent] => 100
    //             [weight] => 5.3044538497925
    //         )

    // )

    print_r($search->search('数据结构与算法')[9]);
    // XSDocument Object
    // (
    //     [_data:XSDocument:private] => Array
    //         (
    //             [id] => 3
    //             [title] => 【PHP数据结构与算法2.2】顺序表（数组）的相关逻辑操作
    //             [category_name] => PHP
    //             [tags] => 数据结构,算法
    //             [pub_time] => 20220723
    //             [content] => PHP数据结构-顺序表（数组）的相关逻辑操作在定义好了物理结构，也就是存储结构之后，我们就需要对这个存储结构进行一系列的逻辑操作。在这里，我们就从顺序表入手，因为这个结构非常简单，就是我们最常用的数组。那...
    //         )

    //     [_terms:XSDocument:private] => 
    //     [_texts:XSDocument:private] => 
    //     [_charset:XSDocument:private] => UTF-8
    //     [_meta:XSDocument:private] => Array
    //         (
    //             [docid] => 3
    //             [rank] => 10
    //             [ccount] => 0
    //             [percent] => 95
    //             [weight] => 5.0574460029602
    //         )

    // )


    print_r($search->setLimit(10, 20)->search('数据结构与算法')[9]->rank()); // 30

    
}