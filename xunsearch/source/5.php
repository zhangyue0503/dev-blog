<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/5-zyarticle-test1.ini");
// $xs = new XS("./config/zyarticle.ini");
// var_dump($xs->index);

// exit;




if($argv[1] == '1'){
$dns = 'mysql:host=localhost;dbname=zyblog;port=3306;charset=utf8';
$pdo = new PDO($dns, 'root', '123456', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);


$stmt = $pdo->prepare("select * from zy_articles_xs_test where status = 1");
$stmt->execute();

$list = $stmt->fetchAll();


$xs->index->clean();

foreach($list as $v){
    $v['content'] = strip_tags($v['content']);
    $v['sortid'] = "00".$v['id'];
    $doc = new XSDocument($v);
    $xs->index->add($doc);
    var_dump($xs->index);
}

echo '索引建立完成！';


} else if($argv[1] == '2'){
    $doc = new XSDocument([
        'id'=>100001,
        'title'=> '测试tags逗号分词',
        'content'=>'电路原理图时实时路况多久地板砖南昌中专学校晨进棒喝杨万里中',
        'tags'=>'电路原,理图,时实时,路况多,久地板砖,南昌中专学校晨进棒喝杨万里中',
        'category_name'=>'时实时'
    ]);
    $xs->index->add($doc);

    $doc = new XSDocument([
        'id'=>100001,
        'title'=> '252525',
        'content'=>'11223344',
        'tags'=>'逗号分词',
        'category_name'=>'时实时'
    ]);
    $xs->index->add($doc);

    $doc = new XSDocument([
        'id'=>100001,
        'title'=> '电路原理图时实时路况多久地板砖南昌中专学校晨进棒喝杨万里中',
        'content'=>'测试tags逗号分词',
        'tags'=>'123123',
        'category_name'=>'时实时'
    ]);
    $xs->index->add($doc);
}else if($argv[1] == 3){
$docs = $xs->search->setQuery('')->setLimit(20,0)->setSort('sortid',true)->search();
var_dump($docs);
}


// var_dump($docs[0]->f($xs->getFieldBody()));

