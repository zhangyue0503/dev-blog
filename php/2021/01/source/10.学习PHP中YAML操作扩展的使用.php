<?php


// http://www.rpmfind.net/linux/rpm2html/search.php?query=libyaml-devel(x86-64)

$addr = array(
    "given" => "Chris",
    "family"=> "Dumars",
    "address"=> array(
        "lines"=> "458 Walkman Dr.
        Suite #292",
        "city"=> "Royal Oak",
        "state"=> "MI",
        "postal"=> 48046,
      ),
  );
$invoice = array (
    "invoice"=> 34843,
    "date"=> 980208000,
    "bill-to"=> $addr,
    "ship-to"=> $addr,
    "product"=> array(
        array(
            "sku"=> "BL394D",
            "quantity"=> 4,
            "description"=> "篮球",
            "price"=> 450,
          ),
        array(
            "sku"=> "BL4438H",
            "quantity"=> 1,
            "description"=> "Super Hoop",
            "price"=> 2392,
          ),
      ),
    "tax"=> 251.42,
    "total"=> 4443.52,
    "comments"=> "Late afternoon is best. Backup contact is Nancy Billsmer @ 338-4338.",
  );

$yamlString = yaml_emit($invoice);
var_dump($yamlString);
// string(624) "---
// invoice: 34843
// date: 980208000
// bill-to:
//   given: Chris
//   family: Dumars
//   address:
//     lines: |-
//       458 Walkman Dr.
//               Suite #292
//     city: Royal Oak
//     state: MI
//     postal: 48046
// ship-to:
//   given: Chris
//   family: Dumars
//   address:
//     lines: |-
//       458 Walkman Dr.
//               Suite #292
//     city: Royal Oak
//     state: MI
//     postal: 48046
// product:
// - sku: BL394D
//   quantity: 4
//   description: "\u7BEE\u7403"
//   price: 450
// - sku: BL4438H
//   quantity: 1
//   description: Super Hoop
//   price: 2392
// tax: 251.42
// total: 4443.52
// comments: Late afternoon is best. Backup contact is Nancy Billsmer @ 338-4338.
// ...
// "

var_dump(yaml_emit($invoice, YAML_UTF8_ENCODING));
// string(616) "---
// ………………
//   description: 篮球
// ………………
// ...
// "

var_dump(yaml_parse($yamlString));
// array(8) {
//     ["invoice"]=>
//     int(34843)
//     ["date"]=>
//     int(980208000)
//     ["bill-to"]=>
//     array(3) {
//       ["given"]=>
//       string(5) "Chris"
//       ["family"]=>
//       string(6) "Dumars"
// ………………
// ………………


var_dump(yaml_parse_file('styleci.yml'));
// array(3) {
//     ["php"]=>
//     array(3) {
//       ["preset"]=>
//       string(7) "laravel"
//       ["disabled"]=>
//       array(1) {
//         [0]=>
//         string(10) "unused_use"
//       }
//       ["finder"]=>
//       array(1) {
//         ["not-name"]=>
//         array(2) {
//           [0]=>
//           string(9) "index.php"
//           [1]=>
//           string(10) "server.php"
//         }
//       }
//     }
//     ["js"]=>
//     array(1) {
//       ["finder"]=>
//       array(1) {
//         ["not-name"]=>
//         array(1) {
//           [0]=>
//           string(14) "webpack.mix.js"
//         }
//       }
//     }
//     ["css"]=>
//     bool(true)
//   }


// php:
//   preset: !laravel laravel
//   disabled:
// ………………
// ………………
function callback($value){
    return str_replace('laravel', 'new version laravel8', $value);
}
$ndocs = 0;
var_dump(yaml_parse_file('styleci.yml', 0, $ndocs, ['!laravel'=>'callback']));
// array(3) {
//     ["php"]=>
//     array(3) {
//       ["preset"]=>
//       string(20) "new version laravel8"
//       ["disabled"]=>
//       array(1) {
// ……………………
// ……………………