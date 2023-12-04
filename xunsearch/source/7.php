<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/5-zyarticle-test1.ini");







$server = new XSServer('localhost:8384', $xs);
echo $server->connString, PHP_EOL; // localhost:8384

$index = $xs->index;
echo $index->connString, PHP_EOL; // localhost:8383

$search = $xs->search;
echo $search->connString, PHP_EOL; // localhost:8384



// echo $search->project, PHP_EOL; // zyarticle
// echo $search->socket, PHP_EOL; // Resource id #17
// var_dump($search->xs === $xs); // bool(true)

// $search->project = 'demo';
// print_r($search->setLimit(1)->search(''));
// //     Array
// // (
// //     [0] => XSDocument Object
// //         (
// //             [_data:XSDocument:private] => Array
// //                 (
// //                     [id] => 1
// //                     [title] => 三号DEMO的，关于 xunsearch 的 DEMO 项目测试
// //                     [category_name] => �\�r��
// //                     [content] => 项目测试是一个很有意思的行为！
// //                 )


// var_dump($search->hasRespond()); // bool(false)
// if($search->hasRespond()){
//     $search->respond;
// }

// $search->close();
// try{
//     print_r($search->search(''));
// }catch(XSException $e){
//     echo $e->getMessage(),PHP_EOL; // Broken server connection
// }

// // $search->open('8384');
// $search->reopen();
// print_r($search->setLimit(1)->search(''));
// //     Array
// // (
// //     [0] => XSDocument Object
// //         (
// //             [_data:XSDocument:private] => Array
// //                 (
// //                     [id] => 1
// //                     [title] => 【PHP数据结构与算法1】在学数据结构和算法的时候我们究竟学的是啥？
// //                     [category_name] => PHP
// //                     [tags] => 数据结构,算法
// //                     [pub_time] => 20220723

// $search->setTimeout(3);
// sleep(2);
// try{
//     print_r($search->search(''));
// }catch(XSException $e){
//     echo $e->getMessage(),PHP_EOL; // Failed to recv the data from server completely (SIZE:0/8, REASON:closed)
// }

// $search->reopen();

// $cmd = array('cmd' => XS_CMD_TIMEOUT, 'arg' => 1);
// $search->execCommand($cmd, XS_CMD_OK_TIMEOUT_SET);
// sleep(2);
// try{
//     print_r($search->search(''));
// }catch(XSException $e){
//     echo $e->getMessage(),PHP_EOL; // Failed to recv the data from server completely (SIZE:0/8, REASON:closed)
// }
echo '----------=============', PHP_EOL;
// $search->reopen();
$cmd = array('cmd' => XS_CMD_TIMEOUT, 'arg' => 1);
$search->sendCommand($cmd, XS_CMD_OK_TIMEOUT_SET); // Unexpected respond
sleep(2);
var_dump($search->hasRespond()); // bool(true)
if($search->hasRespond()){
    var_dump($search->respond);
    // object(XSCommand)#18 (5) {
    //     ["cmd"]=>
    //     int(128)
    //     ["arg1"]=>
    //     int(0)
    //     ["arg2"]=>
    //     int(208)
    //     ["buf"]=>
    //     string(0) ""
    //     ["buf1"]=>
    //     string(0) ""
    //   }
}
try{
    
    print_r($search->search(''));
}catch(XSException $e){
    echo $e->getMessage(),PHP_EOL; // Failed to recv the data from server completely (SIZE:0/8, REASON:closed)
}