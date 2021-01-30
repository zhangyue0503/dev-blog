<?php


define("A", "Test A");
var_dump(A); // string(6) "Test A"
var_dump(B); // Warning: Use of undefined constant B - assumed 'B'

var_dump(constant('A')); // string(6) "Test A"
var_dump(constant('B')); // NULL
// PHP Warning:  Use of undefined constant B - assumed 'B'
// PHP Warning:  Use of undefined constant B - assumed 'B'    

var_dump(defined('A')); // bool(true)
var_dump(defined('B')); // bool(false)

interface A1{
    const TEST = 'Test A1';
}

class A2{
    const TEST = 'Test A2';
}

var_dump(constant('A1::TEST')); // string(7) "Test A1"
var_dump(constant('A2::TEST')); // string(7) "Test A2"

var_dump(defined('A1::TEST')); // bool(true)
var_dump(defined('A2::TEST')); // bool(true)



var_dump(highlight_string('<?php phpinfo(); ?>', true));
// string(195) "<code><span style="color: #000000">
// <span style="color: #0000BB">&lt;?php&nbsp;phpinfo</span><span style="color: #007700">();&nbsp;</span><span style="color: #0000BB">?&gt;</span>
// </span>
// </code>"

var_dump(highlight_file('1.PHP中的一些杂项函数学习.php', true));
// string(10610) "<code><span style="color: #000000">
// <span style="color: #0000BB">&lt;?php<br /><br /><br />define</span><span style="color: #007700">(</span><span style="color: #DD0000">"A"</span><span style="color: #007700">,&nbsp;</span><span style="color: #DD0000">"Test&nbsp;A"</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">A</span><span style="color: #007700">);&nbsp;</span><span style="color: #FF8000">//&nbsp;string(6)&nbsp;"Test&nbsp;A"<br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">B</span><span style=" ……………………………………

var_dump(show_source('1.PHP中的一些杂项函数学习.php', true));
// string(10610) "<code><span style="color: #000000">
// <span style="color: #0000BB">&lt;?php<br /><br /><br />define</span><span style="color: #007700">(</span><span style="color: #DD0000">"A"</span><span style="color: #007700">,&nbsp;</span><span style="color: #DD0000">"Test&nbsp;A"</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">A</span><span style="color: #007700">);&nbsp;</span><span style="color: #FF8000">//&nbsp;string(6)&nbsp;"Test&nbsp;A"<br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">B</span><span style=" ……………………………………

var_dump(php_strip_whitespace("1.PHP中的一些杂项函数学习.php"));
// string(570) "<?php
//  define("A", "Test A"); var_dump(A); var_dump(B); var_dump(constant('A')); var_dump(constant('B')); var_dump(defined('A')); var_dump(defined('B')); interface A1{ const TEST = 'Test A1'; } class A2{ const TEST = 'Test A2'; } var_dump(constant('A1::TEST')); var_dump(constant('A2::TEST')); var_dump(defined('A1::TEST')); …………………………


echo hrtime(true), PHP_EOL; // 2636292334692
print_r(hrtime());
// Array
// (
//     [0] => 2636
//     [1] => 292338001
// )

$time = microtime(true);
echo $time, PHP_EOL; // 1609723496.283
sleep(1);
echo microtime(true) - $time, PHP_EOL; // 1.0041399002075
usleep(2000);
echo microtime(true) - $time, PHP_EOL; // 1.0062718391418
time_nanosleep(2, 100000);
echo microtime(true) - $time, PHP_EOL; // 3.0067868232727
time_sleep_until(time()+3); 
echo microtime(true) - $time, PHP_EOL; // 5.7171077728271




var_dump(uniqid()); // string(13) "5ff270b0014b4"

var_dump(uniqid('pre_')); // string(17) "pre_5ff270b0014d7"

var_dump(uniqid('pre_', true)); // string(27) "pre_5ff270b0014df3.11521937"

var_dump(sys_getloadavg());
// array(3) {
//     [0]=>
//     float(2.98828125)
//     [1]=>
//     float(2.4775390625)
//     [2]=>
//     float(2.341796875)
//   }

eval("echo '123', PHP_EOL;"); // 123

// exit;
// die;
// exit(0);
// exit("End"); // End

var_dump(get_browser(null, true));
// array(15) {
//     ["browser_name_regex"]=>
//     string(108) "~^mozilla/5\.0 \(.*mac os x 10.15.*\) applewebkit.* \(.*khtml.*like.*gecko.*\) .*version/14\.0.* safari/.*$~"
//     ["browser_name_pattern"]=>
//     string(88) "Mozilla/5.0 (*Mac OS X 10?15*) applewebkit* (*khtml*like*gecko*) *Version/14.0* Safari/*"
//     ["parent"]=>
//     string(11) "Safari 14.0"
//     ["platform"]=>
//     string(5) "macOS"
//     ["comment"]=>
//     string(11) "Safari 14.0"
//     ["browser"]=>
//     string(6) "Safari"
//     ["browser_maker"]=>
//     string(9) "Apple Inc"
//     ["version"]=>
//     string(4) "14.0"
//     ["majorver"]=>
//     string(2) "14"
//     ["device_type"]=>
//     string(7) "Desktop"
//     ["device_pointing_method"]=>
//     string(5) "mouse"
//     ["minorver"]=>
//     string(1) "0"
//     ["ismobiledevice"]=>
//     string(0) ""
//     ["istablet"]=>
//     string(0) ""
//     ["crawler"]=>
//     string(0) ""
//   }

// ignore_user_abort(true);
// while(1){
//     echo " ";
//     if (connection_status()!=0){
//         ob_start();
//         var_dump(connection_aborted());
//         $v = ob_get_contents();
//         ob_end_flush();
//         file_put_contents("1.txt", date("Y-m-d H:i:s") . " Connection aborted! " . $v . PHP_EOL, FILE_APPEND);
//         exit;
//     }
// }

// 1.txt
// 2021-01-04 08:56:22 Connection aborted! int(1)

