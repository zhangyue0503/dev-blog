<?php

// session_name('session_id');

// session_module_name('redis');
// session_save_path('tcp://127.0.0.1:6379');

session_start();

$_SESSION['user'] = ['id' => 1, 'name' => 'test_user'];

// 修改 php.ini
// use_tran_id = 1
// use_cookie = 0
// use_only_cookie = 0
// echo SID;



echo session_name(), "=", session_id(), "<br/>"; // PHPSESSID=i3tdf5bmmdq8eduh56ja7s87ka
// session_id=plt0dnc18t6l6uu30dp4s78hhg

$_SESSION['A'] = 'Baz';

$a = $_SESSION['A'];



// session_destroy();
// print_r($_SESSION);
// echo $a, "<br/>";

// session_unset();
// print_r($_SESSION);
// echo $a, "<br/>";

session_regenerate_id(true);

echo session_name(), "=", session_id(), "<br/>"; // PHPSESSID=i3tdf5bmmdq8eduh56ja7s87ka


?>
<a href="41.php?r=<?php echo rand(); ?>">Cookie传输</a>
<a href="41.php?<?php htmlspecialchars(SID); ?>">URL传输</a>
