<?php

// --with-zlib

// 创建压缩包
$zp = gzopen('./gztest.gz', "w9");

gzwrite($zp, "Only test, test, test, test, test, test!\n");

gzclose($zp);


// 读取压缩包
$zp = gzopen('./gztest.gz', "r");

echo gzread($zp, 3);

gzpassthru($zp); // 输出 gz 文件指针中的所有剩余数据
// Only test, test, test, test, test, test!
echo PHP_EOL;


gzpassthru($zp);
//

gzrewind($zp); // 将 gz 指针的游标返回到最开始的位置
gzpassthru($zp);
// Only test, test, test, test, test, test!
echo PHP_EOL;

gzclose($zp);

// 读取压缩包二
$gz = gzopen('./gztest.gz', 'r');
while (!gzeof($gz)) {
  echo gzgetc($gz);
}
gzclose($gz);
// Only test, test, test, test, test, test!
echo PHP_EOL;

// 读取压缩包三
echo readgzfile("./gztest.gz");
// Only test, test, test, test, test, test!
echo PHP_EOL;

// 读取压缩包四
print_r(gzfile("./gztest.gz"));
// Array
// (
//     [0] => Only test, test, test, test, test, test!
// )
echo PHP_EOL;

// 压缩类型及相关操作
// gzcompress 默认使用ZLIB_ENCODING_DEFLATE编码，使用zlib压缩格式，实际上是用 deflate 压缩数据，然后加上 zlib 头和 CRC 校验
$compressed = gzcompress('Compress me', 9);
echo $compressed;
// x�s��-(J-.V�M�?
echo PHP_EOL;

echo gzuncompress($compressed);
// Compress me
echo PHP_EOL;

// gzencode 默认使用ZLIB_ENCODING_GZIP编码，使用gzip压缩格式，实际上是使用defalte 算法压缩数据，然后加上文件头和adler32校验
$compressed = gzencode('Compress me', 9);
echo $compressed;
// s��-(J-.V�M�jM4
echo PHP_EOL;

echo gzdecode($compressed);
// Compress me
echo PHP_EOL;

// gzdeflate 默认使用ZLIB_ENCODING_RAW编码方式，使用deflate数据压缩算法，实际上是先用 LZ77 压缩，然后用霍夫曼编码压缩
$compressed = gzdeflate('Compress me', 9);
echo $compressed;
// s��-(J-.V�M
echo PHP_EOL;

echo gzinflate($compressed);
// Compress me
echo PHP_EOL;

// 从性能的维度看：deflate 好于 gzip 好于 zlib

// 从文本文件默认压缩率压缩后体积的维度看：deflate 好于 zlib 好于 gzip

// 通用压缩函数
$compressed = zlib_encode('Compress me', ZLIB_ENCODING_GZIP, 9);
echo $compressed;
// ZLIB_ENCODING_RAW：s��-(J-.V�M
// ZLIB_ENCODING_DEFLATE：x�s��-(J-.V�M�?
// ZLIB_ENCODING_GZIP：s��-(J-.V�M�jM4
echo PHP_EOL;

echo zlib_get_coding_type();
echo PHP_EOL;

echo zlib_decode($compressed);
// Compress me
echo PHP_EOL;

// PHP7 新增的增量压缩操作函数
$deflateContext = deflate_init(ZLIB_ENCODING_GZIP);
$compressed = deflate_add($deflateContext, "数据压缩", ZLIB_NO_FLUSH);
$compressed .= deflate_add($deflateContext, "，更多数据", ZLIB_NO_FLUSH); 
$compressed .= deflate_add($deflateContext, "，继续添加更多数据！", ZLIB_FINISH); // ZLIB_FINISH 终止
echo $compressed, PHP_EOL;
// {6uó�uO����Y�~Oϳ�[�.��
// �>߽���϶�~ڵU�h�9

$inflateContext = inflate_init(ZLIB_ENCODING_GZIP);
$uncompressed = inflate_add($inflateContext, $compressed, ZLIB_NO_FLUSH);
$uncompressed .= inflate_add($inflateContext, NULL, ZLIB_FINISH);
echo $uncompressed;
// 数据压缩，更多数据，继续添加更多数据！


