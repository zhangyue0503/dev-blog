<?php

$redis = stream_socket_client('tcp://127.0.0.1:6379', $errno, $err, 5);
if (!$redis) {
    die('连接失败: ' . $err);
}

// $cmd = "*1\r\n$4\r\nPING\r\n";

// $cmd = "";
// if (count($argv) > 1) {
//     $cmd = "*" . (count($argv) - 1) . "\r\n";
//     for ($i = 1; $i < count($argv); $i++) {
//         $cmd .= "$" . strlen($argv[$i]) . "\r\n";
//         $cmd .= $argv[$i] . "\r\n";
//     }
// }
// echo str_replace("\r\n", "\\r\\n",$cmd), PHP_EOL;

// stream_socket_sendto($redis, $cmd);
// echo stream_socket_recvfrom($redis, 4096);
// exit;


$cmd = "";
if (count($argv) > 1) {
    $cmd = "*" . (count($argv) - 1) . "\r\n";
    for ($i = 1; $i < count($argv); $i++) {
        $cmd .= "$" . strlen($argv[$i]) . "\r\n";
        $cmd .= $argv[$i] . "\r\n";
    }
}

if ($cmd) {
    stream_socket_sendto($redis, $cmd);
    $ret = stream_socket_recvfrom($redis, 4096);

    $ret = explode("\r\n", trim($ret, "\r\n"));
//    print_r($ret);
    if (count($ret) == 1) {
        $ret = $ret[0];
        if (strpos($ret, "+") !== false) $ret = str_replace("+", "成功：", $ret);
        if (strpos($ret, "-") !== false) $ret = str_replace("-", "失败，原因是：", $ret);
        if (strpos($ret, ":") !== false) $ret = str_replace(":", "操作数量：", $ret);
        echo $ret, PHP_EOL;
    } else {
        if (strpos($ret[0], "*") !== false) {
            $response = [];
            $i = 0;
            foreach($ret as $v){
                if ($i == 0 || $i % 2 != 0 ) {
                    $i++;
                    continue;
                }
                $response[] = $v;
                $i++;
            }
            print_r($response);
        } else {
            echo $ret[1], PHP_EOL;
        }
    }

}


