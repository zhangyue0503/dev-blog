<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/5-zyarticle-test1.ini");

if ($argv[1] == 1){

    $index = $xs->index;

    $index2 = $xs->index->add(new XSDocument(['title'=>'添加一条','content'=>'添加一条'.date('YmdHis'),'id'=>uniqid()]));

    var_dump($index === $index2);

}else if($argv[1] == 2){
    $xs->index->update(new XSDocument(['title'=>'添加一条','content'=>'添加一条'.date('YmdHis'),'id'=>uniqid()]));

}else if($argv[1] == 3){
    //  $xs->index->add(new XSDocument(['title'=>'添加一条1','content'=>'添加一条'.date('YmdHis'),'id'=>'123123123']));
    // $xs->index->add(new XSDocument(['title'=>'添加一条2','content'=>'添加一条'.date('YmdHis'),'id'=>'123123123']));

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/5-zyarticle-test1.ini "添加一条"

    $xs->index->update(new XSDocument(['title'=>'添加一条3','pub_time'=>time(),'id'=>'123123123']));

    // php vendor/hightman/xunsearch/util/Quest.php --show-query ./config/5-zyarticle-test1.ini "添加一条"

    // ES 测试
    // PUT demo1/_doc/EQqurIQBV_CuJX_ikeFp
    // {
    // "subject":"修改掉了"
    // }
    // POST demo1/_update/-W96vIQBs0MZQhxkYTE2
    // {
    // "doc":{
    //     "subject":"修改掉了"
    // }
    // }
}else if($argv[1] == 4){
    $xs->index->del('656fcd2c8658a');
    $xs->index->del(['6380e241c27e5','123123123']);
}else if($argv[1] == 5){
    // $xs->index->del('添加一条3','title');
    $xs->index->del('加一','title');
}else if($argv[1] == 6){
    $index = $xs->index;
    $index->openBuffer();
    $index->add(new XSDocument(['title'=>'添加一条','content'=>'添加一条'.date('YmdHis'),'id'=>uniqid()]));
    sleep(60);
    $index->add(new XSDocument(['title'=>'添加一条','content'=>'添加一条'.date('YmdHis'),'id'=>uniqid()]));
    $index->add(new XSDocument(['title'=>'添加一条','content'=>'添加一条'.date('YmdHis'),'id'=>uniqid()]));
    $index->closeBuffer();
}else if($argv[1] == 7){
    $index = $xs->index;
    $time = microtime(true);
    $index->openBuffer();
    for($i=1;$i<=100000;$i++){
        $index->add(new XSDocument(['title'=>'添加一条'.$i,'content'=>'添加一条'.$i.date('YmdHis'),'id'=>$i]));
    }
    $index->closeBuffer();
    echo microtime(true)-$time;
    // 不使用buffer 91.203243017197
    // 使用buffer 2.8002960681915
}else if($argv[1] == 8){
    echo $xs->search->setQuery('添加一条')->count();
} else if ($argv[1] == 9){
    $xs->index->clean();
} else if ($argv[1] == 10){
    $index = $xs->index;
    $index->stopRebuild();
    $index->beginRebuild();
    $time = microtime(true);
    $index->openBuffer();
    for($i=1;$i<=100000;$i++){
        $index->add(new XSDocument([
            'title'=>'添加一条'.$i,
            'content'=>'添加一条'.$i.date('YmdHis'),
            'pub_time'=>time(), // 增加pub_time数据
            'id'=>$i
        ]));
    }
    $index->closeBuffer();
    $index->endRebuild();
}
