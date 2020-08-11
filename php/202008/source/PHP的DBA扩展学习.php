<?php

// 打开一个数据库文件
$id = dba_open("/tmp/test.db", "n", "gdbm");
//$id = dba_popen("/tmp/test1.db", "c", "gdbm");

// 添加或替换一个内容
dba_replace("key1", "This is an example!", $id);

// 如果内容存在
if(dba_exists("key1", $id)){
    // 读取内容
    echo dba_fetch("key1", $id), PHP_EOL;
    // This is an example!
}

// 添加数据
dba_insert("key2","This is key2!", $id);
dba_insert("key3","This is key3!", $id);
dba_insert("key4","This is key4!", $id);
dba_insert("key5","This is key5!", $id);
dba_insert("key6","This is key6!", $id);

// 获取第一个 key
$key = dba_firstkey($id);

$handle_later = [];
while ($key !== false) {
    if (true) {
        // 将 key 保存到数组中
        $handle_later[] = $key;
    }
    // 获取下一个 key
    $key = dba_nextkey($id);
}

// 遍历 key 数组，打印数据库中的全部内容
foreach ($handle_later as $val) {
    echo dba_fetch($val, $id), PHP_EOL;
    dba_delete($val, $id); // 删除key对应的内容
}
// This is key4!
// This is key2!
// This is key3!
// This is an example!
// This is key5!
// This is key6!

// 优化数据库
var_dump(dba_optimize($id)); // bool(true)
// 同步数据库
var_dump(dba_sync($id)); // bool(true)

// 获取当前打开的数据库列表
var_dump(dba_list());
// array(1) {
//     [4]=>
//     string(12) "/tmp/test.db"
//   }

// 关闭数据库句柄
dba_close($id); 

// 当前支持的数据库类型
var_dump(dba_handlers(true));
// array(5) {
//     ["gdbm"]=>
//     string(58) "GDBM version 1.18. 21/08/2018 (built May 11 2019 01:10:11)"
//     ["cdb"]=>
//     string(53) "0.75, $Id: 841505a20a8c9c8e35cac5b5dc3d5cf2fe917478 $"
//     ["cdb_make"]=>
//     string(53) "0.75, $Id: 95b1c2518144e0151afa6b2b8c7bf31bf1f037ed $"
//     ["inifile"]=>
//     string(52) "1.0, $Id: 42cb3bb7617b5744add2ab117b45b3a1e37e7175 $"
//     ["flatfile"]=>
//     string(52) "1.0, $Id: 410f3405266f41bafffc8993929b8830b761436b $"
//   }

var_dump(dba_handlers(false));
// array(5) {
//     [0]=>
//     string(4) "gdbm"
//     [1]=>
//     string(3) "cdb"
//     [2]=>
//     string(8) "cdb_make"
//     [3]=>
//     string(7) "inifile"
//     [4]=>
//     string(8) "flatfile"
//   }