<?php

// // $_SERVER['HTTP_ACCEPT_LANGUAGE'] = zh-CN,zh;q=0.9;
// $browserLocale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);

// print_r($browserLocale);
// echo '<br/>';
// // zh

// $locale = ['en', 'fr-FR', 'da, en-gb;q=0.8, en;q=0.7', 'zh-cn', 'zh-tw', 'en-us', 'en-ca', 'ja-jp'];
// foreach($locale as $code){
//     print_r(Locale::acceptFromHttp($code));
//     echo '<br/>';
// }
// // en
// // fr_FR
// // da
// // zh
// // zh
// // en_US
// // en_CA
// // ja_JP

$locale = ['en', 'fr-FR', 'en-gb', 'zh-cn','en-us', 'ko-kr', 'ja-jp'];

// $money = 1234567.89;

// foreach($locale as $code){
//     $numberformat = new NumberFormatter($code, NumberFormatter::DECIMAL);
//     echo $code, ":";
//     echo $numberformat->format($money), ', ';
//     echo $numberformat->parse($numberformat->format($money)), '<br/>';
// }
// // en:1,234,567.89, 1234567.89
// // fr-FR:1 234 567,89, 
// // en-gb:1,234,567.89, 1234567.89
// // zh-cn:1,234,567.89, 1234567.89
// // en-us:1,234,567.89, 1234567.89
// // ko-kr:1,234,567.89, 1234567.89
// // ja-jp:1,234,567.89, 1234567.89

// foreach($locale as $code){
//     $numberformat = new NumberFormatter($code, NumberFormatter::PERCENT);
//     echo $code, ":";
//     echo $numberformat->format($money), '<br/>';
// }
// // en:¤1,234,567.89
// // fr-FR:1 234 567,89 €
// // en-gb:£1,234,567.89
// // zh-cn:￥1,234,567.89
// // en-us:$1,234,567.89
// // ko-kr:₩1,234,568
// // ja-jp:￥1,234,568


// $date = '2020-09-25 11:05:22';
foreach($locale as $code){
    // $l = new Locale($code);
    
    $d = new IntlDateFormatter($code, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
    $c = IntlCalendar::createInstance(NULL, $code);
    $c->set('2020', '09', '25', '11', '22', '33');
    echo $code, ":";
    echo $d->format($c), PHP_EOL;
}

// en:Friday, September 25, 2020 at 2:48:12 PM China Standard Time
// fr-FR:vendredi 25 septembre 2020 à 14:48:12 heure normale de la Chine
// en-gb:Friday, 25 September 2020 at 14:48:12 China Standard Time
// zh-cn:2020年9月25日星期五 中国标准时间 下午2:48:12
// en-us:Friday, September 25, 2020 at 2:48:12 PM China Standard Time
// ko-kr:2020년 9월 25일 금요일 오후 2시 48분 12초 중국 표준시
// ja-jp:2020年9月25日金曜日 14時48分12秒 中国標準時