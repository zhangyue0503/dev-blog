<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/zyarticle.ini");

if ($argv[1] == 1){
    var_dump($xs);
// object(XS)#3 (6) {
//   ["_index":"XS":private]=>
//   NULL
//   ["_search":"XS":private]=>
//   NULL
//   ["_scws":"XS":private]=>
//   NULL
//   ["_scheme":"XS":private]=>
// …………………………


    
    
}else if($argv[1] == 2){
    // php 6.php 2 config....
    if ($argv[2]){
        var_dump($xs->{$argv[2]});
    }

    $gbkStr = $xs->convert('我爱北京天安门！', 'GBK', 'UTF8');
    echo $gbkStr, PHP_EOL;
    echo $xs->convert($gbkStr, 'UTF8', 'GBK');
    // �Ұ������찲�ţ�
    // 我爱北京天安门！

    echo PHP_EOL;

    echo $xs->geoDistance(112.983001,28.195852,112.934978,28.176032);
    // 五一广场 中南大学 5193.8670834187米
    

    // var_dump($xs->getLastXS());

}else if ($argv[1] == 3){
    var_dump($xs->fieldId);
    // object(XSFieldMeta)#4 (7) {
    //     ["name"]=>
    //     string(2) "id"
    //     ["cutlen"]=>
    //     int(0)
    //     ["weight"]=>
    //     int(1)
    //     ["type"]=>
    //     int(10)
    //     ["vno"]=>
    //     int(0)
    //     ["tokenizer":"XSFieldMeta":private]=>
    //     string(4) "full"
    //     ["flag":"XSFieldMeta":private]=>
    //     int(1)
    //   }

    var_dump($xs->fieldTitle);

    var_dump($xs->fieldBody);
   
}else if ($argv[1] ==4){
    $id = $xs->fieldId;

    var_dump($id->hasCustomTokenizer()); // bool(true) . 是否自定义分词器
    var_dump($id->getCustomTokenizer()); // object(XSTokenizerFull)#10 (0) {} 分词器对象

    var_dump($id->hasIndex()); // bool(true) 是否索引
    var_dump($id->hasIndexMixed()); // bool(false) 是否混合区索引
    var_dump($id->hasIndexSelf()); // bool(true) 是否字段索引
    var_dump($id->isBoolIndex()); // bool(true) 是否布尔索引


    var_dump($id->isNumeric()); // bool(false) 是否是数字类型
    var_dump($id->isSpeical()); // bool(true) 是否是特殊字段：id、title、body
    var_dump($id->withPos()); // bool(false) 是否支持短语搜索


    var_dump($id->toConfig()); // 显示字段的配置信息
    // string(15) "[id]
    // type = id
    // "


    $c = [
        'type'=>'date',
        'index'=>'both',
    ];
    $dateTest = new XSFieldMeta('date_test', $c);
    var_dump($dateTest->toConfig());
    // string(37) "[date_test]
    // type = date
    // index = both
    // "
    var_dump($dateTest->hasIndexMixed()); // bool(true) 
    var_dump($dateTest->hasIndexSelf()); // bool(true) 
    var_dump($dateTest->isSpeical()); // bool(false)

    var_dump($dateTest->val('2022-11-23')); // string(8) "20221123"  把给定的值转换为符合这个字段的数据格式



}else if ($argv[1] ==5){

    $scheme = $xs->scheme;

    $fields = $scheme->getAllFields();
    print_r($fields['tags']);
    // XSFieldMeta Object
    // (
    //     [name] => tags
    //     [cutlen] => 0
    //     [weight] => 1
    //     [type] => 0
    //     [vno] => 4
    //     [tokenizer:XSFieldMeta:private] => split(,)
    //     [flag:XSFieldMeta:private] => 3
    // )

    print_r($scheme->getField('category_name'));
    // XSFieldMeta Object
    // (
    //     [name] => category_name
    //     [cutlen] => 0
    //     [weight] => 1
    //     [type] => 0
    //     [vno] => 3
    //     [tokenizer:XSFieldMeta:private] => full
    //     [flag:XSFieldMeta:private] => 1
    // )

    print_r($scheme->getVnoMap());
    // Array
    // (
    //     [0] => id
    //     [1] => title
    //     [255] => content
    //     [3] => category_name
    //     [4] => tags
    //     [5] => pub_time
    // )

    $c = [
        'type'=>'date',
        'index'=>'both',
    ];
    $dateTest = new XSFieldMeta('date_test', $c);
    $scheme->addField($dateTest);


    echo $scheme;
    // [id]
    // type = id

    // [title]
    // type = title

    // [content]
    // type = body

    // [category_name]
    // index = self
    // tokenizer = full

    // [tags]
    // index = both
    // tokenizer = split(,)

    // [pub_time]
    // type = date

    // [date_test]
    // type = date
    // index = both

    // $xs->index->add(new XSDocument([
    //     'id'=>200001,
    //     'title'=>'测试动态添加新字段',
    //     'date_test'=>time()
    // ]));


    print_r($xs->search->search('测试动态添加新字段'));
    // Array
    // (
    //     [0] => XSDocument Object
    //         (
    //             [_data:XSDocument:private] => Array
    //                 (
    //                     [id] => 200001
    //                     [title] => 测试动态添加新字段
    //                     [date_test] => 20221123
    //                     [content] => 
    //                 )
    // …………………………
    // …………………………


    $s1 = new XSFieldScheme;
    $s1->addField('date_test');
    // $s1->addField('pid', ['type'=>'id']); // 打开注释，结果就是 true 了
    var_dump($s1->checkValid()); // bool(false)

}


