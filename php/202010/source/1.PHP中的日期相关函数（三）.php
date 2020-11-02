<?php

var_dump(checkdate(2, 29, 2020)); // bool(true)
var_dump(checkdate(2, 29, 2021)); // bool(false)

var_dump(date_default_timezone_get()); // string(13) "Asia/Shanghai"

var_dump(date("Y-m-d H:i:s")); // string(19) "2020-10-09 08:41:11"

date_default_timezone_set("Asia/Tokyo");

var_dump(date("Y-m-d H:i:s")); // string(19) "2020-10-09 09:41:11"

print_r(date_parse("2020-12-12 10:00:00.5"));
// Array
// (
//     [year] => 2020
//     [month] => 12
//     [day] => 12
//     [hour] => 10
//     [minute] => 0
//     [second] => 0
//     [fraction] => 0.5
//     [warning_count] => 0
//     [warnings] => Array
//         (
//         )

//     [error_count] => 0
//     [errors] => Array
//         (
//         )

//     [is_localtime] => 
// )

$date = "6.1.2020 13:00+01:00";
print_r(date_parse_from_format("j.n.Y H:iP", $date));
// Array
// (
//     [year] => 2020
//     [month] => 1
//     [day] => 6
//     [hour] => 13
//     [minute] => 0
//     [second] => 0
//     [fraction] => 0
//     [warning_count] => 0
//     [warnings] => Array
//         (
//         )

//     [error_count] => 0
//     [errors] => Array
//         (
//         )

//     [is_localtime] => 1
//     [zone_type] => 1
//     [zone] => 3600
//     [is_dst] => 
// )


$sun_info = date_sun_info(strtotime("2020-12-12"), 113.037211, 28.203167);
foreach ($sun_info as $key => $val) {
    echo "$key: " . date("H:i:s", $val) . "\n";
}

// sunrise: 08:03:54
// sunset: 05:58:14
// transit: 19:01:04
// civil_twilight_begin: 09:58:56
// civil_twilight_end: 04:03:11
// nautical_twilight_begin: 11:20:07
// nautical_twilight_end: 02:42:01
// astronomical_twilight_begin: 12:27:37
// astronomical_twilight_end: 01:34:31

var_dump(getdate());
// array(11) {
//     ["seconds"]=>
//     int(15)
//     ["minutes"]=>
//     int(52)
//     ["hours"]=>
//     int(9)
//     ["mday"]=>
//     int(9)
//     ["wday"]=>
//     int(5)
//     ["mon"]=>
//     int(10)
//     ["year"]=>
//     int(2020)
//     ["yday"]=>
//     int(282)
//     ["weekday"]=>
//     string(6) "Friday"
//     ["month"]=>
//     string(7) "October"
//     [0]=>
//     int(1602204735)
//   }

var_dump(gettimeofday());
// array(4) {
//     ["sec"]=>
//     int(1602205147)
//     ["usec"]=>
//     int(625261)
//     ["minuteswest"]=>
//     int(-540)
//     ["dsttime"]=>
//     int(0)
//   }

var_dump(gettimeofday(true)); // float(1602205147.6253)



$localtime = localtime();
$localtime_assoc = localtime(time(), true);
print_r($localtime);
// Array
// (
//     [0] => 14
//     [1] => 3
//     [2] => 10
//     [3] => 9
//     [4] => 9
//     [5] => 120
//     [6] => 5
//     [7] => 282
//     [8] => 0
// )
print_r($localtime_assoc);
// Array
// (
//     [tm_sec] => 14
//     [tm_min] => 3
//     [tm_hour] => 10
//     [tm_mday] => 9
//     [tm_mon] => 9
//     [tm_year] => 120
//     [tm_wday] => 5
//     [tm_yday] => 282
//     [tm_isdst] => 0
// )

var_dump(microtime()); // string(21) "0.38488800 1602205473"

var_dump(microtime(true)); // float(1602205473.3849)

var_dump(gmdate("Y-m-d H:i:s")); // string(19) "2020-10-09 01:00:20"

var_dump(idate('Y')); // int(2020)

var_dump(mktime(14, 22, 22, 10, 22, 2020)); // int(1603344142)
var_dump(gmmktime(14, 22, 22, 10, 22, 2020)); // int(1603376542)

var_dump(strftime("%C %Y %m %d %R %U")); // string(22) "20 2020 10 09 10:12 40"
var_dump(gmstrftime("%C %Y %m %d %R %U")); // string(22) "20 2020 10 09 01:13 40"

var_dump(strptime("2020-10-09 12:12:12", '%Y-%m-%d %H:%M:%S'));
// array(9) {
//     ["tm_sec"]=>
//     int(12)
//     ["tm_min"]=>
//     int(12)
//     ["tm_hour"]=>
//     int(12)
//     ["tm_mday"]=>
//     int(9)
//     ["tm_mon"]=>
//     int(9)
//     ["tm_year"]=>
//     int(120)
//     ["tm_wday"]=>
//     int(5)
//     ["tm_yday"]=>
//     int(282)
//     ["unparsed"]=>
//     string(0) ""
//   }
