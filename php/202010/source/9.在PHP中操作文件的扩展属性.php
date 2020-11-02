<?php

$file = __FILE__;

var_dump(xattr_set($file, 'Author', 'ZyBlog')); // bool(true)
var_dump(xattr_set($file, 'Num.', 121 )); // bool(true)
var_dump(xattr_set($file, 'Description', 'shuo ming', XATTR_ROOT)); // bool(true)


var_dump(xattr_list($file, XATTR_ROOT));
// array(1) {
//     [0]=>
//     string(11) "Description"
//   }

var_dump(xattr_list($file));
// array(2) {
//     [0]=>
//     string(4) "Num."
//     [1]=>
//     string(6) "Author"
//   }

var_dump(xattr_get($file, 'Author')); // string(6) "ZyBlog"
var_dump(xattr_get($file, 'Description')); // bool(false)
var_dump(xattr_get($file, 'Description', XATTR_ROOT)); // string(9) "shuo ming"

var_dump(xattr_remove($file, 'Num.')); // bool(true)
var_dump(xattr_list($file));
// array(1) {
//     [0]=>
//     string(6) "Author"
//   }

var_dump(xattr_supported($file)); // bool(true)
