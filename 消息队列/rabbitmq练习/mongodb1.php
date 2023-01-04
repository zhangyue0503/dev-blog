<?php


$manager = new MongoDB\Driver\Manager("mongodb://192.168.56.104:27017,192.168.56.104:27018,192.168.56.104:27019");


// $filter = ['x' => ['$gt' => 1]];
// $options = [
//     'projection' => ['_id' => 0],
//     'sort' => ['x' => -1],
// ];

// $bulk = new MongoDB\Driver\BulkWrite();

// $bulk->insert(['_id' => 1, 'x' => 1]);
// exit;




// // 查询数据
// $query = new MongoDB\Driver\Query([]);
// $cursor = $manager->executeQuery('test1.col', $query);

// foreach ($cursor as $document) {
//     print_r($document);
// }


// 插入数据
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert(['x' => 1, 'name'=>'菜鸟教程', 'url' => 'http://www.runoob.com']);
$bulk->insert(['x' => 2, 'name'=>'Google', 'url' => 'http://www.google.com']);
$bulk->insert(['x' => 3, 'name'=>'taobao', 'url' => 'http://www.taobao.com']);
$manager->executeBulkWrite('test.sites', $bulk);

$filter = ['x' => ['$gt' => 1]];
$options = [
    'projection' => ['_id' => 0],
    'sort' => ['x' => -1],
];

// 查询数据
$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('test.sites', $query);

foreach ($cursor as $document) {
    print_r($document);
}