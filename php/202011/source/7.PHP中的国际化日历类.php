<?php

ini_set('intl.default_locale', 'de_DE');
ini_set('date.timezone', 'Europe/Berlin');

$cal = IntlCalendar::createInstance(IntlTimeZone::getGMT());
var_dump(get_class($cal), IntlDateFormatter::formatObject($cal, IntlDateFormatter::FULL));
// string(21) "IntlGregorianCalendar"
// string(63) "Mittwoch, 18. November 2020 um 00:58:14 Mittlere Greenwich-Zeit"


ini_set('intl.default_locale', 'zh_CN');
ini_set('date.timezone', 'Asia/Shanghai');

$cal = IntlCalendar::createInstance(IntlTimeZone::getGMT());
var_dump(get_class($cal), IntlDateFormatter::formatObject($cal, IntlDateFormatter::FULL));
// string(21) "IntlGregorianCalendar"
// string(66) "2020年11月18日星期三 格林尼治标准时间 上午12:58:14"

$cal1 = IntlCalendar::fromDateTime('2013-02-28 00:01:02 Europe/Berlin');
var_dump(get_class($cal1), IntlDateFormatter::formatObject($cal1, 'yyyy MMMM d HH:mm:ss VVVV', 'de_DE'));
// string(21) "IntlGregorianCalendar"
// string(41) "2013 Februar 28 00:01:02 Deutschland Zeit"

echo IntlCalendar::getNow(), PHP_EOL; // 1605661094417

// 时区设置
ini_set('intl.default_locale', 'de_DE');
ini_set('date.timezone', 'Europe/Berlin');
$cal = IntlCalendar::createInstance();
print_r($cal->getTimeZone());
// IntlTimeZone Object
// (
//     [valid] => 1
//     [id] => Europe/Berlin
//     [rawOffset] => 3600000
//     [currentOffset] => 3600000
// )

echo $cal->getLocale(Locale::ACTUAL_LOCALE), PHP_EOL; // de
echo $cal->getLocale(Locale::VALID_LOCALE), PHP_EOL; // de_DE

ini_set('intl.default_locale', 'zh_CN');
ini_set('date.timezone', 'Asia/Shanghai');
$cal = IntlCalendar::createInstance();
print_r($cal->getTimeZone());
// IntlTimeZone Object
// (
//     [valid] => 1
//     [id] => Asia/Shanghai
//     [rawOffset] => 28800000
//     [currentOffset] => 28800000
// )

$cal->setTimeZone('UTC');
print_r($cal->getTimeZone());
// IntlTimeZone Object
// (
//     [valid] => 1
//     [id] => UTC
//     [rawOffset] => 0
//     [currentOffset] => 0
// )

echo $cal->getLocale(Locale::ACTUAL_LOCALE), PHP_EOL; // zh
echo $cal->getLocale(Locale::VALID_LOCALE), PHP_EOL; // zh_Hans_CN

$cal = IntlCalendar::fromDateTime('2020-02-15');
var_dump($cal->getActualMaximum(IntlCalendar::FIELD_DAY_OF_MONTH)); //29
var_dump($cal->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH)); //31
var_dump($cal->getActualMinimum(IntlCalendar::FIELD_DAY_OF_MONTH)); //1
var_dump($cal->getMinimum(IntlCalendar::FIELD_DAY_OF_MONTH)); //1
var_dump($cal->getLeastMaximum(IntlCalendar::FIELD_DAY_OF_MONTH));// 28 

$cal->add(IntlCalendar::FIELD_EXTENDED_YEAR, -1);
var_dump($cal->getActualMaximum(IntlCalendar::FIELD_DAY_OF_MONTH)); //28
var_dump($cal->getMaximum(IntlCalendar::FIELD_DAY_OF_MONTH)); //31
var_dump($cal->getActualMinimum(IntlCalendar::FIELD_DAY_OF_MONTH)); //1
var_dump($cal->getMinimum(IntlCalendar::FIELD_DAY_OF_MONTH)); //1
var_dump($cal->getLeastMaximum(IntlCalendar::FIELD_DAY_OF_MONTH));// 28 

$cal = IntlCalendar::createInstance();
$cal->set(2020, 5 /* 六月 */, 30); // 周二
var_dump($cal->getFirstDayOfWeek()); // int(1)
echo IntlDateFormatter::formatObject($cal, <<<EOD
'local day of week: 'cc'
week of month    : 'W'
week of year     : 'ww
EOD
), PHP_EOL;
// local day of week: 3
// week of month    : 5
// week of year     : 27

var_dump(IntlDateFormatter::formatObject($cal, "'Week 'w' of 'Y")); // string(15) "Week 26 of 2020"

var_dump($cal->getRepeatedWalltimeOption()); // int(0)

var_dump($cal->getSkippedWalltimeOption()); // int(0)

$cal->setFirstDayOfWeek(3);
var_dump($cal->getFirstDayOfWeek());  // int(3)
echo IntlDateFormatter::formatObject($cal, <<<EOD
'local day of week: 'cc'
week of month    : 'W'
week of year     : 'ww
EOD
), PHP_EOL;



$cal->setMinimalDaysInFirstWeek(6);
var_dump(IntlDateFormatter::formatObject($cal, "'Week 'w' of 'Y"));
// string(15) "Week 26 of 2020"

$cal->setRepeatedWalltimeOption(IntlCalendar::WALLTIME_FIRST);
var_dump($cal->getRepeatedWalltimeOption());
// int(1)

$cal->setSkippedWallTimeOption(IntlCalendar::WALLTIME_FIRST);
var_dump($cal->getSkippedWalltimeOption());
// int(1)



$cal1 = IntlCalendar::createInstance();
$cal2 = IntlCalendar::createInstance();
var_dump($cal1->equals($cal2)); // bool(true)
$cal2->setTime($cal1->getTime() + 1);
var_dump($cal1->equals($cal2)); // bool(false)


$cal1 = IntlCalendar::fromDateTime('2019-1-29 09:00:11');
$cal2 = IntlCalendar::fromDateTime('2020-03-01 09:19:29');
$time = $cal2->getTime();

echo "之前的时间: ", IntlDateFormatter::formatObject($cal1), "\n";
// 之前的时间: 2019年1月29日 上午9:00:11

printf(
    "两个时间的差别： %d year(s), %d month(s), "
  . "%d day(s), %d hour(s) and %d minute(s)\n",
    $cal1->fieldDifference($time, IntlCalendar::FIELD_YEAR),
    $cal1->fieldDifference($time, IntlCalendar::FIELD_MONTH),
    $cal1->fieldDifference($time, IntlCalendar::FIELD_DAY_OF_MONTH),
    $cal1->fieldDifference($time, IntlCalendar::FIELD_HOUR_OF_DAY),
    $cal1->fieldDifference($time, IntlCalendar::FIELD_MINUTE)
);
// 两个时间的差别： 1 year(s), 1 month(s), 1 day(s), 0 hour(s) and 19 minute(s)


echo "之后的时间: ", IntlDateFormatter::formatObject($cal1), "\n";
// 之后的时间: 2020年3月1日 上午9:19:11


print_r(iterator_to_array(IntlCalendar::getKeywordValuesForLocale('calendar', 'zh_CN', true)));
// Array
// (
//     [0] => gregorian
//     [1] => chinese
// )
print_r(iterator_to_array(IntlCalendar::getKeywordValuesForLocale('calendar', 'zh_CN', false)));
// Array
// (
//     [0] => gregorian
//     [1] => chinese
//     [2] => japanese
//     [3] => buddhist
//     [4] => roc
//     [5] => persian
//     [6] => islamic-civil
//     [7] => islamic
//     [8] => hebrew
//     [9] => indian
//     [10] => coptic
//     [11] => ethiopic
//     [12] => ethiopic-amete-alem
//     [13] => iso8601
//     [14] => dangi
//     [15] => islamic-umalqura
//     [16] => islamic-tbla
//     [17] => islamic-rgsa
// )

$cal = IntlCalendar::createInstance(NULL, '@calendar=ethiopic-amete-alem');
var_dump($cal->getType());
// string(19) "ethiopic-amete-alem"

$cal = new IntlGregorianCalendar();
var_dump($cal->getType());
// string(9) "gregorian"

var_dump(IntlDateFormatter::formatObject($cal)); // string(31) "2020年11月18日 上午9:14:59"

$cal->roll(IntlCalendar::FIELD_DAY_OF_MONTH, true);
var_dump(IntlDateFormatter::formatObject($cal)); // string(31) "2020年11月19日 上午9:14:59"
var_dump($cal->toDateTime());
// object(DateTime)#4 (3) {
//     ["date"]=>
//     string(26) "2020-11-19 09:14:59.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }

print_r(IntlCalendar::getAvailableLocales());
// Array
// (
//     [0] => af
//     [1] => af_NA
//     [2] => af_ZA
//     [3] => agq
//     [4] => agq_CM
//     [5] => ak
//     [6] => ak_GH
//     [7] => am
//     [8] => am_ET
//     [9] => ar
//     ……
//     ……
