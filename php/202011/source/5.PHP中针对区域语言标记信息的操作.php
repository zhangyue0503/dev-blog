<?php
// # echo $LANG;
// en_US.UTF-8

// php.ini
// intl.default_locale => no value => no value

echo Locale::getDefault(), PHP_EOL; // en_US_POSIX
ini_set('intl.default_locale', 'zh_CN');
echo Locale::getDefault(), PHP_EOL; // zh_CN
Locale::setDefault('fr');
echo Locale::getDefault(), PHP_EOL; // fr

// https://www.zhihu.com/question/20797118/answer/63480740

echo Locale::getDisplayLanguage('cmn-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // cmn
echo Locale::getDisplayLanguage('zh-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 中文

echo Locale::getDisplayName('cmn-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // cmn（简体，中国，LATN_PINYIN）
echo Locale::getDisplayName('zh-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 中文（简体，中国，LATN_PINYIN）

echo Locale::getDisplayRegion('cmn-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 中国
echo Locale::getDisplayRegion('zh-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 中国

echo Locale::getDisplayScript('cmn-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 简体中文
echo Locale::getDisplayScript('zh-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // 简体中文

echo Locale::getDisplayVariant('cmn-Hant-Latn-pinyin', 'zh_CN'), PHP_EOL; // LATN_PINYIN
echo Locale::getDisplayVariant('zh-Hans-CN-Latn-pinyin', 'zh_CN'), PHP_EOL; // LATN_PINYIN

$fmt = new NumberFormatter('zh-Hant', NumberFormatter::SPELLOUT);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 一百二十三萬四千五百六十七點八九一二三四五六七九

echo Locale::getPrimaryLanguage('zh-Hans-CN-Latn-pinyin'), PHP_EOL; // zh

echo Locale::getRegion('zh-Hans-CN-Latn-pinyin'), PHP_EOL; // CN

echo Locale::getScript('zh-Hans-CN-Latn-pinyin'), PHP_EOL; // Hans

echo Locale::canonicalize('zh-Hans-CN-Latn-pinyin'), PHP_EOL; // zh_Hans_CN_LATN_PINYIN

$arr = Locale::getAllVariants('zh-Hans-CN-Latn-pinyin');
var_export($arr);
echo PHP_EOL;
//  array (
//     0 => 'LATN',
//     1 => 'PINYIN',
//   )

$keywords_arr = Locale::getKeywords('zh-cn@currency=CMY;collation=UTF-8');
if ($keywords_arr) {
    foreach ($keywords_arr as $key => $value) {
        echo "$key = $value", PHP_EOL;
    }
}
// collation = UTF-8
// currency = CMY

$arr = Locale::parseLocale('zh-Hans-CN-Latn-pinyin');
if ($arr) {
    foreach ($arr as $key => $value) {
        echo "$key : $value ", PHP_EOL;
    }
}
// language : zh
// script : Hans
// region : CN
// variant0 : LATN
// variant1 : PINYIN

$arr = [
    'zh-hans',
    'zh-hant',
    'zh',
    'zh-cn',
];
echo Locale::lookup($arr, 'zh-Hans-CN-Latn-pinyin', true, 'en_US'), PHP_EOL; // zh_hans

echo (Locale::filterMatches('cmn-CN', 'zh-CN', false)) ? "Matches" : "Does not match", PHP_EOL;
echo (Locale::filterMatches('zh-CN-Latn', 'zh-CN', false)) ? "Matches" : "Does not match", PHP_EOL;

$arr = [
    'language' => 'en',
    'script' => 'Hans',
    'region' => 'CN',
    'variant2' => 'rozaj',
    'variant1' => 'nedis',
    'private1' => 'prv1',
    'private2' => 'prv2',
];
echo Locale::composeLocale($arr), PHP_EOL; // en_Hans_CN_nedis_rozaj_x_prv1_prv2



// Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);

echo Locale::acceptFromHttp('en_US'), PHP_EOL; // en_US
echo Locale::acceptFromHttp('en_AU'), PHP_EOL; // en_AU

echo Locale::acceptFromHttp('zh_CN'), PHP_EOL; // zh
echo Locale::acceptFromHttp('zh_TW'), PHP_EOL; // zh
