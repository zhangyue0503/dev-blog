# PHP密码散列算法的学习

不知道大家有没有看过 Laravel 的源码。在 Laravel 源码中，对于用户密码的加密，使用的是 password_hash() 这个函数。这个函数是属于 PHP 密码散列算法扩展中所包含的函数，它是集成在 PHP 源码中的扩展，并且还是 PHP 官方所推荐的一种密码加密方式。那么它有什么好处呢？

实际上，password_hash() 这一系列的函数是对 crypt() 这个加密函数的一种封装。crypt() 函数也是一种单向散列函数，默认情况下是基于 UNIX DES 算法，这个函数的盐值是可选参数，如果没有盐值的话，它会生成的是一种简单的弱密码，所以在 PHP5.6 之后如果 crypt() 函数没有给盐值的话会报警告错误。而 password_hash() 就是在它的基础上增加了一套可靠的随机盐值生成器并封装在这一个函数中了。具体内容我们通过下面的代码一步一步来进行学习。

## 查看密码散列函数的加密算法

首先，我们还是看看当前环境中所支持的 password_hash() 算法。

```php
print_r(password_algos());
// Array
// (
//     [0] => 2y
// )
```

可以看出，当前环境中，我们只有 2y 这一种算法可以使用，这个函数是 PHP7.4 才提供的。我们简单的了解一下即可。

## 使用密码散列函数加密数据

重点还是在这个加密函数的应用上，我们就来看看 password_hash() 这个函数的使用。这个函数是在 PHP5.5 之后就已经提供了，大家可以放心地使用。

```php
echo password_hash("this is password", PASSWORD_DEFAULT), PHP_EOL;
// $2y$10$vOI56sADJPhebhzq5Bj1quM7grMex3Y4NlI99C3qP83iveEGnfdd.

echo password_hash("this is password", PASSWORD_DEFAULT), PHP_EOL;
// $2y$10$YMq8zsTw32HCOeWmlLSpruWKiSoO/rlNu2OVcIV4hlVSY4enn8GwS
```

没错，就是这么地简单，PASSWORD_DEFAULT 是我们指定的加密算法，这里我们给的就是一个默认值。然而加密出来的数据并不是像 md5() 之类的是一个 16进制 字符串呀。是的，password_hash() 加密出来的内容并不是 md5 类型的 Hash 串，而是类似于像 JWT 一样的一套加密字符串。关于 JWT 的内容大家可以自行了解一下，在这里，最主要的就是 password_hash() 加密出来的内容和 JWT 一样，在加密串的里面是包含一些信息的，比如加密循环次数和盐值信息。这些信息是后面我们进行密码匹配时所必须的内容。有人又说了，既然有盐值，为什么我们没有定义这个盐值呀，这样我们后面如何匹配呢？就像前面说的那样，这个加密后的字符串本身已经包含了盐值信息，而且这个盐值信息是系统随机生成的，只能使用对应的比较函数才能比较原始明文密码和加密后的密码是否一致，这样就能让系统的安全性提高很多。请注意上面的测试代码，我们两段代码的明文是一样的，但是加密出来的密码散列可是完全不相同的哦。当然，更重要的是，这个加密后的密码也是不可反解码的，是一个正规的单向 Hash 散列。所以它是非常安全的一个密码加密函数，这也是官方推荐它的原因。

那么，我们可以指定它的盐值吗？当然可以。

```php
$options = [
    'cost' => 12,
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options), PHP_EOL;
// $2y$12$YjEdiCJHAmPCoidNvgrZq.k4VH3ShoELWlyU9POHD5sV3L1WW4.vS

$options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);
// $2y$11$syLcOhq1Mfc32cWVi1zyLOvSn.AtcCre.kY999uUXZ6pS3nXNv1lmPHP
```

最后一个参数是一个选项数组，在这个选项数组中，cost 代表加密循环次数（循环加密多少次），salt 当然就是我们的盐值了，这里使用的是 mcrypt_create_iv() 生成的，我们也可以使用自己生成的随机字符串来当做 salt 使用。

不过，划重点了，在 PHP7 以后，选项参数数组中的 salt 已经是被标记成过时废弃状态了。如果使用这个的话，会报出 deprecated 警告。也就是说，官方期望我们还是不要使用自定义的 salt 来进行加密，而是使用默认情况下的由系统自动随机生成的 salt 。所以，我们在日常使用中，直接使用第一行代码那种形式进行加密就可以了，有特殊需要的话，可以指定 cost 来改变循环次数，不同的循环次数要根据当前系统的硬件来定，当然越高对于系统来说也需要更高的硬件支持，默认情况下，这个值是 10 。

## 查看加密字符串的信息

```php
$p = password_hash('this is password', PASSWORD_DEFAULT, $options);

print_r(password_get_info($p));
// Array
// (
//     [algo] => 2y
//     [algoName] => bcrypt
//     [options] => Array
//         (
//             [cost] => 11
//         )

// )
```

很简单的一个函数，就是可以帮助我们看到这个加密数据的加密信息，就简单的说下返回的信息内容吧。algo 就是使用的加密算法，前面我们已经看过当前系统中只有 2y 这一种算法，所以我们使用的 PASSWORD_DEFAULT 这个默认算法也就只能是它了。algoName 就是算法的可读名称，我们的算法正式名称就是 bcrypt 算法。options 数组里面其实就是我们给定的选项参数内容。从这个函数就可以看出来，算法的信息真的是包含在了加密后的字符串中。

## 验证密码散列数据格式是否一致

有的时候，我们想要升级当前的密码强度，比如将密码循环次数增加，而数据库中新老算法的密码混杂着记录在一起，这时应该怎么办呢？

```php
var_dump(password_needs_rehash($p, PASSWORD_DEFAULT, $options)); // bool(false)
var_dump(password_needs_rehash($p, PASSWORD_DEFAULT, ['cost'=>5])); // bool(true)
```

password_needs_rehash() 是 PHP 提供给我们的用于比对当前加密串的内容是否和我们所提供的算法和选项一致，如果是一致的返回的是 false ，如果不一致，返回的是 true 。额，这个又有点绕了，不是应该一致返回的是 true 吗？

其实从函数的名字就可以看出来，这个函数的意思是 密码(password) 是否需要(needs) 重新Hash(rehash) 。也就是说，如果算法和选项一致的话，那么这个密码是不需要重新 Hash 的，当然返回的就是 false 啦，而算法或选项有不一致的地方的话，这个密码就是需要重新 Hash 的，返回的就是 true 了。大家一定不要用反了。

## 验证密码

最后，也是最重要的，我们要验证明文密码和加密密码是否一致的时候应该怎么办呢？如果是原来的 md5 方式，我们将明文密码也进行相同的加密之后再用双等号进行比较就可以了。但是 password_hash() 这种就不行了，因为它的 salt 是随机的，也不需要我们去保存，所以即使是相同的字符串，我们也不能保证每次加密的结果是一样的，那么就要使用系统为我们提供的验证函数了。

```php
var_dump(password_verify('this is password', $p)); // bool(true)

var_dump(password_verify('1this is password', $p)); // bool(false)
```

也是非常简单的一个函数，第一个参数是明文密码，第二个就是加密密码，函数内部就会对他们的信息进行比对了。此外，这个比较函数也是能够防御时序攻击的，它对任何循环次数的密码的比较返回时间是固定长度的。关于时序攻击的内容大家请自行百度。

## 总结

既然这套函数已经成为 PHP 官方所推荐的函数了，那自然也是我们日后应该学习的重点内容，就连大部分的 PHP 框架中的用户类型的密码加密也都是使用的这套函数了。我们也就不要再使用 md5 那种加密方式了，而且数据库还得保存我们自己的一个盐值浪费数据库空间，直接使用 password_hash() 方便又安全。

测试代码：

[https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E5%AF%86%E7%A0%81%E6%95%A3%E5%88%97%E7%AE%97%E6%B3%95%E7%9A%84%E5%AD%A6%E4%B9%A0.php](https://github.com/zhangyue0503/dev-blog/blob/master/php/202007/source/PHP%E5%AF%86%E7%A0%81%E6%95%A3%E5%88%97%E7%AE%97%E6%B3%95%E7%9A%84%E5%AD%A6%E4%B9%A0.php)

参考文档：

[https://www.php.net/manual/zh/book.password.php](https://www.php.net/manual/zh/book.password.php)

[https://www.php.net/manual/zh/book.password.php](https://www.php.net/manual/zh/book.password.php)