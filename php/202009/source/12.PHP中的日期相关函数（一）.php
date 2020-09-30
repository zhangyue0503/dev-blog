<?php

$timezone = new DateTimeZone('Asia/Shanghai');
var_dump($timezone);
// object(DateTimeZone)#1 (2) {
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }

// 时区相关的定位信息
var_dump($timezone->getLocation());
// array(4) {
//     ["country_code"]=>
//     string(2) "CN"
//     ["latitude"]=>
//     float(31.23333)
//     ["longitude"]=>
//     float(121.46666)
//     ["comments"]=>
//     string(12) "Beijing Time"
//   }

// 时区名称
var_dump($timezone->getName());
// string(13) "Asia/Shanghai"

// 相对于 GMT 的时差
var_dump($timezone->getOffset(new DateTime('now', $timezone)));
// int(28800)

// 所有时区转换信息
var_dump($timezone->getTransitions(time()));
// array(1) {
//     [0]=>
//     array(5) {
//       ["ts"]=>
//       int(1601168813)
//       ["time"]=>
//       string(24) "2020-09-27T01:06:53+0000"
//       ["offset"]=>
//       int(28800)
//       ["isdst"]=>
//       bool(false)
//       ["abbr"]=>
//       string(3) "CST"
//     }
//   }

echo '++++++++++++++', PHP_EOL;

// 包含 dst (夏令时)，时差和时区信息的关联数组
var_dump(DateTimeZone::listAbbreviations());
// array(144) {
//     ["acdt"]=>
//     array(6) {
//       [0]=>
//       array(3) {
//         ["dst"]=>
//         bool(true)
//         ["offset"]=>
//         int(37800)
//         ["timezone_id"]=>
//         string(18) "Australia/Adelaide"
//       }
//       [1]=>
//       array(3) {
//         ["dst"]=>
//         bool(true)
//         ["offset"]=>
//         int(37800)
//         ["timezone_id"]=>
//         string(21) "Australia/Broken_Hill"
//       }
//     ……
//     ……

// 包含了所有时区标示符的索引数组
var_dump(DateTimeZone::listIdentifiers());
// array(426) {
//     [0]=>
//     string(14) "Africa/Abidjan"
//     [1]=>
//     string(12) "Africa/Accra"
//     [2]=>
//     string(18) "Africa/Addis_Ababa"
//     [3]=>
//     string(14) "Africa/Algiers"
//     ……
//     ……

// 时间间隔对象
$interval = new DateInterval("P2D");
var_dump($interval);
// object(DateInterval)#2 (16) {
//     ["y"]=>
//     int(0)
//     ["m"]=>
//     int(0)
//     ["d"]=>
//     int(2)
//     ["h"]=>
//     int(0)
//     ["i"]=>
//     int(0)
//     ["s"]=>
//     int(0)
//     ["f"]=>
//     float(0)
//     ["weekday"]=>
//     int(0)
//     ["weekday_behavior"]=>
//     int(0)
//     ["first_last_day_of"]=>
//     int(0)
//     ["invert"]=>
//     int(0)
//     ["days"]=>
//     bool(false)
//     ["special_type"]=>
//     int(0)
//     ["special_amount"]=>
//     int(0)
//     ["have_weekday_relative"]=>
//     int(0)
//     ["have_special_relative"]=>
//     int(0)
//   }

// diff() 函数获取的时间间隔对象
$today = new DateTime('2020-09-27');
$beforeYestoday = new DateTime("2020-09-25");
var_dump($today->diff($beforeYestoday));
// object(DateInterval)#5 (16) {
//     ["y"]=>
//     int(0)
//     ["m"]=>
//     int(0)
//     ["d"]=>
//     int(2)
//     ["h"]=>
//     int(0)
//     ["i"]=>
//     int(0)
//     ["s"]=>
//     int(0)
//     ["f"]=>
//     float(0)
//     ["weekday"]=>
//     int(0)
//     ["weekday_behavior"]=>
//     int(0)
//     ["first_last_day_of"]=>
//     int(0)
//     ["invert"]=>
//     int(1)
//     ["days"]=>
//     int(2)
//     ["special_type"]=>
//     int(0)
//     ["special_amount"]=>
//     int(0)
//     ["have_weekday_relative"]=>
//     int(0)
//     ["have_special_relative"]=>
//     int(0)
//   }

// 从日期语句创建时间间隔
var_dump(DateInterval::createFromDateString('2 days'));
// object(DateInterval)#3 (16) {
//     ["y"]=>
//     int(0)
//     ["m"]=>
//     int(0)
//     ["d"]=>
//     int(2)
//     ["h"]=>
//     int(0)
//     ["i"]=>
//     int(0)
//     ["s"]=>
//     int(0)
//     ["f"]=>
//     float(0)
//     ["weekday"]=>
//     int(0)
//     ["weekday_behavior"]=>
//     int(0)
//     ["first_last_day_of"]=>
//     int(0)
//     ["invert"]=>
//     int(0)
//     ["days"]=>
//     bool(false)
//     ["special_type"]=>
//     int(0)
//     ["special_amount"]=>
//     int(0)
//     ["have_weekday_relative"]=>
//     int(0)
//     ["have_special_relative"]=>
//     int(0)
//   }



$interval = new DateInterval("P2Y4DT6H8M");
var_dump($interval);
// object(DateInterval)#5 (16) {
//     ["y"]=>
//     int(2)
//     ["m"]=>
//     int(0)
//     ["d"]=>
//     int(4)
//     ["h"]=>
//     int(6)
//     ["i"]=>
//     int(8)
//     ["s"]=>
//     int(0)
//     ["f"]=>
//     float(0)
//     ["weekday"]=>
//     int(0)
//     ["weekday_behavior"]=>
//     int(0)
//     ["first_last_day_of"]=>
//     int(0)
//     ["invert"]=>
//     int(0)
//     ["days"]=>
//     bool(false)
//     ["special_type"]=>
//     int(0)
//     ["special_amount"]=>
//     int(0)
//     ["have_weekday_relative"]=>
//     int(0)
//     ["have_special_relative"]=>
//     int(0)
//   }

// 格式化输出时间间隔
var_dump($interval->format('%y %d %h %i'));
// string(7) "2 4 6 8"

// 时间周期
$start = new DateTime('2020-09-01');
$interval = new DateInterval('P7D');
$end = new DateTime('2020-09-30');
$daterange = new DatePeriod($start, $interval ,$end);
var_dump($daterange);
// object(DatePeriod)#7 (6) {
//     ["start"]=>
//     object(DateTime)#8 (3) {
//       ["date"]=>
//       string(26) "2020-09-01 00:00:00.000000"
//       ["timezone_type"]=>
//       int(3)
//       ["timezone"]=>
//       string(13) "Asia/Shanghai"
//     }
//     ["current"]=>
//     NULL
//     ["end"]=>
//     object(DateTime)#9 (3) {
//       ["date"]=>
//       string(26) "2020-09-30 00:00:00.000000"
//       ["timezone_type"]=>
//       int(3)
//       ["timezone"]=>
//       string(13) "Asia/Shanghai"
//     }
//     ["interval"]=>
//     object(DateInterval)#10 (16) {
//       ["y"]=>
//       int(0)
//       ["m"]=>
//       int(0)
//       ["d"]=>
//       int(7)
//       ["h"]=>
//       int(0)
//       ["i"]=>
//       int(0)
//       ["s"]=>
//       int(0)
//       ["f"]=>
//       float(0)
//       ["weekday"]=>
//       int(0)
//       ["weekday_behavior"]=>
//       int(0)
//       ["first_last_day_of"]=>
//       int(0)
//       ["invert"]=>
//       int(0)
//       ["days"]=>
//       bool(false)
//       ["special_type"]=>
//       int(0)
//       ["special_amount"]=>
//       int(0)
//       ["have_weekday_relative"]=>
//       int(0)
//       ["have_special_relative"]=>
//       int(0)
//     }
//     ["recurrences"]=>
//     int(1)
//     ["include_start_date"]=>
//     bool(true)
//   }


foreach($daterange as $date){
    echo $date->format("Ymd"), PHP_EOL;
}
// 20200901
// 20200908
// 20200915
// 20200922
// 20200929

var_dump($daterange->getDateInterval());
// object(DateInterval)#11 (16) {
//     ["y"]=>
//     int(0)
//     ["m"]=>
//     int(0)
//     ["d"]=>
//     int(7)
//     ["h"]=>
//     int(0)
//     ["i"]=>
//     int(0)
//     ["s"]=>
//     int(0)
//     ["f"]=>
//     float(0)
//     ["weekday"]=>
//     int(0)
//     ["weekday_behavior"]=>
//     int(0)
//     ["first_last_day_of"]=>
//     int(0)
//     ["invert"]=>
//     int(0)
//     ["days"]=>
//     bool(false)
//     ["special_type"]=>
//     int(0)
//     ["special_amount"]=>
//     int(0)
//     ["have_weekday_relative"]=>
//     int(0)
//     ["have_special_relative"]=>
//     int(0)
//   }

var_dump($daterange->getStartDate());
// object(DateTime)#11 (3) {
//     ["date"]=>
//     string(26) "2020-09-01 00:00:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }
var_dump($daterange->getEndDate());
// object(DateTime)#11 (3) {
//     ["date"]=>
//     string(26) "2020-09-30 00:00:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }

$period = new DatePeriod($start, $interval, 7);
foreach($period as $date){
    echo $date->format("Ymd"), PHP_EOL;
}
// 20200901
// 20200908
// 20200915
// 20200922
// 20200929

var_dump($period->getRecurrences());
// int(4)