<?php

goto a;
echo "1"; // 不会输出

a:
echo '2'; // 2

for ($i = 0, $j = 50; $i < 100; $i++) {
    while ($j--) {
        if ($j == 17) {
            goto end;
        }

    }
}
echo "i = $i";
end:
echo 'j hit 17';

// $a = 1;
// goto switchgo;
// switch ($a){
//     case 1:
//         echo 'bb';
//     break;
//     case 2:
//         echo 'cc';
//         switchgo:
//             echo 'bb';
//     break;
// }

// goto whilego;
// while($a < 10){
//     $a++;
//     whilego:
//         echo $a;
// }

// b:
//     echo 'b';

// goto b;

