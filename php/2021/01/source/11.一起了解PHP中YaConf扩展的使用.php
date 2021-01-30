<?php

// php.ini
// yaconf.directory=/tmp/conf/


// /tmp/conf/test.ini
// "/tmp/conf/test.ini" 18L, 204C                                                                                     18,19         All
// foo="bar"
// phpversion=PHP_VERSION
// env=${HOME}

// arr.0=1
// arr.1=2
// arr[]=3
// arr[3]=4

// map.foo=bar
// map.bar=foo
// map.foo.name=yaconf

// [parent]
// parent="base"
// children="NULL"
// [children : parent]
// children="children"

var_dump(Yaconf::get("test.foo")); // string(3) "bar"
var_dump(Yaconf::get("test.phpversion")); // string(5) "7.4.4"
var_dump(Yaconf::get("test.env")); // string(5) "/root"

var_dump(Yaconf::get("test.arr"));
// array(4) {
//     [0]=>
//     string(1) "1"
//     [1]=>
//     string(1) "2"
//     [2]=>
//     string(1) "3"
//     [3]=>
//     string(1) "4"
//   }

var_dump(Yaconf::get("test.arr.1")); // string(1) "2"
var_dump(Yaconf::get("test.map"));
// array(2) {
//     ["foo"]=>
//     array(1) {
//       ["name"]=>
//       string(6) "yaconf"
//     }
//     ["bar"]=>
//     string(3) "foo"
//   }

var_dump(Yaconf::get("test.map.foo.name")); // string(6) "yaconf"

var_dump(Yaconf::get("test.parent.parent")); // string(4) "base"
var_dump(Yaconf::get("test.children.parent")); // string(4) "base"

var_dump(Yaconf::get("test.parent.children")); // string(4) "NULL"
var_dump(Yaconf::get("test.children.children")); // string(8) "children"

var_dump(Yaconf::has("test.foo")); // bool(true)
var_dump(Yaconf::has("test.baz")); // bool(false)

// /tmp/conf/foo.ini
// ;filenmame foo.ini, placed in directory which is yaconf.directoy
// [SectionA]
// ;key value pair
// key=val
// ;hash[a]=val
// hash.a=val
// ;arr[0]=val
// arr.0=val
// ;or
// arr[]=val

// ;SectionB inherits SectionA
// [SectionB:SectionA]
// ;override configuration key in SectionA
// key=new_val

var_dump(Yaconf::get("foo.SectionA.key")); // string(3) "val"