<?php

$info = cal_info(3);
print_r($info);
// Array
// (
//     [months] => Array
//         (
//             [1] => Tishri
//             [2] => Heshvan
//             [3] => Kislev
//             [4] => Tevet
//             [5] => Shevat
//             [6] => Adar I
//             [7] => Adar II
//             [8] => Nisan
//             [9] => Iyyar
//             [10] => Sivan
//             [11] => Tammuz
//             [12] => Av
//             [13] => Elul
//         )

//     [abbrevmonths] => Array
//         (
//             [1] => Tishri
//             [2] => Heshvan
//             [3] => Kislev
//             [4] => Tevet
//             [5] => Shevat
//             [6] => Adar I
//             [7] => Adar II
//             [8] => Nisan
//             [9] => Iyyar
//             [10] => Sivan
//             [11] => Tammuz
//             [12] => Av
//             [13] => Elul
//         )

//     [maxdaysinmonth] => 30
//     [calname] => Jewish
//     [calsymbol] => CAL_JEWISH
// )

//  转变Unix时间戳为Julian Day计数
$today = unixtojd(mktime(0, 0, 0, 9, 23, 2020));
echo $today, PHP_EOL; // 2459116

// 获取当前犹太历时间
print_r(cal_from_jd($today, CAL_JEWISH));
// Array
// (
//     [date] => 1/5/5781
//     [month] => 1
//     [day] => 5
//     [year] => 5781
//     [dow] => 3
//     [abbrevdayname] => Wed
//     [dayname] => Wednesday
//     [abbrevmonth] => Tishri
//     [monthname] => Tishri
// )

// 从一个支持的历法转变为Julian Day计数
echo cal_to_jd(CAL_JEWISH, 1, 5, 5781), PHP_EOL; // 2459116
echo cal_to_jd(CAL_GREGORIAN,9, 23, 2020), PHP_EOL; // 2459116

// 转变Julian Day计数为一个Unix时间戳
echo date("Y-m-d", jdtounix($today)), PHP_EOL;
// 2020-09-23

// 转变一个Gregorian历法日期到Julian Day计数
$jd = GregorianToJD(9, 23, 2020);

// 转变一个Julian Day计数为Gregorian历法日期
echo jdtogregorian($jd), PHP_EOL; // 9/23/2020
// 转变一个Julian Day计数为Julian历法日期
echo jdtojulian($jd), PHP_EOL; // 9/10/2020
// 转变一个Julian Day计数为犹太历法日期
echo jdtojewish($jd), PHP_EOL; // 1/5/5781
// 转变一个Julian Day计数为unix时间戳
echo jdtounix($jd), PHP_EOL; // 1600819200

$jd = GregorianToJD(9, 23, 1799);
// 转变一个Julian Day计数为French历法日期
echo jdtofrench($jd), PHP_EOL; // 1/1/8


// 返回某个历法中某年中某月的天数
$num = cal_days_in_month(CAL_GREGORIAN, 2, 2020);
echo $num, PHP_EOL; // 29

// 指定年份的复活节时间戳
echo date("M-d-Y", easter_date(2019)), PHP_EOL;        // Apr-21-2019
echo date("M-d-Y", easter_date(2020)), PHP_EOL;        // Apr-12-2020
echo date("M-d-Y", easter_date(2021)), PHP_EOL;        // Apr-04-2021

// 3月21日到复活节之间的天数
echo easter_days(2019), PHP_EOL;        // 31
echo easter_days(2020), PHP_EOL;        // 22
echo easter_days(2021), PHP_EOL;        // 14

