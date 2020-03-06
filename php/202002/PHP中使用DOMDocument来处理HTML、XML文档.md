# PHP中使用DOMDocument来处理HTML、XML文档

其实从PHP5开始，PHP就为我们提供了一个强大的解析和生成XML相关操作的类，也就是我们今天要讲的 DOMDocument 类。不过我估计大部分人在爬取网页时还是会喜欢用正则去解析网页内容，学了今天的这个类下回就可以尝试下使用这个PHP自带的方式来进行解析分析了。

## 解析HTML

```php
// 解析 HTML
$baidu = file_get_contents('https://www.baidu.com');

$doc = new DOMDocument();
@$doc->loadHTML($baidu);

// 百度输出框
$inputSearch = $doc->getElementById('kw');
var_dump($inputSearch);

// object(DOMElement)#2 
//     ....

echo $inputSearch->getAttribute('name'), PHP_EOL; // wd

// 获取所有图片的链接
$allImageLinks = [];
$imgs = $doc->getElementsByTagName('img');
foreach($imgs as $img){
    $allImageLinks[] = $img->getAttribute('src');
}

print_r($allImageLinks);

// Array
// (
//     [0] => //www.baidu.com/img/baidu_jgylogo3.gif
//     [1] => //www.baidu.com/img/bd_logo.png
//     [2] => http://s1.bdstatic.com/r/www/cache/static/global/img/gs_237f015b.gif
// )

// 利用 parse_url 分析链接
foreach($allImageLinks as $link){
    print_r(parse_url($link));
}

// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/baidu_jgylogo3.gif
// )
// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/bd_logo.png
// )
// Array
// (
//     [scheme] => http
//     [host] => s1.bdstatic.com
//     [path] => /r/www/cache/static/global/img/gs_237f015b.gif
// )
```

是不是感觉好清晰，好有面向对象的感觉。就像第一次使用 ORM库 来进行数据库操作一样的感觉。我们一段一段来看。

```php
$baidu = file_get_contents('https://www.baidu.com');

$doc = new DOMDocument();
@$doc->loadHTML($baidu);
```

首先是加载文档内容，这个比较好理解，直接使用 loadHTML() 方法加载 HTML 内容。它还提供了其它的几个方法，分别是：load() 从一个文件加载XML；loadXML() 从字符串加载XML；loadHTMLFile() 从文件加载HTML。

```php
// 百度输出框
$inputSearch = $doc->getElementById('kw');
var_dump($inputSearch);

// object(DOMElement)#2 
//     ....

echo $inputSearch->getAttribute('name'), PHP_EOL; // wd
```

接下来我们使用和前端 JS 一样的 DOM 操作API来操作HTML里面的元素。这个例子中就是获取百度的文本框，直接使用 getElementById() 方法获得id为指定内容的 DOMElement 对象。然后就可以获取它的值、属性之类的内容了。

```php
// 获取所有图片的链接
$allImageLinks = [];
$imgs = $doc->getElementsByTagName('img');
foreach($imgs as $img){
    $allImageLinks[] = $img->getAttribute('src');
}

print_r($allImageLinks);

// Array
// (
//     [0] => //www.baidu.com/img/baidu_jgylogo3.gif
//     [1] => //www.baidu.com/img/bd_logo.png
//     [2] => http://s1.bdstatic.com/r/www/cache/static/global/img/gs_237f015b.gif
// )

// 利用 parse_url 分析链接
foreach($allImageLinks as $link){
    print_r(parse_url($link));
}

// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/baidu_jgylogo3.gif
// )
// Array
// (
//     [host] => www.baidu.com
//     [path] => /img/bd_logo.png
// )
// Array
// (
//     [scheme] => http
//     [host] => s1.bdstatic.com
//     [path] => /r/www/cache/static/global/img/gs_237f015b.gif
// )
```

这一段例子则是获取HTML文档中所有的图片链接。相比正则来说，是不是方便很多，而且代码本身就是自解释的，不用考虑正则的匹配失效的问题。配合另外一个PHP中自带的 parse_url() 方法也能非常方便地对链接进行分析，提取自己想要的内容。

XML的解析和对HTML的解析也是类似的，都使用 DOMDocument 和 DOMElement 提供的这个方法接口就可以很方便的进行解析了。那么我们想要生成一个标准格式的XML呢？当然也非常的简单，不需要再去拼接字符串了，使用这个类一样的进行对象化的操作。

## 生成一个XML

```php
// 生成一个XML文档
$xml = new DOMDocument('1.0', 'UTF-8');

$node1 = $xml->createElement('First', 'This is First Node.');
$node1->setAttribute('type', '1');

$node2 = $xml->createElement('Second');
$node2->setAttribute('type', '2');
$node2_child = $xml->createElement('Second-Child', 'This is Second Node Child.');
$node2->appendChild($node2_child);

$xml->appendChild($node1);
$xml->appendChild($node2);
print $xml->saveXML();

/*
<?xml version="1.0" encoding="UTF-8"?>
<First type="1">This is First Node.</First>
<Second type="2"><Second-Child>This is Second Node Child.</Second-Child></Second>
*/
```

其实只要有一点点的前端 JS 的基础都不难看出这段代码的含义。使用 createElement() 方法创造 DOMElement 对象，然后就可以为它添加属性和内容。使用 appendChild() 方法就可以为当前的 DOMElement 或者 DOMDocument 添加下级节点。最后使用 saveXML() 就能够生成标准的XML格式内容了。

## 总结

通过上面两个简单的小例子，相信大家已经对这个 DOMDocument 操作XML类文件解析的方式非常感兴趣了。不过相对于正则解析的方式它们的性能有多大的差异并没有找到相关的测试，不过一般正常的情况下网站的HMTL文档都不会太大，毕竟各个网站也会考虑自身的加载速度，如果文档非常大的话用户体验也会很差，所以这套接口用来进行日常爬虫的分析处理工作基本是没有任何问题的。

测试代码：


参考文档：
[https://www.php.net/manual/zh/class.domdocument.php](https://www.php.net/manual/zh/class.domdocument.php)
