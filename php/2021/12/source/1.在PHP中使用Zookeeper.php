<?php

$host = "192.168.10.102:2181,192.168.10.103:2181,192.168.10.104:2181";

$zookeeper = new Zookeeper($host);

$acl = array(
  array(
    'perms'  => Zookeeper::PERM_ALL,
    'scheme' => 'world',
    'id'     => 'anyone',
  )
);
if(!$zookeeper->exists("/test")){
    $path = $zookeeper->create("/test", "ttt", $acl);
    echo $path; // /test
}


echo $zookeeper->create("/test/app_", "appinfo" . date("Y-m-d H:i:s"), $acl, Zookeeper::EPHEMERAL|Zookeeper::SEQUENCE);
// /test/app_0000000077/test/show2

if(!$zookeeper->exists("/test/show1")){
    $path = $zookeeper->create("/test/show1", "show1", $acl);
    echo $path, PHP_EOL; // /test/show1
}

if(!$zookeeper->exists("/test/show2")){
    $path = $zookeeper->create("/test/show2", "show1", $acl);
    echo $path, PHP_EOL; // /test/show2
}

echo $zookeeper->get("/test/show1"), PHP_EOL;
// show1

$stat = [];
$zookeeper->get("/test/show1", null, $stat);
print_r($stat);
// Array
// (
//     [czxid] => 21474836499
//     [mzxid] => 21474836731
//     [ctime] => 1638752001331
//     [mtime] => 1638760238766
//     [version] => 28
//     [cversion] => 0
//     [aversion] => 0
//     [ephemeralOwner] => 0
//     [dataLength] => 6
//     [numChildren] => 0
//     [pzxid] => 21474836499
// )

print_r($zookeeper->getAcl("/test/show1"));
// Array
// (
//     [0] => Array
//         (
//             [czxid] => 21474836499
//             [mzxid] => 21474836731
//             [ctime] => 1638752001331
//             [mtime] => 1638760238766
//             [version] => 28
//             [cversion] => 0
//             [aversion] => 0
//             [ephemeralOwner] => 0
//             [dataLength] => 6
//             [numChildren] => 0
//             [pzxid] => 21474836499
//         )

//     [1] => Array
//         (
//             [0] => Array
//                 (
//                     [perms] => 31
//                     [scheme] => world
//                     [id] => anyone
//                 )

//         )

// )

print_r($zookeeper->getChildren("/test"));
// Array
// (
//     [0] => show2
//     [1] => show1
//     [2] => app_0000000077
// )

var_dump($zookeeper->set("/test/show1", "show11")); // bool(true)
echo $zookeeper->get("/test/show1"), PHP_EOL; // show11

// var_dump($zookeeper->setAcl("/test/show2", -1, [['perms'=>Zookeeper::PERM_READ, 'id'=>'anyone', 'scheme'=>'world']]));
// print_r($zookeeper->getAcl("/test/show2"));
//……
//             [0] => Array
//                 (
//                     [perms] => 1
//                     [scheme] => world
//                     [id] => anyone
//                 )
// ……
// $zookeeper->set("/test/show2", "show22");
// PHP Fatal error:  Uncaught ZookeeperAuthenticationException: not authenticated in /data/www/blog/zookeeper/1.php:50

var_dump($zookeeper->delete("/test/show2")); // bool(true)
print_r($zookeeper->getChildren("/test"));
// Array
// (
//     [0] => show1
//     [1] => app_0000000077
// )

$zookeeper->setWatcher(function(){
    print_r(func_get_args());
});

function watcher($type, $state, $path){
    global $zookeeper;
    echo $type, ",", $state, ",", $path;
    switch ($type){
        case Zookeeper::CREATED_EVENT:
            echo "新建了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::DELETED_EVENT:
            echo "删除了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::CHANGED_EVENT:
            echo "修改了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::CHILD_EVENT:
            echo "修改了子目录：" . $path, PHP_EOL;
            break;
        default:
            echo "其它操作：" . $path, PHP_EOL;
            break;
        }
        $zookeeper->getChildren("/test",'watcher');
}

$zookeeper->getChildren("/test",'watcher');


function watcher1($type, $state, $path){
    global $zookeeper;
    echo $type, ",", $state, ",", $path;
    switch ($type){
        case Zookeeper::CREATED_EVENT:
            echo "新建了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::DELETED_EVENT:
            echo "删除了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::CHANGED_EVENT:
            echo "修改了目录：" . $path, PHP_EOL;
            break;
        case Zookeeper::CHILD_EVENT:
            echo "修改了子目录：" . $path, PHP_EOL;
            break;
        default:
            echo "其它操作：" . $path, PHP_EOL;
            break;
        }
        $zookeeper->get("/test",'watcher1');
}

$zookeeper->get("/test",'watcher1');

// 当前客户端连接的 sessionid 等信息
var_dump($zookeeper->getClientId());
// array(2) {
//     [0]=>
//     int(144115198348099588)
//     [1]=>
//     string(17) "��슅��˟g��o�-"
//   }

// ZookeeperConfig 配置对象
var_dump($zookeeper->getConfig());
// object(ZookeeperConfig)#3 (0) {
// }

// 当前连接的过期时间
echo $zookeeper->getRecvTimeout(), PHP_EOL; // 10000

// 连接状态，3 是已连接，和上面监听器中的 state 一样
echo $zookeeper->getState(), PHP_EOL; // 3

// 检查当前连接状态是否可以恢复
var_dump($zookeeper->isRecoverable()); // bool(true)


while(1){sleep(2);};