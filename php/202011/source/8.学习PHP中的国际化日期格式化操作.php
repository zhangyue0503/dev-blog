<?php

// 格式化，根据时间戳、IntlCalendar对象
$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL,
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN  );
echo "en_US 格式化结果为： ".$fmt->format(time()), PHP_EOL;
// en_US 格式化结果为： Friday, November 20, 2020 at 4:45:06 PM Pacific Standard Time

$fmt = new IntlDateFormatter( "de-DE" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN  );
echo "de_DE 格式化结果为： ".$fmt->format(IntlCalendar::createInstance()), PHP_EOL;
// de_DE 格式化结果为： Freitag, 20. November 2020 um 16:45:06 Nordamerikanische Westküsten-Normalzeit

$fmt = new IntlDateFormatter( "zh-CN" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'Asia/Shanghai',IntlDateFormatter::GREGORIAN  );
echo "zh-CN 格式化结果为： ".$fmt->format(time()), PHP_EOL;
// zh-CN 格式化结果为： 2020年11月21日星期六 中国标准时间 上午8:45:06

$fmt = new IntlDateFormatter( "zh-CN" ,IntlDateFormatter::SHORT, IntlDateFormatter::LONG, 
    'Asia/Shanghai',IntlDateFormatter::GREGORIAN  );
echo "zh-CN 格式化结果为： ".$fmt->format(time()), PHP_EOL;
// zh-CN 格式化结果为： 2020/11/21 GMT+8 上午8:45:06

$fmt = new IntlDateFormatter( "zh-CN" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'Asia/Shanghai',IntlDateFormatter::GREGORIAN, 'yyyy/MM/dd' );
echo "zh-CN 格式化结果为： ".$fmt->format(time()), PHP_EOL;
// zh-CN 格式化结果为： 2020/11/21

// 根据对象格式化，IntlCalendar、DateTime 对象
$cal = IntlCalendar::createInstance(new DateTimeZone('Asia/Shanghai'));
echo IntlDateFormatter::formatObject($cal),PHP_EOL;
// Nov 21, 2020, 8:45:06 AM
echo IntlDateFormatter::formatObject($cal, IntlDateFormatter::FULL),PHP_EOL;
// Saturday, November 21, 2020 at 8:45:06 AM China Standard Time
echo IntlDateFormatter::formatObject($cal, IntlDateFormatter::NONE, IntlDateFormatter::FULL),PHP_EOL;
// 20201121 08:45 AM
echo IntlDateFormatter::formatObject($cal, IntlDateFormatter::FULL, 'zh-CN'),PHP_EOL;
// 2020年11月21日星期六 中国标准时间 上午8:45:06
echo IntlDateFormatter::formatObject($cal, "d 'of' MMMM y", 'zh-CN'), PHP_EOL;
// 21 of 十一月 2020

$dt = new DateTime();
echo IntlDateFormatter::formatObject($dt),PHP_EOL;
// Nov 21, 2020, 8:45:06 AM


// 反解析，获取字符串格式信息及时间戳
$fmt = new IntlDateFormatter( "zh-CN" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'Asia/Shanghai',IntlDateFormatter::GREGORIAN );
$arr = $fmt->localtime("2020年11月20日星期五 中国标准时间 上午8:54:08");
print_r($arr);
// Array
// (
//     [tm_sec] => 8
//     [tm_min] => 54
//     [tm_hour] => 8
//     [tm_year] => 120
//     [tm_mday] => 20
//     [tm_wday] => 5
//     [tm_yday] => 325
//     [tm_mon] => 10
//     [tm_isdst] => 0
// )

echo $fmt->parse("2020年11月20日星期五 中国标准时间 上午8:54:08"), PHP_EOL;
// 1605833648

$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL,
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN  );
$arr = $fmt->localtime($fmt->format(time()));
print_r($arr);
// Array
// (
//     [tm_sec] => 1
//     [tm_min] => 59
//     [tm_hour] => 16
//     [tm_year] => 120
//     [tm_mday] => 20
//     [tm_wday] => 5
//     [tm_yday] => 325
//     [tm_mon] => 10
//     [tm_isdst] => 0
// )

echo $fmt->parse("Thursday, November 19, 2020 at 5:05:41 PM Pacific Standard Time"), PHP_EOL;
// 1605834341

// 日历类型获取及设置
$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN );
echo $fmt->getCalendar(), PHP_EOL; // 1
$fmt->setCalendar(IntlDateFormatter::TRADITIONAL);
echo $fmt->getCalendar(), PHP_EOL; // 0

// 日期类型获取及设置
$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::FULL, IntlDateFormatter::FULL, 
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN );
echo $fmt->getDateType(), PHP_EOL; // 0
$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::SHORT, IntlDateFormatter::FULL, 
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN );
echo $fmt->getDateType(), PHP_EOL; // 3

// 时间类型获取及设置
echo $fmt->getTimeType(), PHP_EOL; // 0
$fmt = new IntlDateFormatter( "en_US" ,IntlDateFormatter::SHORT, IntlDateFormatter::MEDIUM, 
    'America/Los_Angeles',IntlDateFormatter::GREGORIAN );
echo $fmt->getTimeType(), PHP_EOL; // 2

// 获取区域信息
echo $fmt->getLocale(), PHP_EOL; // en
echo $fmt->getLocale(Locale::VALID_LOCALE), PHP_EOL; // en_US

// 格式规则获取及设置
echo $fmt->getPattern(), PHP_EOL; // M/d/yy, h:mm:ss a
$fmt->setPattern('yyyyMMdd hh:mm:ss z');
echo $fmt->getPattern(), PHP_EOL; // yyyyMMdd hh:mm:ss z
echo $fmt->format(time()), PHP_EOL; // 20201120 04:59:01 PST

// 时区类型获取及设置
echo $fmt->getTimezoneId(), PHP_EOL; // America/Los_Angeles
// $fmt->setTimeZoneId('CN'); // PHP7 已删除
// echo $fmt->getTimezoneId(), PHP_EOL;

var_dump($fmt->getTimezone());
// object(IntlTimeZone)#4 (4) {
//     ["valid"]=>
//     bool(true)
//     ["id"]=>
//     string(19) "America/Los_Angeles"
//     ["rawOffset"]=>
//     int(-28800000)
//     ["currentOffset"]=>
//     int(-28800000)
//   }

$fmt->setTimeZone('Asia/Shanghai');
var_dump($fmt->getTimezone());
// object(IntlTimeZone)#4 (4) {
//     ["valid"]=>
//     bool(true)
//     ["id"]=>
//     string(13) "Asia/Shanghai"
//     ["rawOffset"]=>
//     int(28800000)
//     ["currentOffset"]=>
//     int(28800000)
//   }

$fmt->setTimeZone('GMT+00:30');
var_dump($fmt->getTimezone());
// object(IntlTimeZone)#4 (4) {
//     ["valid"]=>
//     bool(true)
//     ["id"]=>
//     string(9) "GMT+00:30"
//     ["rawOffset"]=>
//     int(1800000)
//     ["currentOffset"]=>
//     int(1800000)
//   }

// 获取日历类型对象
$cal = $fmt->getCalendarObject();
var_dump(
    $cal->getType(),
    $cal->getTimeZone(),
    $cal->getLocale(Locale::VALID_LOCALE)
);
// string(9) "gregorian"
// object(IntlTimeZone)#3 (4) {
//   ["valid"]=>
//   bool(true)
//   ["id"]=>
//   string(9) "GMT+00:30"
//   ["rawOffset"]=>
//   int(1800000)
//   ["currentOffset"]=>
//   int(1800000)
// }
// string(5) "en_US"

// 宽容处理及错误信息
$fmt->setPattern('dd/mm/yyyy');
var_dump($fmt->isLenient()); // bool(true)
echo $fmt->parse('35/13/1955'), PHP_EOL;
// -470449020

$fmt->setLenient(FALSE);
echo $fmt->parse('35/13/ 1955'), PHP_EOL;
// 

echo $fmt->getErrorCode(), PHP_EOL; // 9
echo $fmt->getErrorMessage(), PHP_EOL; // Date parsing failed: U_PARSE_ERROR