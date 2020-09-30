<?php

$mysqli = mysqli_connect("localhost", "root", "", "blog_test");
$res = mysqli_query($mysqli, "SELECT * FROM zyblog_test_user");
$row = mysqli_fetch_assoc($res);
print_r($row);


$mysqli = new mysqli("localhost", "root", "", "blog_test");
$res = $mysqli->query("SELECT * FROM zyblog_test_user");
$row = $res->fetch_assoc();
print_r($row);

$mysqli = new mysqli("localhost", "root", "", "blog_test");
$res = mysqli_query($mysqli, "SELECT * FROM zyblog_test_user");
$row = $res->fetch_assoc();
print_r($row);
