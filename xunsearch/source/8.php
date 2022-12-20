<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");

if ($argv[1] == 1){
    var_dump($xs->index);
    // object(XSIndex)#10 (9) {
    //     ["_buf":"XSIndex":private]=>
    //     string(0) ""
    //     ["_bufSize":"XSIndex":private]=>
    //     int(0)
    //     ["_rebuild":"XSIndex":private]=>
    //     bool(false)
    //     ["xs"]=>
}else if($argv[1] == 2){
    if($argv[2] == 1){
    $xs->index->setDb('zydb');

    $doc = new XSDocument([
        'id'=>100002,
        'title'=> '尝试索引库zydb',
        'content'=>'尝试索引库zydb',
        'tags'=>'aa,bb,cc',
        'category_name'=>'索引库',
        'pub_time'=>date('Ymd'),
    ]);
    $xs->index->add($doc);
}
// print_r($xs->search->search('id:100002'));
print_r($xs->search->addDb('zydb')->setSort('pub_time',false)->search(''));
    // print_r($xs->search->setDb('zydb')->search(''));
    
}else if($argv[1] == 3){
    $doc = new XSDocument([
        'id'=>123123,
        'title'=>'这是标题呀',
    ]);


    echo $doc->id,",", $doc['title'], PHP_EOL; // 123123,这是标题呀

    $doc['title'] = "没错，就是标题";
    echo $doc->title, PHP_EOL; // 没错，就是标题

    $doc->setField('title','标题换回去吧！');
    echo $doc->f('title'), PHP_EOL; // 标题换回去吧！

    $doc->setFields([
        'title'=>'再来一次',
        'content'=>'这下有内容了',
    ]);
    print_r($doc->getFields());
    // Array
    // (
    //     [id] => 123123
    //     [title] => 再来一次
    //     [content] => 这下有内容了
    // )

    print_r($doc);
    // XSDocument Object
    // (
    //     [_data:XSDocument:private] => Array
    //         (
    //             [id] => 123123
    //             [title] => 再来一次
    //             [content] => 这下有内容了
    //         )

    //     [_terms:XSDocument:private] => 
    //     [_texts:XSDocument:private] => 
    //     [_charset:XSDocument:private] => 
    //     [_meta:XSDocument:private] => 
    // )

    $searchDoc = $xs->search->setLimit(1)->search('');
    print_r($searchDoc);
    // Array
    // (
    //     [0] => XSDocument Object
    //         (
    //             [_data:XSDocument:private] => Array
    //                 (
    //                     [id] => 1
    //                     [title] => 【PHP数据结构与算法1】在学数据结构和算法的时候我们究竟学的是啥？
    //                     [category_name] => PHP
    //                     [tags] => 数据结构,算法
    //                     [pub_time] => 20220723
    //                     [content] => 在学数据结构和算法的时候我们究竟学的是啥？一说到数据结构与算法，大家都会避之不及。这本来是一门专业基础课，但是大部分人都并没有学好，更不用说我这种半路出家的码农了。说实话，还是很羡慕科班出身的程序员，...
    //                 )

    //             [_terms:XSDocument:private] => 
    //             [_texts:XSDocument:private] => 
    //             [_charset:XSDocument:private] => GBK
    //             [_meta:XSDocument:private] => Array
    //                 (
    //                     [docid] => 1
    //                     [rank] => 1
    //                     [ccount] => 0
    //                     [percent] => 100
    //                     [weight] => 0
    //                 )

    //         )

    // )

    echo $searchDoc[0]->percent(); // 100



    // $doc2 = new XSDocument(['id'=>800001,'title'=>'测试250',], 'GBK');
    // print_r($doc2->getCharset()); // GBK
    // $doc2->setCharset('gb2312');
    // print_r($doc2->getCharset()); // GB2312

    // $xs->index->add($doc2);
    print_r($xs->search->search('id:800001'));
    // ………………
    // [_data:XSDocument:private] => Array
    // (
    //     [id] => 800001
    //     [title] => 娴?璇?250
    //     [content] => 
    // )
    // ………………

    class ZyDoc extends XSDocument{
        public function afterSubmit($index)
        {
            parent::afterSubmit($index);
            echo 'after，数据被提交到服务端了哦！！！',PHP_EOL;
        }
        public function beforeSubmit(XSIndex $index)
        {
            parent::beforeSubmit($index);
            echo 'before，数据还没有被到服务端哦！！！',PHP_EOL;
        }
    }

    // $zydoc = new ZyDoc();
    // $zydoc['id'] = 800002;
    // $zydoc->title = 'ZyDoc来测一下';
    // $xs->index->add($zydoc);
    // // before，数据还没有被到服务端哦！！！
    // // after，数据被提交到服务端了哦！！！

    $doc3 = new XSDocument(['title'=>'最后的测试了','content'=>'主要试一下附加索引词和附加索引文本','id'=>800008]);
    $doc3->addIndex('title', '奇怪的知识又增加了');
    $doc3->addTerm('title', '说话');
    $doc3->addTerm('title', '之间');
    $doc3->addTerm('title', '小日子过得不错的RB人');
    $doc3->addTerm('title', '日子');

    $doc3->addIndex('content', "我爱北京天安门");
    $doc3->addTerm('content', "印度");
    $doc3->addTerm('content', "印度喜欢吃咖喱");
    

    print_r($doc3->getAddIndex('title')); // 奇怪的知识又增加了
    print_r($doc3->getAddTerms('title'));
    // Array
    // (
    //     [说话] => 1
    //     [之间] => 1
    //     [小日子过得不错的RB人] => 1
    //     [日子] => 1
    // )

    print_r($doc3->getAddIndex('content')); // 我爱北京天安门
    print_r($doc3->getAddTerms('content'));
    // Array
    // (
    //     [印度] => 1
    // )

    print_r($doc3);

    // $xs->index->add($doc3);

    var_dump($xs->search->search('id:800005')[0]);
    // object(XSDocument)#13 (5) {
    //     ["_data":"XSDocument":private]=>
    //     array(3) {
    //       ["id"]=>
    //       string(6) "800005"
    //       ["title"]=>
    //       string(18) "最后的测试了"
    //       ["content"]=>
    //       string(51) "主要试一下附加索引词和附加索引文本"
    //     }
    //     ["_terms":"XSDocument":private]=>
    //     NULL
    //     ["_texts":"XSDocument":private]=>
    //     NULL
    //     ["_charset":"XSDocument":private]=>
    //     string(5) "UTF-8"
    //     ["_meta":"XSDocument":private]=>
    //     array(5) {
    //       ["docid"]=>
    //       int(348)
    //       ["rank"]=>
    //       int(1)
    //       ["ccount"]=>
    //       int(0)
    //       ["percent"]=>
    //       int(100)
    //       ["weight"]=>
    //       float(0)
    //     }
    //   }
    
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "说话"  
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "奇怪的知识"
    # 查不到

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "title:说话"
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "title:奇怪的知识"
    // 可以查到

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "印度"
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "我爱北京天安门"
    // 可以查到

    // 源代码中，混合区索引 vno 是 255 ，both 索引在附加索引相关的代码中缺少混合区标签判断，只有是完全的混合区的字段 index=mixed 的才会索引到混合区可以被搜索，

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "小日子过得不错的RB人"
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "title:小日子过得不错的RB人"
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "印度喜欢吃咖喱" // 查不到
    # 查不到

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "title:日子"
    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/zyarticle.ini "印度"
    # 能查到

    // term 分词，比如：印度喜欢吃咖喱、小日子过得不错的RB人，会以整词做倒排索引，但查询时会分词
    // 比如查询时，输入 印度喜欢吃咖喱 默认切分为 (印度@1 AND 喜欢@2 AND 吃@3 AND 咖喱@4) 无法与 印度喜欢吃咖喱 整词匹配
    // ES 中也有这个问题

    // 搜索时强制增加一个完整的 term 
    print_r($xs->search->setFuzzy()->search('印度喜欢吃咖喱'));  // 能查到
    print_r($xs->search->setFuzzy()->addQueryTerm('title', '印度喜欢吃咖喱')->search('')); // 能查到

    print_r($xs->search->addQueryTerm('title', '小日子过得不错的RB人')->search('')); // 查不到
    print_r($xs->search->addQueryTerm('title', '小日子过得不错的rb人')->search('')); // 能查到

   
    



    
    
    // print_r($doc->getAddIndex('title'));
    // print_r($searchDoc[0]->getAddTerms('title'));



}
// Array
// (
// )


// # ========== ES 词法搜索测试
// # 不能使用第二篇文章中的 mapping ，直接使用ES默认的 mapping 中带fields配置的语法就行

// PUT demo1
// {
//   "mappings": {
//     "properties": {
//       "chrono": {
//         "type": "long"
//       },
//       "message": {
//         "type": "text",
//         "analyzer": "ik_max_word",
//         "fields": {
//           "keyword": {
//             "type": "keyword",
//             "ignore_above": 256
//           }
//         }
//       },
//       "pid": {
//         "type": "long"
//       },
//       "subject": {
//         "type": "text",
//         "analyzer": "ik_max_word",
//         "fields": {
//           "keyword": {
//             "type": "keyword",
//             "ignore_above": 256
//           }
//         }
//       }
//     }
//   }
// }

// POST demo1/_doc
// {
//   "pid":1,
//   "subject":"关于 xunsearch 的 DEMO 项目测试",
//   "message":"项目测试是一个很有意思的行为！",
//   "chrono":1314336158
// }

// POST demo1/_doc
// {
//   "pid":2,
//   "subject":"测试第二篇ABC",
//   "message":"这里是第二篇文章的内容",
//   "chrono":1314336160
// }

// POST demo1/_doc
// {
//   "pid":3,
//   "subject":"项目测试第三篇",
//   "message":"俗话说，无三不成礼，所以就有了第三篇",
//   "chrono":1314336168
// }

// # 查不到
// GET demo1/_search
// {
//   "query":{
//     "term" : {
//       "subject" :"测试第二篇ABC"
//     }
//   }
// }

# 正常
// GET demo1/_search
// {
//   "query":{
//     "term" : {
//       "subject" :"测试" #换成小写 abc 也可以
//     }
//   }
// }
// GET demo1/_search
// {
//   "query":{
//     "term" : {
//       "subject.keyword" :"测试第二篇ABC"
//     }
//   }
// }

// # 查不到
// GET demo1/_search
// {
//   "query":{
//     "term" : {
//       "subject" :"ABC"
//     }
//   }
// }
// GET demo1/_search
// {
//   "query":{
//     "term" : {
//       "subject.keyword" :"测试第二篇abc"
//     }
//   }

