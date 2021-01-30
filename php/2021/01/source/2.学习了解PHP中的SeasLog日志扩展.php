<?php

// https://github.com/SeasX/SeasLog/blob/master/README_zh.md
// https://www.zhihu.com/people/ciogao


// 获取设置日志根目录
var_dump(SeasLog::getBasePath()); // string(12) "/var/log/www"
SeasLog::setBasePath("./");
var_dump(SeasLog::getBasePath()); // string(2) "./"

// 获取设置日志 Logger 名称
var_dump(SeasLog::getLastLogger()); // string(7) "default"

SeasLog::info("Test Logger Default");
// ./default/20200106.log
// 2021-01-06 01:01:53 | INFO | 5038 | 5ff50c019ebe9 | 1609894913.650 | Test Logger Default

SeasLog::setLogger("mylog");
var_dump(SeasLog::getLastLogger()); // string(5) "mylog"

SeasLog::info("Test Logger MyLog");
// ./mylog/20200106.log
// 2021-01-06 01:01:53 | INFO | 5038 | 5ff50c019ebe9 | 1609894913.650 | Test Logger MyLog

// seaslog.default_template="%T | %L | %P | %Q | %t | %M"

// 获取设置日志日期格式
var_dump(SeasLog::getDatetimeFormat()); // string(11) "Y-m-d H:i:s"

SeasLog::info("Test Datetime Default");
// 2021-01-06 01:04:44 …………

SeasLog::setDatetimeFormat("Y/m/d His");
var_dump(SeasLog::getDatetimeFormat()); // string(9) "Y/m/d His"

SeasLog::info("Test Datetime New");
// 2021/01/06 010444 …………

// 获取设置请求ID
var_dump(SeasLog::getRequestID()); // string(13) "5ff50e4721a06"
SeasLog::setRequestID("new_request_id" . uniqid());
var_dump(SeasLog::getRequestID()); // string(27) "new_request_id5ff50e6519202"
SeasLog::info("Test New Request ID");
// 2021/01/06 011216 | INFO | 5250 | new_request_id5ff50e70337b8 | 1609895536.210 | Test New Request ID

// 获取设置其它日志变量
var_dump(SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_DOMAIN_PORT));
var_dump(SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_URI));
var_dump(SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_METHOD));
var_dump(SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_CLIENT_IP));
// string(3) "cli"
// string(5) "1.php"
// string(9) "/bin/bash"
// string(5) "local"

// seaslog.default_template="%T | %L | %P | %Q | %t | %M | %H | %m"

SeasLog::info("Test Other Request Variable");
// 2021/01/06 012512 | INFO | 5496 | new_request_id5ff5117888f86 | 1609896312.561 | Test Other Request Variable | localhost.localdomain | /bin/bash

SeasLog::setRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_METHOD, "Get");
var_dump(SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_METHOD)); // string(3) "Get"
SeasLog::info("Test New Other Request Variable");
// 2021/01/06 012625 | INFO | 5520 | new_request_id5ff511c1367c2 | 1609896385.223 | Test New Other Request Variable | localhost.localdomain | Get

// 日志记录

SeasLog::info("Test Info Log");
// 2021/01/06 013018 | INFO | 5583 | new_request_id5ff512aaafcde | 1609896618.720 | Test Info Log | localhost.localdomain | Get

SeasLog::info("Test {name} Log", ['name'=>'Info1']);
// 2021/01/06 013018 | INFO | 5583 | new_request_id5ff512aaafcde | 1609896618.720 | Test Info1 Log | localhost.localdomain | Get

SeasLog::info("Test {name} Log", ['name'=>'Info1'], 'default');
// ./default/20210106.log
// 2021/01/06 013140 | INFO | 5609 | new_request_id5ff512fc264f3 | 1609896700.156 | Test Info1 Log | localhost.localdomain | Get

SeasLog::info("Test {name} Log", ['name'=>'Info1'], 'defaultNew');
// defaultNew/20210106.log
// 2021/01/06 013230 | INFO | 5631 | new_request_id5ff5132e3e143 | 1609896750.254 | Test Info1 Log | localhost.localdomain | Get

SeasLog::alert("Test {name} Log", ['name'=>'Alert'], 'defaultNew');
SeasLog::error("Test {name} Log", ['name'=>'Error'], 'defaultNew');
SeasLog::debug("Test {name} Log", ['name'=>'Debug'], 'defaultNew');
SeasLog::critical("Test {name} Log", ['name'=>'Critical'], 'defaultNew');
SeasLog::emergency("Test {name} Log", ['name'=>'Emergency'], 'defaultNew');
SeasLog::notice("Test {name} Log", ['name'=>'Notice'], 'defaultNew');
SeasLog::warning("Test {name} Log", ['name'=>'Warning'], 'defaultNew');
// 2021/01/06 014106 | ALERT | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Alert Log | localhost.localdomain | Get
// 2021/01/06 014106 | ERROR | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Error Log | localhost.localdomain | Get
// 2021/01/06 014106 | DEBUG | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Debug Log | localhost.localdomain | Get
// 2021/01/06 014106 | CRITICAL | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Critical Log | localhost.localdomain | Get
// 2021/01/06 014106 | EMERGENCY | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Emergency Log | localhost.localdomain | Get
// 2021/01/06 014106 | NOTICE | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Notice Log | localhost.localdomain | Get
// 2021/01/06 014106 | WARNING | 5762 | new_request_id5ff5153200b30 | 1609897266.2 | Test Warning Log | localhost.localdomain | Get

SeasLog::log(SEASLOG_INFO, "Test log() {name} Log", ['name'=>"Info"], 'defaultNew');
// 2021/01/06 014330 | INFO | 5809 | new_request_id5ff515c2ddd5d | 1609897410.908 | Test log() Info Log | localhost.localdomain | Get

// 获取日志数量等信息
SeasLog::setLogger('defaultNew');
var_dump(SeasLog::analyzerCount());
// array(8) {
//     ["DEBUG"]=>
//     int(40)
//     ["INFO"]=>
//     int(80)
//     ["NOTICE"]=>
//     int(40)
//     ["WARNING"]=>
//     int(40)
//     ["ERROR"]=>
//     int(40)
//     ["CRITICAL"]=>
//     int(40)
//     ["ALERT"]=>
//     int(40)
//     ["EMERGENCY"]=>
//     int(40)
//   }

var_dump(SeasLog::analyzerCount(SEASLOG_WARNING)); // int(10)
var_dump(SeasLog::analyzerCount(SEASLOG_ERROR, null)); // int(10)
var_dump(SeasLog::analyzerCount(SEASLOG_ERROR, null, "1609897995.939")); // int(1)

var_dump(SeasLog::analyzerDetail(SEASLOG_ALL, 'secpath/', null, 1, 2, SEASLOG_DETAIL_ORDER_DESC));
// array(2) {
//     [0]=>
//     string(125) "2021/01/06 020212 | INFO | 6840 | new_request_id5ff51a248e1e2 | 1609898532.582 | Test Info1 Log | localhost.localdomain | Get"
//     [1]=>
//     string(124) "2021/01/06 020212 | INFO | 6840 | new_request_id5ff51a248e1e2 | 1609898532.582 | Test Info Log | localhost.localdomain | Get"
//   }

// 内存日志
var_dump(SeasLog::getBufferEnabled()); // bool(false)

// seaslog.use_buffer=1
// seaslog.buffer_disabled_in_cli=0
// seaslog.buffer_size=100
var_dump(SeasLog::getBufferEnabled()); // bool(true)

var_dump(SeasLog::getBuffer());
// array(3) {
//     [".//default/20210106.log"]=>
//     array(2) {
//       [0]=>
//       string(125) "2021-01-06 02:21:43 | INFO | 8006 | 5ff51eb7e1a54 | 1609899703.924 | Test Logger Default | localhost.localdomain | /bin/bash
//   "
//     ……………………
//     }
//     [".//mylog/20210106.log"]=>
//     array(8) {
//       [0]=>
//       string(123) "2021-01-06 02:21:43 | INFO | 8006 | 5ff51eb7e1a54 | 1609899703.924 | Test Logger MyLog | localhost.localdomain | /bin/bash
//   "
//       ……………………
//     }
//     [".//defaultNew/20210106.log"]=>
//     array(9) {
//       [0]=>
//       string(126) "2021/01/06 022143 | INFO | 8006 | new_request_id5ff51eb7e1b30 | 1609899703.924 | Test Info1 Log | localhost.localdomain | Get
//   "
//       ……………………
//     }
//   }

// 刷新内存缓冲区
SeasLog::flushBuffer();
var_dump(SeasLog::getBuffer());
// array(0) {
// }