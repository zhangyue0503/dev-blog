<?php

require_once 'vendor/autoload.php';

$xs = new XS("./config/demo3_56.101.ini");

if ($argv[1] == 1){
    print_r($xs->index);
    print_r($xs->index->getCustomDict());

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

    var_dump($xs->search->search('话说'));

    var_dump((new XSTokenizerJieba())->getTokens('俗话说，无三不成礼，所以就有了第三篇'));
    // array(11) {
    //     [0]=>
    //     string(9) "俗话说"
    //     [1]=>
    //     string(3) "，"
    //     [2]=>
    //     string(6) "无三"
    //     [3]=>
    //     string(6) "不成"
    //     [4]=>
    //     string(3) "礼"
    //     [5]=>
    //     string(3) "，"
    //     [6]=>
    //     string(6) "所以"
    //     [7]=>
    //     string(3) "就"
    //     [8]=>
    //     string(3) "有"
    //     [9]=>
    //     string(3) "了"
    //     [10]=>
    //     string(9) "第三篇"
    //   }

    var_dump((new XSTokenizerScws)->getResult('俗话说，无三不成礼，所以就有了第三篇'));
    //   array(16) {
    //     [0]=>
    //     array(3) {
    //       ["off"]=>
    //       int(0)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(9) "俗话说"
    //     }
    //     [1]=>
    //     array(3) {
    //       ["off"]=>
    //       int(0)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(6) "俗话"
    //     }
    //     [2]=>
    //     array(3) {
    //       ["off"]=>
    //       int(3)
    //       ["attr"]=>
    //       string(4) "n"
    //       ["word"]=>
    //       string(6) "话说"
    //     }
    //  ………………………………
    //  ………………………………
}
