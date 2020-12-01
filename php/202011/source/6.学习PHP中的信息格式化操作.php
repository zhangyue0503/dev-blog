<?php

// 格式化
$fmt = new MessageFormatter("zh_CN", "{0,number,integer} 只猴子在 {1,number,integer} 颗树上，每只树上有 {2,number} 只猴子");
echo $fmt->format([4560, 123, 4560 / 123]), PHP_EOL;
// 4,560 只猴子在 123 颗树上，每只树上有 37.073 只猴子

$fmt = new MessageFormatter("de", "{0,number,integer} Affen auf {1,number,integer} Bäumen sind {2,number} Affen pro Baum");
echo $fmt->format([4560, 123, 4560 / 123]), PHP_EOL;
// 4.560 Affen auf 123 Bäumen sind 37,073 Affen pro Baum

echo MessageFormatter::formatMessage("zh_CN", "{0,number,integer} 只猴子在 {1,number,integer} 颗树上，每只树上有 {2,number} 只猴子", [4560, 123, 4560 / 123]), PHP_EOL;
// 4,560 只猴子在 123 颗树上，每只树上有 37.073 只猴子

echo MessageFormatter::formatMessage("de", "{0,number,integer} Affen auf {1,number,integer} Bäumen sind {2,number} Affen pro Baum", [4560, 123, 4560 / 123]), PHP_EOL;
// 4.560 Affen auf 123 Bäumen sind 37,073 Affen pro Baum


// 根据格式化规则反向获取规则参数
$fmt = new MessageFormatter('zh_CN', "{0,number,integer} 只猴子在 {1,number,integer} 颗树上，每只树上有 {2,number} 只猴子");
$res = $fmt->parse("4,560 只猴子在 123 树上，每只树上有 37.073 只猴子");
var_export($res); // false
echo "ERROR: " . $fmt->getErrorMessage() . " (" . $fmt->getErrorCode() . ")\n";
// ERROR: Parsing failed: U_MESSAGE_PARSE_ERROR (6)

$fmt = new MessageFormatter('en_US', "{0,number,integer} monkeys on {1,number,integer} trees make {2,number} monkeys per tree");
$res = $fmt->parse("4,560 monkeys on 123 trees make 37.073 monkeys per tree");
var_export($res);
// array (
//     0 => 4560,
//     1 => 123,
//     2 => 37.073,
//   )

$fmt = new MessageFormatter('de', "{0,number,integer} Affen auf {1,number,integer} Bäumen sind {2,number} Affen pro Baum");
$res = $fmt->parse("4.560 Affen auf 123 Bäumen sind 37,073 Affen pro Baum");
var_export($res);
// array (
//     0 => 4560,
//     1 => 123,
//     2 => 37.073,
//   )

$fmt = MessageFormatter::parseMessage('de', "{0,number,integer} Affen auf {1,number,integer} Bäumen sind {2,number} Affen pro Baum", "4.560 Affen auf 123 Bäumen sind 37,073 Affen pro Baum");
var_export($fmt);
// array (
//     0 => 4560,
//     1 => 123,
//     2 => 37.073,
//   )

// 设置获取规则
$fmt = new MessageFormatter("zh_CN", "{0, number} 猴子在 {1, number} 颗树上");
echo "默认规则: '" . $fmt->getPattern(), PHP_EOL; // 默认规则: '{0, number} 猴子在 {1, number} 颗树上'
echo "格式化结果：" . $fmt->format(array(123, 456)), PHP_EOL; // 格式化结果：123 猴子在 456 颗树上

$fmt->setPattern("{0, number} 颗树上有 {1, number} 猴子");
echo "新规则： '" . $fmt->getPattern(), PHP_EOL; // 新规则： '{0, number} 颗树上有 {1, number} 猴子'
echo "新规则格式化结果： " . $fmt->format(array(123, 456)), PHP_EOL; // 新规则格式化结果： 123 颗树上有 456 猴子


// 格式化完整示例
echo MessageFormatter::formatMessage('zh_CN', '今天是 {3, date, full}，当前时间为 {3, time, ::Hms}, 我要准备开始 {0} 了，今天要和 {2,number,integer} 人见面，还不能忘了要交 {1,number,currency} 元的电费', ['上班', 35.33, 25, new DateTime()]), PHP_EOL;
// 今天是 2020年11月16日星期一，当前时间为 10:09:30, 我要准备开始 上班 了，今天要和 25 人见面，还不能忘了要交 ￥35.33 元的电费


// 复数形式
echo MessageFormatter::formatMessage('en_US', 'I Have {0, plural, =0{no cat} =1{a cat} other{# cats}}', [0]),PHP_EOL; // I Have no cat
echo MessageFormatter::formatMessage('en_US', 'I Have {0, plural, =0{no cat} =1{a cat} other{# cats}}', [1]),PHP_EOL; // I Have a cat
echo MessageFormatter::formatMessage('en_US', 'I Have {0, plural, =0{no cat} =1{a cat} other{# cats}}', [2]),PHP_EOL; // I Have 2 cats

echo MessageFormatter::formatMessage('zh_CN', '我{0, plural, =0{没有猫} other{有 # 只猫}}', [0]),PHP_EOL; // 我没有猫
echo MessageFormatter::formatMessage('zh_CN', '我{0, plural, =0{没有猫} other{有 # 只猫}}', [1]),PHP_EOL; // 我有 1 只猫
echo MessageFormatter::formatMessage('zh_CN', '我{0, plural, =0{没有猫} other{有 # 只猫}}', [2]),PHP_EOL; // 我有 2 只猫

echo MessageFormatter::formatMessage('en_US', 'I Have {0, plural, =0{no cat} =1{a cat} other{# cats}}', [-1]),PHP_EOL; // I Have -1 cats

// 选择表达式
echo MessageFormatter::formatMessage('en_US', 'I Have {0, choice, 0 #no cats| 1 #one cat | 2 #{0, number} cats}', [-1]),PHP_EOL; // I Have no cats
echo MessageFormatter::formatMessage('en_US', 'I Have {0, choice, 0 #no cats| 1 #one cat | 2 #{0, number} cats}', [0]),PHP_EOL; // I Have no cats
echo MessageFormatter::formatMessage('en_US', 'I Have {0, choice, 0 #no cats| 1 #one cat | 2 #{0, number} cats}', [1]),PHP_EOL; // I Have one cat
echo MessageFormatter::formatMessage('en_US', 'I Have {0, choice, 0 #no cats| 1 #one cat | 2 #{0, number} cats}', [2]),PHP_EOL; // I Have 2 cats
echo MessageFormatter::formatMessage('en_US', 'I Have {0, choice, 0 #no cats| 1 #one cat | 2 #{0, number} cats}', [10]),PHP_EOL; // I Have 10 cats


