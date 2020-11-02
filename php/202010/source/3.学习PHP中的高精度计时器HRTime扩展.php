<?php

print_r(hrtime());
// Array
// (
//     [0] => 3758
//     [1] => 407409171
// )

echo hrtime(true), PHP_EOL;
// 3758407428932

echo HRTime\PerformanceCounter::getFrequency(), PHP_EOL; // 1000000000
echo HRTime\PerformanceCounter::getTicks(), PHP_EOL; // 3758428256236
echo HRTime\PerformanceCounter::getTicksSince(1212), PHP_EOL; // 3758428257494

$a = HRTime\PerformanceCounter::getTicks();
echo HRTime\PerformanceCounter::getTicksSince($a), PHP_EOL; // 412

$c = new HRTime\StopWatch;

$c->start();
for ($i = 0; $i < 1024*1024; $i++);
echo 'isRunning: ', $c->isRunning(), PHP_EOL; // isRunning: 1
$c->stop();

echo 'Time NS: ', $c->getLastElapsedTime(HRTime\Unit::NANOSECOND), PHP_EOL;
echo 'Time US: ', $c->getLastElapsedTime(HRTime\Unit::MICROSECOND), PHP_EOL;
echo 'Time MS: ', $c->getLastElapsedTime(HRTime\Unit::MILLISECOND), PHP_EOL;
echo 'Time S: ', $c->getLastElapsedTime(HRTime\Unit::SECOND), PHP_EOL;
// Time NS: 6929888
// Time US: 6929.888
// Time MS: 6.929888
// Time S: 0.006929888

echo 'Ticks: ',$c->getLastElapsedTicks(), PHP_EOL;
// Ticks: 6929888

echo 'isRunning: ',$c->isRunning(), PHP_EOL;
// 

/* measurement is not running here*/
for ($i = 0; $i < 1024*1024; $i++);

$c->start();
for ($i = 0; $i < 1024*1024; $i++);
$c->stop();

echo 'Time NS: ', $c->getLastElapsedTime(HRTime\Unit::NANOSECOND), PHP_EOL;
echo 'Time US: ', $c->getLastElapsedTime(HRTime\Unit::MICROSECOND), PHP_EOL;
echo 'Time MS: ', $c->getLastElapsedTime(HRTime\Unit::MILLISECOND), PHP_EOL;
echo 'Time S: ', $c->getLastElapsedTime(HRTime\Unit::SECOND), PHP_EOL;
// Time NS: 7154010
// Time US: 7154.01
// Time MS: 7.15401
// Time S: 0.00715401

echo 'All Time NS: ', $c->getElapsedTime(HRTime\Unit::NANOSECOND), PHP_EOL;
echo 'All Time US: ', $c->getElapsedTime(HRTime\Unit::MICROSECOND), PHP_EOL;
echo 'All Time MS: ', $c->getElapsedTime(HRTime\Unit::MILLISECOND), PHP_EOL;
echo 'All Time S: ', $c->getElapsedTime(HRTime\Unit::SECOND), PHP_EOL;
// All Time NS: 14083898
// All Time US: 14083.898
// All Time MS: 14.083898
// All Time S: 0.014083898

echo 'All Ticks: ', $c->getElapsedTicks(), PHP_EOL;
// All Ticks: 14083898


