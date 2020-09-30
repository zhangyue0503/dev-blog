<?php

$date = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-29 09:47:57+09:00

$date = new DateTime();
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-29 10:22:45+08:00

$date = DateTime::createFromFormat('Y年m月j日 H时i分s秒', '2020年09月22日 22时13分35秒');
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-22 22:13:35+08:00

$date = DateTime::createFromImmutable(new DateTimeImmutable("2020-09-22 11:45"));
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-22 11:45:00+08:00

$di = new DateTimeImmutable("2020-09-22 11:45");
var_dump($di);
// object(DateTimeImmutable)#1 (3) {
//     ["date"]=>
//     string(26) "2020-09-22 11:45:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }
var_dump($di->add(new DateInterval('P3D')));
// object(DateTimeImmutable)#4 (3) {
//     ["date"]=>
//     string(26) "2020-09-25 11:45:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }

$date = new DateTime("2020-09-22 11:45");
var_dump($date);
// object(DateTime)#4 (3) {
//     ["date"]=>
//     string(26) "2020-09-22 11:45:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }
var_dump($date->add(new DateInterval('P3D')));
// object(DateTime)#4 (3) {
//     ["date"]=>
//     string(26) "2020-09-25 11:45:00.000000"
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(13) "Asia/Shanghai"
//   }
exit;


$date->add(new DateInterval('P3D'));
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-29 09:22:45+08:00

$date->sub(new DateInterval('P3D'));
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-02 09:22:45+08:00

$date->modify('+5 day');
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-04 09:22:45+08:00

$date->modify('-4 day -4 hours');
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-30 05:22:45+08:00


$origin = new DateTime('now');
$target = new DateTime('2020-09-11');
$interval = $origin->diff($target);
echo $interval->format('%a days'), PHP_EOL;
echo $interval->format('%R%a days'), PHP_EOL;
// 18 days
// -18 days



$date = new DateTime();
$date->setDate(2020, 9, 25);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-09-25 09:22:45+08:00

$date->setISODate(2020, 9, 25);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-03-19 09:22:45+08:00

$date->setDate(2020, 9, 33);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-03 09:22:45+08:00

$date->setTime(14, 55);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-03 14:55:00+08:00


$date->setTime(14, 63);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-03 15:03:00+08:00

$date->setTime(14, 55, 22);
echo $date->format('Y-m-d H:i:sP'), PHP_EOL;
// 2020-10-03 14:55:22+08:00

$date->setTimestamp(time()-84400);
echo $date->format('U = Y-m-d H:i:s'), PHP_EOL;
// 1601258165 = 2020-09-28 09:56:05

$date->setTimezone(new DateTimeZone('Asia/Tokyo'));
echo $date->format('U = Y-m-d H:i:s'), PHP_EOL;
// 1601258165 = 2020-09-28 10:56:05

echo $date->getOffset(), PHP_EOL;
// 32400

echo $date->getTimestamp(), PHP_EOL;
// 1601258070

var_dump($date->getTimezone());
// object(DateTimeZone)#6 (2) {
//     ["timezone_type"]=>
//     int(3)
//     ["timezone"]=>
//     string(10) "Asia/Tokyo"
//   }

$date = date_create('asdfasdf');
print_r(DateTime::getLastErrors());
// Array
// (
//     [warning_count] => 1
//     [warnings] => Array
//         (
//             [6] => Double timezone specification
//         )

//     [error_count] => 1
//     [errors] => Array
//         (
//             [0] => The timezone could not be found in the database
//         )

// )

try {
    $date = new DateTime('asdfasdf');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
// DateTime::__construct(): Failed to parse time string (asdfasdf) at position 0 (a): The timezone could not be found in the database
