<?php

require_once XS_LIB_ROOT . '/../../../autoload.php';

class XSTokenizerJieba implements XSTokenizer
{
    public function __construct($arg = null)
    {

    }

    public function getTokens($value, XSDocument $doc = null)
    {
        // composer require fukuball/jieba-php:dev-master
        ini_set("memory_limit", "-1");
        \Fukuball\Jieba\Jieba::init();
        \Fukuball\Jieba\Finalseg::init();
        return \Fukuball\Jieba\Jieba::cut($value);;
    }
}