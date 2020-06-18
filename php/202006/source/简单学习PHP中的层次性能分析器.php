<?php
xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);

//xhprof_enable( XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);

//xhprof_enable( XHPROF_FLAGS_MEMORY);

//xhprof_enable();

for ($i = 0; $i <= 1000; $i++) {
    $a = $i * $i;
}

function test_application(){
    for ($i = 0; $i <= 1000; $i++) {
            $a = $i * $i;
    }
}

test_application();


$xhprof_data = xhprof_disable();

$xhprof_data = xhprof_disable();

require 'xhprof_lib/utils/xhprof_lib.php';
require 'xhprof_lib/utils/xhprof_runs.php';

$xhprofRuns = new XHProfRuns_Default();
$runId = $xhprofRuns->save_run($xhprof_data, 'xhprof_test');

echo 'http://192.168.56.102/index.php?run=' . $runId . '&source=xhprof_test';

print_r($xhprof_data);

// Array
// (
//     [main()==>test_application] => Array
//         (
//             [ct] => 1
//             [wt] => 16
//             [cpu] => 21
//             [mu] => 848
//             [pmu] => 0
//         )

//     [main()] => Array
//         (
//             [ct] => 1
//             [wt] => 115
//             [cpu] => 115
//             [mu] => 1416
//             [pmu] => 0
//         )

// )


xhprof_sample_enable();

for ($i = 0; $i <= 10000; $i++) {
    $a = strlen($i);
    $b = $i * $a;
    $c = rand();
}

$sample_data = xhprof_sample_disable();

print_r($sample_data);