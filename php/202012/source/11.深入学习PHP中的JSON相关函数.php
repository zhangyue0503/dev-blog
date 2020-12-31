<?php

$data = [
    'id' => 1,
    'name' => '测试情况',
    'cat' => [
        '学生 & "在职"',
    ],
    'number' => "123123123",
    'edu' => [
        [
            'name' => '<b>中学</b>',
            'date' => '2015-2018',
        ],
        [
            'name' => '<b>大学</b>',
            'date' => '2018-2022',
        ],
    ],
];

$json1 = json_encode($data);
var_dump($json1);
// string(215) "{"id":1,"name":"\u6d4b\u8bd5\u60c5\u51b5","cat":["\u5b66\u751f & \"\u5728\u804c\""],"number":"123123123","edu":[{"name":"<b>\u4e2d\u5b66<\/b>","date":"2015-2018"},{"name":"<b>\u5927\u5b66<\/b>","date":"2018-2022"}]}"

$json1 = json_encode($data, JSON_UNESCAPED_UNICODE);
var_dump($json1);
// string(179) "{"id":1,"name":"测试情况","cat":["学生 & \"在职\""],"number":"123123123","edu":[{"name":"<b>中学<\/b>","date":"2015-2018"},{"name":"<b>大学<\/b>","date":"2018-2022"}]}"

function t($data)
{
    foreach ($data as $k => $d) {
        if (is_object($d)) {
            $d = (array) $d;
        }
        if (is_array($d)) {
            $data[$k] = t($d);
        } else {
            $data[$k] = urlencode($d);
        }
    }
    return $data;
}
$newData = t($data);

$json1 = json_encode($newData);
var_dump(urldecode($json1));
// string(177) "{"id":"1","name":"测试情况","cat":["学生 & "在职""],"number":"123123123","edu":[{"name":"<b>中学</b>","date":"2015-2018"},{"name":"<b>大学</b>","date":"2018-2022"}]}"

$json1 = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_NUMERIC_CHECK | JSON_HEX_QUOT);
var_dump($json1);
// string(230) "{"id":1,"name":"测试情况","cat":["学生 \u0026 \u0022在职\u0022"],"number":123123123,"edu":[{"name":"\u003Cb\u003E中学\u003C\/b\u003E","date":"2015-2018"},{"name":"\u003Cb\u003E大学\u003C\/b\u003E","date":"2018-2022"}]}"

var_dump(json_encode($data, JSON_UNESCAPED_UNICODE, 1)); // bool(false)

$data = [];
var_dump(json_encode($data)); // string(2) "[]"
var_dump(json_encode($data, JSON_FORCE_OBJECT)); // string(2) "{}"

$data = NAN;
var_dump(json_encode($data)); // bool(false)
var_dump(json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR)); // 0

$data = new class

{
    private $a = 1;
    protected $b = 2;
    public $c = 3;

    function x()
    {

    }
};
var_dump(json_encode($data)); // string(7) "{"c":3}"

var_dump(json_decode($json1));
// object(stdClass)#1 (5) {
//     ["id"]=>
//     int(1)
//     ["name"]=>
//     string(12) "测试情况"
//     ["cat"]=>
// ……
// ……

var_dump(json_decode($json1, true));
// array(5) {
//     ["id"]=>
//     int(1)
//     ["name"]=>
//     string(12) "测试情况"
//     ["cat"]=>
// ……
// ……

var_dump(json_decode('{"a":1321231231231231231231231231231231231231231231231231231231231231231231233}', true));
// array(1) {
//     ["a"]=>
//     float(1.3212312312312E+72)
//   }

var_dump(json_decode('{"a":1321231231231231231231231231231231231231231231231231231231231231231231233}', true, 512, JSON_BIGINT_AS_STRING));
// array(1) {
//     ["a"]=>
//     string(73) "1321231231231231231231231231231231231231231231231231231231231231231231233"
//   }

var_dump(json_decode("", true)); // NULL
var_dump(json_decode("{a:1}", true)); // NULL

$data = NAN;
var_dump(json_encode($data)); // bool(false)
var_dump(json_last_error()); // int(7)
var_dump(json_last_error_msg()); // string(34) "Inf and NaN cannot be JSON encoded"

// php7.3
// var_dump(json_encode($data, JSON_THROW_ON_ERROR));
// Fatal error: Uncaught JsonException: Inf and NaN cannot be JSON encoded

// var_dump(json_decode('', true, 512, JSON_THROW_ON_ERROR));
// PHP Fatal error:  Uncaught JsonException: Syntax error

try {
    var_dump(json_encode($data, JSON_THROW_ON_ERROR));
} catch (JsonException $e) {
    var_dump($e->getMessage()); // string(34) "Inf and NaN cannot be JSON encoded"
}

class jsontest implements JsonSerializable
{
    public function __construct($value)
    {$this->value = $value;}
    public function jsonSerialize()
    {return $this->value;}
}

print "Null -> " . json_encode(new jsontest(null)) . "\n";
print "Array -> " . json_encode(new jsontest(array(1, 2, 3))) . "\n";
print "Assoc. -> " . json_encode(new jsontest(array('a' => 1, 'b' => 3, 'c' => 4))) . "\n";
print "Int -> " . json_encode(new jsontest(5)) . "\n";
print "String -> " . json_encode(new jsontest('Hello, World!')) . "\n";
print "Object -> " . json_encode(new jsontest((object) array('a' => 1, 'b' => 3, 'c' => 4))) . "\n";
// Null -> null
// Array -> [1,2,3]
// Assoc. -> {"a":1,"b":3,"c":4}
// Int -> 5
// String -> "Hello, World!"
// Object -> {"a":1,"b":3,"c":4}

class Student implements JsonSerializable
{
    private $id;
    private $name;
    private $cat;
    private $number;
    private $edu;
    public function __construct($id, $name, $cat = null, $number = null, $edu = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cat = $cat;
        $this->number = $number;
        $this->edu = $edu;

    }
    public function jsonSerialize()
    {
        if (!$cat) {
            $this->cat = ['学生'];
        }
        if (!$edu) {
            $this->edu = new stdClass;
        }
        $this->number = '学号：' . (!$number ? mt_rand() : $number);
        if ($this->id == 2) {
            return [
                $this->id,
                $this->name,
                $this->cat,
                $this->number,
                $this->edu,
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cat' => $this->cat,
            'number' => $this->number,
            'edu' => $this->edu,
        ];
    }
}

var_dump(json_encode(new Student(1, '测试一'), JSON_UNESCAPED_UNICODE));
// string(82) "{"id":1,"name":"测试一","cat":["学生"],"number":"学号：14017495","edu":{}}"

var_dump(json_encode([new Student(1, '测试一'), new Student(2, '测试二')], JSON_UNESCAPED_UNICODE));
// string(137) "[{"id":1,"name":"测试一","cat":["学生"],"number":"学号：1713936069","edu":{}},[2,"测试二",["学生"],"学号：499173036",{}]]"
