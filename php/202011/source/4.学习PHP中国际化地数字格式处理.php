<?php

$localeArr = ['en_US', 'zh_CN', 'ja_JP', 'de_DE', 'fr_FR', 'ar-IQ', 'ru_RU'];

foreach ($localeArr as $locale) {
    $fmt = new NumberFormatter($locale, NumberFormatter::DECIMAL);
    echo $locale . '：', $fmt->format(1234567.891234567890000), PHP_EOL;
}
// en_US：1,234,567.891
// zh_CN：1,234,567.891
// ja_JP：1,234,567.891
// de_DE：1.234.567,891
// fr_FR：1 234 567,891
// ar-IQ：١٬٢٣٤٬٥٦٧٫٨٩١
// ru_RU：1 234 567,891

foreach ($localeArr as $locale) {
    $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    echo $locale . '：', $fmt->format(1234567.891234567890000), PHP_EOL;
    echo $locale . '：', $fmt->formatCurrency(1234567.891234567890000, 'RUR'), PHP_EOL;
}
// en_US：$1,234,567.89
// en_US：RUR 1,234,567.89
// zh_CN：￥1,234,567.89
// zh_CN：RUR 1,234,567.89
// ja_JP：￥1,234,568
// ja_JP：RUR 1,234,567.89
// de_DE：1.234.567,89 €
// de_DE：1.234.567,89 RUR
// fr_FR：1 234 567,89 €
// fr_FR：1 234 567,89 RUR
// ar-IQ：١٬٢٣٤٬٥٦٨ د.ع.‏
// ar-IQ：١٬٢٣٤٬٥٦٧٫٨٩ RUR
// ru_RU：1 234 567,89 ₽
// ru_RU：1 234 567,89 р.

$fmt = new NumberFormatter('zh_CN', NumberFormatter::PERCENT);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 123 456 789 %

$fmt = new NumberFormatter('zh_CN', NumberFormatter::SCIENTIFIC);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1,2345678912345679E6

$fmt = new NumberFormatter('zh_Hant_CN', NumberFormatter::SPELLOUT);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 一百二十三万四千五百六十七点八九一二三四五六七九

$fmt = new NumberFormatter('zh_CN', NumberFormatter::SPELLOUT);
echo $fmt->format(1234502.891234567890000), PHP_EOL; // 一百二十三万四千五百〇二点八九一二三四五六七九

$fmt = new NumberFormatter('zh_CN', NumberFormatter::ORDINAL);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 第1,234,568

$fmt = new NumberFormatter('zh_CN', NumberFormatter::DURATION);
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1,234,568

var_dump($fmt->getPattern()); // string(8) "#,##0.##"
$fmt->setPattern("#0.# kg");
var_dump($fmt->getPattern()); // string(6) "0.# kg"
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1234567.9 kg

$fmt->setPattern("#,##0.###");



$fmt = new NumberFormatter( 'zh_CN', NumberFormatter::DECIMAL );
echo "Digits: ".$fmt->getAttribute(NumberFormatter::MAX_FRACTION_DIGITS), PHP_EOL; // Digits: 3
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1,234,567.891

$fmt->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);
echo "Digits: ".$fmt->getAttribute(NumberFormatter::MAX_FRACTION_DIGITS), PHP_EOL; // Digits: 2
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1,234,567.89

var_dump($fmt->getLocale(Locale::VALID_LOCALE)); // string(10) "zh_Hans_CN"

var_dump($fmt->getLocale(Locale::ACTUAL_LOCALE)); // string(10) "zh_Hans_CN"




var_dump($fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL)); // string(1) ","
$fmt->setSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL, "*");
var_dump($fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL)); // string(1) "*"
echo $fmt->format(1234567.891234567890000), PHP_EOL; // 1*234*567.891


$fmt->setSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL, ",");


var_dump($fmt->getTextAttribute(NumberFormatter::NEGATIVE_PREFIX));
echo $fmt->format(-1234567.891234567890000), PHP_EOL; // string(1) "-"
$fmt->setTextAttribute(NumberFormatter::NEGATIVE_PREFIX, "负号 ");
var_dump($fmt->getTextAttribute(NumberFormatter::NEGATIVE_PREFIX)); // string(7) "负号 "
echo $fmt->format(-1234567.891234567890000), PHP_EOL; // 负号 1,234,567.891


$fmt = new NumberFormatter( 'zh_CN', NumberFormatter::DECIMAL );
$num = "1,234,567.891";
echo $fmt->parse($num)."\n"; // 1234567.891
echo $fmt->parse($num, NumberFormatter::TYPE_INT32)."\n"; // 1234567


$fmt = new NumberFormatter( 'zh_CN', NumberFormatter::CURRENCY );
echo $fmt->parseCurrency('￥1,234,567.89', $currency), PHP_EOL; // 1234567.89
var_dump($currency); // string(3) "CNY"


echo $fmt->parseCurrency('1,234,567.89', $currency), PHP_EOL;
var_dump($fmt->getErrorCode()); // int(9)
var_dump(intl_is_failure($fmt->getErrorCode())); // bool(true)
var_dump($fmt->getErrorMessage()); // string(36) "Number parsing failed: U_PARSE_ERROR"