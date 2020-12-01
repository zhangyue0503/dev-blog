<?php




$arr = ['我','是','硬','核','项', '目', '经', '理'];
sort($arr);
var_dump( $arr );
// array(8) {
//     [0]=>
//     string(3) "我"
//     [1]=>
//     string(3) "是"
//     [2]=>
//     string(3) "核"
//     [3]=>
//     string(3) "理"
//     [4]=>
//     string(3) "目"
//     [5]=>
//     string(3) "硬"
//     [6]=>
//     string(3) "经"
//     [7]=>
//     string(3) "项"
//   }

$coll = new Collator( 'zh_CN' );

$coll->sort($arr);
var_dump( $arr );
// array(8) {
//     [0]=>
//     string(3) "核"
//     [1]=>
//     string(3) "经"
//     [2]=>
//     string(3) "理"
//     [3]=>
//     string(3) "目"
//     [4]=>
//     string(3) "是"
//     [5]=>
//     string(3) "我"
//     [6]=>
//     string(3) "项"
//     [7]=>
//     string(3) "硬"
//   }

$coll->sort($arr, Collator::SORT_NUMERIC );
var_dump( $arr );
// array(8) {
//     [0]=>
//     string(3) "核"
//     [1]=>
//     string(3) "经"
//     [2]=>
//     string(3) "理"
//     [3]=>
//     string(3) "目"
//     [4]=>
//     string(3) "是"
//     [5]=>
//     string(3) "我"
//     [6]=>
//     string(3) "项"
//     [7]=>
//     string(3) "硬"
//   }

$coll->sort($arr, Collator::SORT_STRING );
var_dump( $arr );
// array(8) {
//     [0]=>
//     string(3) "核"
//     [1]=>
//     string(3) "经"
//     [2]=>
//     string(3) "理"
//     [3]=>
//     string(3) "目"
//     [4]=>
//     string(3) "是"
//     [5]=>
//     string(3) "我"
//     [6]=>
//     string(3) "项"
//     [7]=>
//     string(3) "硬"
//   }


$arr = [
    'a' => '100',
    'b' => '7',
    'c' => '50'
];
$coll->asort($arr, Collator::SORT_NUMERIC );
var_dump( $arr );
// array(3) {
//     ["b"]=>
//     string(1) "7"
//     ["c"]=>
//     string(2) "50"
//     ["a"]=>
//     string(3) "100"
//   }

$coll->asort($arr, Collator::SORT_STRING );
var_dump( $arr );
// array(3) {
//     ["a"]=>
//     string(3) "100"
//     ["c"]=>
//     string(2) "50"
//     ["b"]=>
//     string(1) "7"
//   }

$arr = [
    '中' => '100',
    '的' => '7',
    '文' => '50'
];
$coll->asort($arr, Collator::SORT_NUMERIC );
var_dump( $arr );
// array (
//     '的' => '7',
//     '文' => '50',
//     '中' => '100',
//   )

$coll->asort($arr, Collator::SORT_STRING );
var_dump( $arr );
// array (
//     '中' => '100',
//     '文' => '50',
//     '的' => '7',
//   )



$arr = ['我','是','硬','核','项', '目', '经', '理'];
$coll->sortWithSortKeys($arr);
var_dump( $arr );
// array (
//     0 => '核',
//     1 => '经',
//     2 => '理',
//     3 => '目',
//     4 => '是',
//     5 => '我',
//     6 => '项',
//     7 => '硬',
//   )

var_dump($coll->compare('Hello', 'hello')); // int(1)
var_dump($coll->compare('你好', '您好')); // int(-1)

var_dump($coll->getAttribute(Collator::CASE_FIRST)); // int(16)


$coll->setAttribute(Collator::CASE_FIRST, Collator::UPPER_FIRST);
var_dump($coll->getAttribute(Collator::CASE_FIRST)); // int(25)
var_dump($coll->compare('Hello', 'hello')); // int(-1)

$coll->setAttribute(Collator::CASE_FIRST, Collator::LOWER_FIRST);
var_dump($coll->getAttribute(Collator::CASE_FIRST)); // int(24)
var_dump($coll->compare('Hello', 'hello')); // int(1)

$coll->setAttribute(Collator::CASE_FIRST, Collator::OFF);
var_dump($coll->getAttribute(Collator::CASE_FIRST)); // int(16)
var_dump($coll->compare('Hello', 'hello')); // int(1)





var_dump($coll->getLocale(Locale::VALID_LOCALE)); // string(10) "zh_Hans_CN"
var_dump($coll->getLocale(Locale::ACTUAL_LOCALE)); // string(2) "zh"

var_dump(bin2hex($coll->getSortKey('Hello'))); // string(20) "b6b0bebec4010901dc08"
var_dump(bin2hex($coll->getSortKey('hello'))); // string(18) "b6b0bebec401090109"
var_dump(bin2hex($coll->getSortKey('你好'))); // string(16) "7b9b657301060106"
var_dump(bin2hex($coll->getSortKey('您好'))); // string(16) "7c33657301060106"

$coll = collator_create( 'en_US' );

var_dump($coll->compare('Hello', 'hello')); // int(1)
var_dump($coll->compare('你好', '您好')); // int(-1)

var_dump($coll->getLocale(Locale::VALID_LOCALE)); // string(5) "en_US"
var_dump($coll->getLocale(Locale::ACTUAL_LOCALE)); // string(4) "root"

var_dump(bin2hex($coll->getSortKey('Hello'))); // string(20) "3832404046010901dc08"
var_dump(bin2hex($coll->getSortKey('hello'))); // string(18) "383240404601090109"
var_dump(bin2hex($coll->getSortKey('你好'))); // string(20) "fb0b8efb649401060106"
var_dump(bin2hex($coll->getSortKey('您好'))); // string(20) "fba5f8fb649401060106"


$coll = new Collator( 'lt' );;
$coll->compare( 'y', 'k' ); 
var_dump($coll->getErrorCode()); // int(0)
var_dump($coll->getErrorMessage()); // string(12) "U_ZERO_ERROR"

$arr  = array( 'a', 'à' ,'A');
$coll = new Collator( 'de_DE' );

$coll->sort($arr);
var_dump($coll->getStrength());
var_dump( $arr ); // int(2)
// array(3) {
//     [0]=>
//     string(1) "a"
//     [1]=>
//     string(1) "A"
//     [2]=>
//     string(2) "à"
//   }

$coll->setStrength(Collator::IDENTICAL);
var_dump($coll->getStrength()); // int(15)
$coll->sort($arr);
var_dump( $arr );

$coll->setStrength(Collator::QUATERNARY);
var_dump($coll->getStrength()); // int(3)
$coll->sort($arr);
var_dump( $arr );

$coll->setStrength(Collator::PRIMARY);
var_dump($coll->getStrength()); // int(0)
$coll->sort($arr );
var_dump( $arr );

$coll->setStrength(Collator::TERTIARY);
var_dump($coll->getStrength()); // int(2)
$coll->sort($arr );
var_dump( $arr );

$coll->setStrength(Collator::SECONDARY);
var_dump($coll->getStrength()); // int(1)
$coll->sort($arr );
var_dump( $arr );