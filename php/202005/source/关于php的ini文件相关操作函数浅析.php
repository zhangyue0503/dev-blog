<?php

ini_set('allow_url_fopen', 0);
echo ini_get('allow_url_fopen'), PHP_EOL; // 1 ，无法修改，PHP_INI_SYSTEM

ini_set('memory_limit', -1);
echo ini_get('memory_limit'), PHP_EOL; // -1，可以修改，PHP_INI_ALL



echo get_cfg_var('error_reporting'), PHP_EOL; // 32759
echo ini_get('error_reporting'), PHP_EOL; // 32759

echo get_cfg_var('request_order'), PHP_EOL; // GP
echo ini_get('request_order'), PHP_EOL; // GP

// php.ini A=TEST_A
echo get_cfg_var('A'), PHP_EOL; // TEST_A
echo ini_get('A'), PHP_EOL; // 


ini_set('error_reporting', E_WARNING);
echo get_cfg_var('error_reporting'), PHP_EOL; // 32759，只返回.ini的内容
echo ini_get('error_reporting'), PHP_EOL; // 2，返回当前配置运行时的状态



print_r(ini_get_all('swoole'));
echo PHP_EOL;
// Array
// (
//     [swoole.display_errors] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_coroutine] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_library] => Array
//         (
//             [global_value] => On
//             [local_value] => On
//             [access] => 7
//         )

//     [swoole.enable_preemptive_scheduler] => Array
//         (
//             [global_value] => Off
//             [local_value] => Off
//             [access] => 7
//         )

//     [swoole.unixsock_buffer_size] => Array
//         (
//             [global_value] => 262144
//             [local_value] => 262144
//             [access] => 7
//         )

//     [swoole.use_shortname] => Array
//         (
//             [global_value] => 
//             [local_value] => 
//             [access] => 4
//         )

// )



ini_restore('error_reporting');
echo ini_get('error_reporting'), PHP_EOL; // 32759

echo php_ini_loaded_file(), PHP_EOL;
// /usr/local/etc/php/7.3/php.ini

echo php_ini_scanned_files(), PHP_EOL;

ob_start();
phpinfo();
$v = ob_get_contents();
ob_end_clean();

// echo $v;

