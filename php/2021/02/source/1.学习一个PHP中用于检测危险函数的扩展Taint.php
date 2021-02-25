<?php
// php -S 0.0.0.0:9991 1.php

$a = $_GET['a'];
$file_name = '/tmp' .  $a;
$output    = "Welcome, {$a} !!!";
$var       = "output";
$sql       = "Select *  from " . $a;

echo $a, "<br/>"; // Warning: main() [echo]: Attempt to echo a string that might be tainted in /data/www/blog/taint/1.php on line 10

echo $output, "<br/>"; // Warning: main() [echo]: Attempt to echo a string that might be tainted in /data/www/blog/taint/1.php on line 12

print $$var; echo "<br/>"; // Warning: main() [print]: Attempt to print a string that might be tainted in /data/www/blog/taint/1.php on line 14

include($file_name);echo "<br/>"; // Warning: main() [include]: File path contains data that might be tainted in /data/www/blog/taint/1.php on line 16

mysqli_query(null, $sql);echo "<br/>"; // Warning: main() [mysqli_query]: SQL statement contains data that might be tainted in /data/www/blog/taint/1.php on line 18


var_dump(is_tainted($var)); // bool(false) 
echo "<br/>";
var_dump(is_tainted($output)); // bool(true) 
echo "<br/>";


echo '=======================', '<br/>';

$output    = "Welcome, ".htmlentities($a)." !!!";
echo $output, "<br/>";

$sql       = "Select *  from " . mysqli_escape_string(null, $a);
mysqli_query(null, $sql);echo "<br/>";


echo '-----------------------', '<br/>';

$newOutput = "Welcome !!!";
echo $newOutput, "<br/>";
var_dump(taint($newOutput)); // bool(true) 
echo $newOutput, "<br/>"; // // Warning: main() [echo]: Attempt to echo a string that might be tainted in /data/www/blog/taint/1.php on line 39

$newOutput = "Welcome {$a} !!!";
 echo $newOutput, "<br/>"; // Warning: main() [echo]: Attempt to echo a string that might be tainted in /data/www/blog/taint/1.php on line 42
var_dump(untaint($newOutput)); // bool(true) 
echo $newOutput, "<br/>";