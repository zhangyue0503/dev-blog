<?php

print_r($_SERVER);

echo 'GET INFO', PHP_EOL;
foreach ($_GET as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
}

echo PHP_EOL,PHP_EOL;
echo 'POST INFO', PHP_EOL;
foreach ($_POST as $k => $v) {
    echo $k, ': ', $v, PHP_EOL;
}


