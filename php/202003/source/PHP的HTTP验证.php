<?php

// if (!isset($_SERVER['PHP_AUTH_USER'])) {
//     header('WWW-Authenticate: Basic realm="My Realm"');
//     header('HTTP/1.0 401 Unauthorized');
//     echo 'Text to send if user hits Cancel button';
//     exit;
// } else {
//     echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
//     echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
// }
// // Authorization: Basic YWFhOmFhYQ==
// echo base64_decode('YWFhOmFhYQ==');
// // aaa:aaa 等于明文
// // exit;

$realm = 'Restricted area';

//user => password
$users = array('admin' => 'mypass', 'guest' => 'guest');

// 指定 Digest 验证方式
if (empty($_SERVER['PHP_AUTH_DIGEST']) || !$_COOKIE['login']) {
    setcookie('login', 1);  // 退出登录条件判断
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="' . $realm .
        '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');
    
    // 如果用户不输入密码点了取消
    die('您点了取消，无法登录');
    
}

// 验证用户登录信息
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])) {
    die('Wrong Credentials!');
}

// 验证登录信息
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
$valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);
// $data['response'] 是浏览器客户端的加密内容
if ($data['response'] != $valid_response) {
    die('Wrong Credentials!');
}

// 用户名密码验证成功
echo '您的登录用户为: ' . $data['username'];
setcookie("login", 2);

// Authorization: Digest username="guest", realm="Restricted area", nonce="5e815bcbb4eba", uri="/", response="9286ea8d0fac79d3a95fff3e442d6d79", opaque="cdce8a5c95a1427d74df7acbf41c9ce0", qop=auth, nc=00000002, cnonce="a42e137359673851"
// 服务器回复报文中的nonce值，加上username，password, http method, http uri利用MD5（或者服务器指定的其他算法）计算出request-digest，作为repsonse头域的值


// 获取登录信息
function http_digest_parse($txt)
{
    // echo $txt;
    // protect against missing data
    $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

if($_GET['logout']){

    setcookie("login", 0);
    header("Location: /");
}
