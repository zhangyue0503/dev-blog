<?php

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
ob_end_clean();

echo "1=============", PHP_EOL;

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
$v = ob_get_contents();
ob_end_clean();

echo $v;
echo "2=============", PHP_EOL;

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
flush();
ob_flush();
echo "3=============", PHP_EOL;

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;
$v = ob_get_contents();
ob_get_flush();
echo "4=============", PHP_EOL;

echo $v;
echo "5=============", PHP_EOL;
ob_get_clean();



ob_start();
ob_start();

echo 123, PHP_EOL;

echo ob_get_length(), PHP_EOL;
echo "6=============", PHP_EOL;
// 3

echo ob_get_level(), PHP_EOL;
// 2

echo "7=============", PHP_EOL;

print_r(ob_get_status(true));
echo "8=============", PHP_EOL;

// Array
// (
//     [0] => Array
//         (
//             [name] => default output handler
//             [type] => 0
//             [flags] => 112
//             [level] => 0
//             [chunk_size] => 0
//             [buffer_size] => 16384
//             [buffer_used] => 0
//         )

//     [1] => Array
//         (
//             [name] => default output handler
//             [type] => 0
//             [flags] => 112
//             [level] => 1
//             [chunk_size] => 0
//             [buffer_size] => 16384
//             [buffer_used] => 17
//         )

// )

ob_get_flush();




ob_start(function($text){
    return (str_replace("apples", "oranges", $text));
});

echo "It's like comparing apples to oranges", PHP_EOL;
ob_get_flush();
echo "9=============", PHP_EOL;

// It's like comparing oranges to oranges


ob_implicit_flush();

ob_start();
echo 111, PHP_EOL;
echo "aaaa", PHP_EOL;

echo "10=============", PHP_EOL;

output_add_rewrite_var('var', 'value');
// some links
echo '<a href="file.php">link</a>
<a href="http://example.com">link2</a>';

// <a href="file.php?var=value">link</a>
// <a href="http://example.com">link2</a>

// a form
echo '<form action="script.php" method="post">
<input type="text" name="var2" />
</form>';

// <form action="script.php" method="post">
// <input type="hidden" name="var" value="value" />
// <input type="text" name="var2" />
// </form>

// https://www.php.net/manual/zh/function.ob-end-flush.php#109837