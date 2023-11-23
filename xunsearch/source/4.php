<?php

require_once 'vendor/autoload.php';

if($argv[1] == 1){

    // define("XS_APP_ROOT", "./config");

    $xs = new XS('demo'); 

    $doc = $xs->search->search("项目");

    print_r($doc);
    
    print_r($xs->search->getConnString());
}


if($argv[1] == 2){

$xs = new XS('./config/demo2.ini'); 

$doc = $xs->search->search("项目");

print_r($doc);
}


if($argv[1] == 3){

$indexName = 'demo3';
$indexConfig = <<< EOF
project.name = $indexName
project.default_charset = utf-8

[pid]
type = id

[subject]
type = title

[message]
type = body

[chrono]
type = numeric

[author]
type = string
index = both

EOF;

$xs = new XS($indexConfig); 
if($argv[2]){
    $xs->index->clean();
    $data = [
        [
            'pid'=>1,
            'subject'=>'三号DEMO的，关于 xunsearch 的 DEMO 项目测试',
            'message'=>'项目测试是一个很有意思的行为！',
            'chrono'=>1,
            'author'=>'zyblog',
        ],[
            'pid'=>2,
            'subject'=>'三号DEMO的，测试第二篇',
            'message'=>'这里是第二篇文章的内容',
            'chrono'=>1314336160,
            // 'author'=>'zyblog',
        ],[
            'pid'=>3,
            'subject'=>'三号DEMO的，项目测试第三篇',
            'message'=>'俗话说，无三不成礼，所以就有了第三篇',
            'chrono'=>123,
            // 'author'=>'虎力大仙',
        ]
    ];
    foreach($data as $d){
        $doc = new XSDocument;
        $doc->setFields($d);
        $xs->index->add($doc);
    }
}



$doc = $xs->search->search("");

print_r($doc);
}