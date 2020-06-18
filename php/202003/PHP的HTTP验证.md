# PHP的HTTP验证

在日常开发中，我们进行用户登录的时候，大部分情况下都会使用 session 来保存用户登录信息，并以此为依据判断用户是否已登录。但其实 HTTP 也提供了这种登录验证机制，我们今天就来学习关于 HTTP 验证相关的知识。

## HTTP Basic

```php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}
// Authorization: Basic YWFhOmFhYQ==
echo base64_decode('YWFhOmFhYQ==');
// aaa:aaa 等于明文
```

还是直接就从代码入手，上面的代码就是最简单的一种 HTTP 认证方式，如果 $_SERVER['PHP_AUTH_USER'] 不存在，那么我们就向浏览器发送一个 401 响应头，就是告诉浏览器我们需要登录验证。当浏览器收到这个响应头时，就会弹出一个浏览器自带的验证框并要求输入用户名和密码。

当我们填写了用户名和密码后，浏览器会在请求头中带上 Authorization 字段，并且将 base64 之后的用户名和密码发送过来。同时，PHP将会分别把用户名和密码解析到 \\$_SERVER['PHP_AUTH_USER'] 和 $_SERVER['PHP_AUTH_PW'] 中。

上述这种认证方式就是最简单的 HTTP Basic 认证，可以看出，这种方式进行验证的用户名和密码其实是相当于明文传输的，因为 base64 很容易就可以反向解析出来。所以这种方式是非常不安全的。那么有没有更复杂一些的方式呢？

## HTTP Digest

既然这么写了，那肯定是有更好的方式啦，那就是 HTTP Digest 方式的 HTTP 认证。

```php
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

```

从代码量就可以看出这种方式复杂了很多。首先是我们一样需要在未登录的情况下返回 401 响应头，告诉浏览器我们要进行 Digest 认证。这里 header 信息就有不一样的地方了，格式是 Digest ，内容也比 Basic 多了许多，这些多出来的内容都是我们在验证认证内容的时候需要用到的。

接着，浏览器一样是会弹出输入用户名和密码的弹窗。然后将加密后的用户名和密码信息提交上来。我们可以看到返回值里有明文的 username ，但是没有明文的密码了。其实密码是通过 username 、 密码 、 nonce 、 nc 、 cnoce 、cop 、$_SERVER['REQUEST_METHOD'] 、 uri 等这些内容进行 md5 加密后生成的，放在了 response 字段中提交了上来。我们也需要按照同样的规则获得加密后的密码进行比对就可以判定用户名和密码正确从而让用户完成正常的登录流程。

在这段代码中，我们加入了一个 cookie ，是为了做退出登录的判断使用的。因为 HTTP 认证这种形式的过期时间是以浏览器为基准的。也就是如果客户端关闭了浏览器，则客户端浏览器内存中保存的用户名和密码才会消失。这种情况下我们只能通过 cookie 来进行退出登录的操作，如果用户退出登录了就改变这个 cookie 的内容并重新发送 401 响应头给浏览要求重新登录。

## 总结

HTTP 验证的这种操作一般不会做为我们日常开发中的正常登录功能，大部分情况下，我们会给后台或者一些特殊的管理工具加上一层这种 HTTP 认证来实现双重的认证，也就是为了保障后台的数据安全。比如，我会在我的 phpMyAdmin 上增加一层这个认证。另外，HTTP 认证也可以直接在 Nginx 或 Apache 中直接配置，不需要走到 PHP 这一层来，这个我们将来学习 Nginx 的时候会再做说明。

测试代码：
[https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/PHP%E7%9A%84HTTP%E9%AA%8C%E8%AF%81.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202003/source/PHP%E7%9A%84HTTP%E9%AA%8C%E8%AF%81.php)

参考文档：
[https://www.php.net/manual/zh/features.http-auth.php](https://www.php.net/manual/zh/features.http-auth.php)