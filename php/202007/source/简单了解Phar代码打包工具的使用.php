<?php
$config = parse_ini_file("./myphar/build/config.ini");
require './myphar/build/myphar.phar';

Manager::run($config);
// AAA
// array(4) {
//   ["host"]=>
//   string(9) "localhost"
//   ["db"]=>
//   string(6) "dbname"
//   ["user"]=>
//   string(6) "myuser"
//   ["pass"]=>
//   string(6) "dbpass"
// }

var_dump(Manager::ChineseMobile('13811111111'));
var_dump(Manager::ChineseMobile('138111111112'));
// bool(true)
// bool(false)
