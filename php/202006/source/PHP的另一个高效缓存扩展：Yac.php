<?php
$yac = new Yac();
$yac->add('a', 'value a');
$yac->add('b', [1,2,3,4]);

$obj = new stdClass;
$obj->v = 'obj v';
$yac->add('obj', $obj);


echo $yac->get('a'), PHP_EOL; // value a
echo $yac->a, PHP_EOL; // value a


print_r($yac->get('b'));
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
// )

var_dump($yac->get('obj'));
// object(stdClass)#3 (1) {
//     ["v"]=>
//     string(5) "obj v"
// }

print_r($yac->info());
// Array
// (
//     [memory_size] => 71303168
//     [slots_memory_size] => 4194304
//     [values_memory_size] => 67108864
//     [segment_size] => 4194304
//     [segment_num] => 16
//     [miss] => 0
//     [hits] => 4
//     [fails] => 0
//     [kicks] => 0
//     [recycles] => 0
//     [slots_size] => 32768
//     [slots_used] => 3
// )

$yac->set('a', 'new value a!');
echo $yac->a, PHP_EOL; // new value a!

$yac->a = 'best new value a!';
echo $yac->a, PHP_EOL; // best new value a!

$yac->delete('a');
echo $yac->a, PHP_EOL; // 

$yac->flush();
print_r($yac->info());
// Array
// (
//     [memory_size] => 71303168
//     [slots_memory_size] => 4194304
//     [values_memory_size] => 67108864
//     [segment_size] => 4194304
//     [segment_num] => 16
//     [miss] => 1
//     [hits] => 6
//     [fails] => 0
//     [kicks] => 0
//     [recycles] => 0
//     [slots_size] => 32768
//     [slots_used] => 0
// )

$yacFirst = new Yac();
$yacFirst->a = 'first a!';;

$yacSecond = new Yac();
$yacSecond->a = 'second a!';

echo $yacFirst->a, PHP_EOL; // second a!
echo $yacSecond->a, PHP_EOL; // second a!

$yacFirst = new Yac('first');
$yacFirst->a = 'first a!';;

$yacSecond = new Yac('second');
$yacSecond->a = 'second a!';

echo $yacFirst->a, PHP_EOL; // first a!
echo $yacSecond->a, PHP_EOL; // second a!

$yac->add('ttl', '10s', 10);
$yac->set('ttl2', '20s', 20);
echo $yac->get('ttl'), PHP_EOL; // 10s
echo $yac->ttl2, PHP_EOL; // 20s

sleep(10);

echo $yac->get('ttl'), PHP_EOL; // 
echo $yac->ttl2, PHP_EOL; // 20s