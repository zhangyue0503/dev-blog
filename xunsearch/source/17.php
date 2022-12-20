<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/demo3_56.101.ini");

if ($argv[1] == 1){
    print_r($xs->index->getCutomDict());

    $dict = <<<EOF
    无三不
    无三不成 0 0 n
    EOF;
    print_r($xs->index->setCustomDict($dict));

    print_r($xs->index->getCustomDict());
    // 无三不
    // 无三不成 0 0 n

    $tokenizer = new XSTokenizerScws();   // 直接创建实例
    $words = $tokenizer->getResult("俗话说，无三不成礼，所以就有了第三篇");
    foreach($words as $w){
        echo $w['word']."/".$w['attr']."/".$w['off'],"  ";
    }
    // 话说/n/0  俗话/n/0  话说/n/3  ，/un/9  无三不成/n/12  无三不/@/12  不成/d/18  礼/n/24  ，/un/27  所以/c/30  就/d/36  就有/v/36  有了/v/39  了第/m/42  第三/m/45  三篇/q/48
} else if($argv[1]==2){
    var_dump($xs->getFieldTitle()->getCustomTokenizer());
    // object(XSTokenizerJieba)#9 (0) {}

    var_dump((new XSTokenizerJieba())->getTokens('俗话说，无三不成礼，所以就有了第三篇'));
    // array(7) {
    //     [0]=>
    //     string(3) "我"
    //     [1]=>
    //     string(3) "是"
    //     [2]=>
    //     string(6) "中国"
    //     [3]=>
    //     string(3) "人"
    //     [4]=>
    //     string(3) "，"
    //     [5]=>
    //     string(21) "中华人民共和国"
    //     [6]=>
    //     string(3) "！"
    //   }

    var_dump((new XSTokenizerScws)->getResult('俗话说，无三不成礼，所以就有了第三篇'));
    // array(11) {
    //     [0]=>
    //     array(3) {
    //       ["off"]=>
    //       int(0)
    //       ["attr"]=>
    //       string(4) "v"
    //       ["word"]=>
    //       string(6) "我是"
    //     }
    //     [1]=>
    //     array(3) {
    //       ["off"]=>
    //       int(3)
    //       ["attr"]=>
    //       string(4) "v"
    //       ["word"]=>
    //       string(3) "是"
    //     }
    //     [2]=>
    //     array(3) {
    //       ["off"]=>
    //       int(6)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(9) "中国人"
    //     }
    //     [3]=>
    //     array(3) {
    //       ["off"]=>
    //       int(6)
    //       ["attr"]=>
    //       string(4) "ns"
    //       ["word"]=>
    //       string(6) "中国"
    //     }
    //     [4]=>
    //     array(3) {
    //       ["off"]=>
    //       int(9)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(6) "国人"
    //     }
    //     [5]=>
    //     array(3) {
    //       ["off"]=>
    //       int(15)
    //       ["attr"]=>
    //       string(4) "un"
    //       ["word"]=>
    //       string(3) "，"
    //     }
    //     [6]=>
    //     array(3) {
    //       ["off"]=>
    //       int(18)
    //       ["attr"]=>
    //       string(4) "ns"
    //       ["word"]=>
    //       string(21) "中华人民共和国"
    //     }
    //     [7]=>
    //     array(3) {
    //       ["off"]=>
    //       int(18)
    //       ["attr"]=>
    //       string(4) "nz"
    //       ["word"]=>
    //       string(6) "中华"
    //     }
    //     [8]=>
    //     array(3) {
    //       ["off"]=>
    //       int(24)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(6) "人民"
    //     }
    //     [9]=>
    //     array(3) {
    //       ["off"]=>
    //       int(30)
    //       ["attr"]=>
    //       string(4) "ns"
    //       ["word"]=>
    //       string(9) "共和国"
    //     }
    //     [10]=>
    //     array(3) {
    //       ["off"]=>
    //       int(39)
    //       ["attr"]=>
    //       string(4) "un"
    //       ["word"]=>
    //       string(3) "！"
    //     }
    //   }
}
