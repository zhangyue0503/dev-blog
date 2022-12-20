<?php

require_once 'vendor/autoload.php';

use TeamTNT\TNTSearch\TNTSearch;
use TeamTNT\TNTSearch\Support\AbstractTokenizer;
use TeamTNT\TNTSearch\Support\TokenizerInterface;


class JiebaTokenizer extends AbstractTokenizer implements TokenizerInterface
{
    public function tokenize($text,$stopwords='') {
        ini_set("memory_limit", "-1");
        \Fukuball\Jieba\Jieba::init();
        \Fukuball\Jieba\Finalseg::init();
        return \Fukuball\Jieba\Jieba::cut($text);;
    }
}

$tnt = new TNTSearch;

$tnt->loadConfig([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'zyblog',
    'username'  => 'root',
    'password'  => '',
    'storage'   => './',
    'tokenizer' => JiebaTokenizer::class,
    'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);








if ($argv[1] == 1){
    $indexer = $tnt->createIndex('zyblog');
    $indexer->query('SELECT * FROM zy_articles_xs_test where status = 1 limit 10;');
    $indexer->run();
}else if ($argv[1] == 2){
    $tnt->selectIndex("zyblog");
    $res = $tnt->search("链表", 10);
    print_r($res);
    // Array
    // (
    //     [ids] => Array
    //         (
    //             [0] => 4
    //             [1] => 5
    //             [2] => 2
    //             [3] => 6
    //             [4] => 7
    //             [5] => 1
    //             [6] => 8
    //         )

    //     [hits] => 7
    //     [docScores] => Array
    //         (
    //             [4] => 0.70105075187958
    //             [5] => 0.69908289011992
    //             [2] => 0.68591335372833
    //             [6] => 0.57067991030197
    //             [7] => 0.47556659191831
    //             [1] => 0.35667494393873
    //             [8] => 0.35667494393873
    //         )

    //     [execution_time] => 533.8249 ms
    // )

}
