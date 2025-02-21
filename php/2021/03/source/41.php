<?php

if($_GET['session_id']) session_id($_GET['session_id']);
// // session_save_path('./');

// // session_module_name('redis');
// // session_save_path('tcp://127.0.0.1:6379');

// session_cache_limiter('private');

// session_set_cookie_params(3600,'', '', true);

// echo session_status(), "<br/>"; // 1

session_start();

// echo session_status(), "<br/>"; // 2

print_r($_SESSION['user']);
echo "<br/>";

// echo session_cache_expire(), "<br/>"; // 180
// echo session_cache_limiter(), "<br/>"; // nocache

// echo session_id(), "<br/>"; // i3tdf5bmmdq8eduh56ja7s87ka
// echo session_create_id(), "<br/>"; // bc9gkjbrepi3g8ku6udmk15588
// echo session_id(), "<br/>"; // i3tdf5bmmdq8eduh56ja7s87ka

// echo session_encode(), "<br/>"; // user|a:2:{s:2:"id";i:1;s:4:"name";s:9:"test_user";}

// echo session_decode('user1|a:2:{s:2:"id";i:1;s:4:"name";s:10:"test_user1";}'), "<br/>";
// print_r($_SESSION);
// // Array
// // (
// //     [user] => Array
// //         (
// //             [id] => 1
// //             [name] => test_user
// //         )

// //     [user1] => Array
// //         (
// //             [id] => 1
// //             [name] => test_user1
// //         )

// // )
// echo "<br/>";

// print_r(session_get_cookie_params());
// // Array
// // (
// //     [lifetime] => 0
// //     [path] => /
// //     [domain] => 
// //     [secure] => 
// //     [httponly] => 
// //     [samesite] => 
// // )
// // Array
// // (
// //     [lifetime] => 3600
// //     [path] => 
// //     [domain] => 
// //     [secure] => 1
// //     [httponly] => 
// //     [samesite] => 
// // )

// echo "<br/>";

// echo session_module_name(), "<br/>"; // files
// echo session_save_path(), "<br/>";

// echo session_name(), "=", session_id(), "<br/>"; // PHPSESSID=i3tdf5bmmdq8eduh56ja7s87ka

// session_regenerate_id();
// echo session_name(), "=", session_id(), "<br/>"; // PHPSESSID=ei23t1pu0lr20o64qajl52m1na

// echo $_SESSION['A'], "<br>";
// $_SESSION['A'] = 'Bar';
// session_reset();
// echo $_SESSION['A'], "<br>";

