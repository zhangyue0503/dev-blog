<?php

print_r(sys_get_temp_dir());
// /tmp

$tmpFile = tmpfile();
fwrite($tmpFile, "I'm tmp file.");
// ll /tmp
// vim phpbnAjbE

sleep(10);

fclose($tmpFile);

$tmpFile = tempnam('/Users/zhangyue/MyDoc/博客文章/dev-blog/php/202006/source', 'testtmp');
$f = fopen($tmpFile, "w");
fwrite($f, "I'm tmp file.");
// ll /tmp
// vim testtmpH7bptZ

// etc目录没有写权限
$tmpFile = tempnam('/etc', 'testtmp');
$f = fopen($tmpFile, "w");
fwrite($f, "I'm tmp file.");
// ll /etc
// ll /tmp
// vim testtmpTUNucM
