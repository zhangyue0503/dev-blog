<?php
gc_disable();
echo gc_enabled(), PHP_EOL; //
gc_enable();
echo gc_enabled(), PHP_EOL; // 1


$a = new stdClass;
$b = new stdClass;
$c = new stdClass;

echo memory_get_usage(), PHP_EOL; // 706528

unset($a);
echo memory_get_usage(), PHP_EOL; // 706488

gc_collect_cycles();
echo memory_get_usage(), PHP_EOL; // 706488

class D{
    public $d;
}
$d = new D;
$d->d = $d;
echo memory_get_usage(), PHP_EOL; // 706544

unset($d);
echo memory_get_usage(), PHP_EOL; // 706544

gc_collect_cycles();
echo memory_get_usage(), PHP_EOL; // 706488

gc_mem_caches();
echo memory_get_usage(), PHP_EOL;

$e = new stdClass;
for($i = 100;$i>0;$i--){
    $e->list[] = $e;
}

unset($e);
unset($f);
gc_collect_cycles();

var_dump(gc_status());
// array(4) {
//     ["runs"]=>int(1)
//     ["collected"]=>int(2)
//     ["threshold"]=>int(10001)
//     ["roots"]=>int(0)
// }


