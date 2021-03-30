<?php

$input_array = ['firST' => 1, 'SecOnd' => 2];

print_r(array_change_key_case($input_array, CASE_UPPER));
// Array
// (
//     [FIRST] => 1
//     [SECOND] => 2
// )

print_r(array_change_key_case($input_array, CASE_LOWER));
// Array
// (
//     [first] => 1
//     [second] => 2
// )

print_r(array_change_key_case([10 => 1, '11' => 2], CASE_UPPER));
// Array
// (
//     [10] => 1
//     [11] => 2
// )

print_r(array_chunk(['a', 'b', 'c', 'd', 'e'], 2));
// Array
// (
//     [0] => Array
//         (
//             [0] => a
//             [1] => b
//         )

//     [1] => Array
//         (
//             [0] => c
//             [1] => d
//         )

//     [2] => Array
//         (
//             [0] => e
//         )

// )

print_r(array_chunk(['a', 'b', 'c', 'd', 'e'], 2, true));
// Array
// (
//     [0] => Array
//         (
//             [0] => a
//             [1] => b
//         )

//     [1] => Array
//         (
//             [2] => c
//             [3] => d
//         )

//     [2] => Array
//         (
//             [4] => e
//         )

// )

$records = [
    [
        'id' => 1,
        'username' => 'aaa',
        'password' => 'a1',
    ],
    [
        'id' => 2,
        'username' => 'bbb',
        'password' => 'b2',
    ],
    [
        'id' => 3,
        'username' => 'ccc',
        'password' => 'c3',
    ],
];

print_r(array_column($records, 'username'));
// Array
// (
//     [0] => aaa
//     [1] => bbb
//     [2] => ccc
// )

print_r(array_column($records, 'username', 'id'));
// Array
// (
//     [1] => aaa
//     [2] => bbb
//     [3] => ccc
// )

class User
{
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }
}

$users = [
    new User(1, 'aaa', 'a1'),
    new User(2, 'bbb', 'b2'),
    new User(3, 'ccc', 'c3'),
];

print_r(array_column($users, 'password', 'username'));
// Array
// (
//     [aaa] => a1
//     [bbb] => b2
//     [ccc] => c3
// )

print_r(array_combine(['a', 'b', 'c', 'd', 'e'], [1, 2, 3, 4, 5]));
// Array
// (
//     [a] => 1
//     [b] => 2
//     [c] => 3
//     [d] => 4
//     [e] => 5
// )

print_r(array_combine(['a', 'b', 'c', 'd'], [1, 2, 3, 4, 5]));
// Warning: array_combine(): Both parameters should have an equal number of elements in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/03/source/10.PHP中的数组函数学习（一）.php on line 138

print_r(array_combine([[1,2], [3, 4]], [['a', 'b'], ['c', 'd']]));
// Array
// (
//     [Array] => Array
//         (
//             [0] => c
//             [1] => d
//         )

// )

print_r(array_count_values([1,'a', 1, 'b', 1, 'a']));
// Array
// (
//     [1] => 3
//     [a] => 2
//     [b] => 1
// )

print_r(array_count_values([['a', 'b'], ['c', 'd']]));
// Warning: array_count_values(): Can only count STRING and INTEGER values! in /Users/zhangyue/MyDoc/博客文章/dev-blog/php/2021/03/source/10.PHP中的数组函数学习（一）.php on line 160
// Array
// (
// )




$a = array_fill(5, 6, 'banana');
print_r($a);
// Array
// (
//     [5] => banana
//     [6] => banana
//     [7] => banana
//     [8] => banana
//     [9] => banana
//     [10] => banana
// )

$b = array_fill(-2, 4, 'pear');
print_r($b);
// Array
// (
//     [-2] => pear
//     [0] => pear
//     [1] => pear
//     [2] => pear
// )

print_r(array_fill_keys(['foo', 5, 10, 'bar'], 'banana'));
// Array
// (
//     [foo] => banana
//     [5] => banana
//     [10] => banana
//     [bar] => banana
// )

print_r(array_filter([1,2,3,4,5,6,7, 0], function ($var){
    return $var%2==0;
}));
// Array
// (
//     [1] => 2
//     [3] => 4
//     [5] => 6
//     [7] => 0
// )

print_r(array_filter([1,2,3,4,5,6,7, 0]));
// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => 4
//     [4] => 5
//     [5] => 6
//     [6] => 7
// )

print_r(array_filter([['a', 'b'], ['c', 'd'], []], function($var){
    print_r($var);
    return count($var)>0?:false;
}));
// Array
// (
//     [0] => a
//     [1] => b
// )
// Array
// (
//     [0] => c
//     [1] => d
// )
// Array
// (
// )
// Array
// (
//     [0] => Array
//         (
//             [0] => a
//             [1] => b
//         )

//     [1] => Array
//         (
//             [0] => c
//             [1] => d
//         )

// )

print_r(array_flip(["oranges", "apples", "pears"]));
// Array
// (
//     [oranges] => 0
//     [apples] => 1
//     [pears] => 2
// )

print_r(array_flip(["a" => 1, "b" => 1, "c" => 2]));
// Array
// (
//     [1] => b
//     [2] => c
// )


// 差值

print_r(array_diff(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1']));
// Array
// (
//     [3] => x
// )

print_r(array_diff_assoc(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1']));
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_diff_key(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1']));
// Array
// (
//     [4] => x
// )

print_r(array_diff_key(['b'=>2, 'a'=>1, 'c'=>3], ['a'=>2, 'b'=>3, 'cc'=>1]));
// Array
// (
//     [c] => 3
// )

print_r(array_diff_uassoc(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// 0===1
// 1===2
// 2===3
// 3===4
// 0===1
// 1===2
// 0===1
// 1===2
// 2===3
// 0===0
// 0===0
// 1===0
// 1===1
// 1===0
// 1===1
// 2===0
// 2===1
// 2===2
// 2===0
// 2===1
// 2===2
// 3===0
// 3===1
// 3===2
// 3===0
// 3===1
// 3===2
// 3===3
// 4===0
// 4===1
// 4===2
// 4===0
// 4===1
// 4===2
// 4===3
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_diff_ukey(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// 0===1
// 1===2
// 2===3
// 3===4
// 0===1
// 1===2
// 0===1
// 1===2
// 2===3
// 0===0
// 1===0
// 1===1
// 2===0
// 2===1
// 2===2
// 3===0
// 3===1
// 3===2
// 3===0
// 3===1
// 3===2
// 3===3
// 4===0
// 4===1
// 4===2
// 4===0
// 4===1
// 4===2
// 4===3
// Array
// (
//     [4] => x
// )


print_r(array_udiff(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// a===1
// 1===b
// a===b
// 1===c
// b===c
// 1===x
// c===x
// b===c
// c===d
// a===c
// c===e
// e===1
// c===1
// a===1
// a===b
// a===1
// a===a
// a===b
// b===b
// b===c
// c===c
// c===x
// x===d
// x===c
// x===e
// x===1
// Array
// (
//     [1] => 1
//     [4] => x
// )

print_r(array_udiff(['a', 1], ['a','1'], function($a, $b){
    var_dump($a);
    var_dump($b);
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// string(1) "a"
// int(1)
// a===1
// string(1) "a"
// string(1) "1"
// a===1
// string(1) "a"
// string(1) "1"
// a===1
// string(1) "a"
// string(1) "a"
// a===a
// string(1) "a"
// int(1)
// a===1
// Array
// (
//     [1] => 1
// )

print_r(array_udiff(['a', '1'], ['a','1'], function($a, $b){
    var_dump($a);
    var_dump($b);
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// string(1) "a"
// string(1) "1"
// a===1
// string(1) "a"
// string(1) "1"
// a===1
// string(1) "1"
// string(1) "1"
// 1===1
// string(1) "1"
// string(1) "a"
// 1===a
// string(1) "a"
// string(1) "a"
// a===a
// Array
// (
// )


print_r(array_udiff_assoc(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// a===b
// a===a
// 1===c
// 1===c
// b===d
// b===e
// c===1
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_diff_uassoc(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// a===b
// a===a
// 1===c
// 1===c
// b===d
// b===e
// c===1
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )

print_r(array_udiff_uassoc(['a', 1, 'b', 'c', 'x'],['b', 'c', 'd'], ['a', 'c', 'e', '1'], function($a, $b){
    echo 'value_compare_func: ', $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}, function($a, $b){
    echo 'key_compare_func: ', $a, '===', $b, PHP_EOL;
    return $a <=> $b;
}));
// key_compare_func: 0===1
// key_compare_func: 1===2
// key_compare_func: 2===3
// key_compare_func: 3===4
// key_compare_func: 0===1
// key_compare_func: 1===2
// key_compare_func: 0===1
// key_compare_func: 1===2
// key_compare_func: 2===3
// key_compare_func: 0===0
// value_compare_func: a===b
// key_compare_func: 0===0
// value_compare_func: a===a
// key_compare_func: 1===0
// key_compare_func: 1===1
// value_compare_func: 1===c
// key_compare_func: 1===0
// key_compare_func: 1===1
// value_compare_func: 1===c
// key_compare_func: 2===0
// key_compare_func: 2===1
// key_compare_func: 2===2
// value_compare_func: b===d
// key_compare_func: 2===0
// key_compare_func: 2===1
// key_compare_func: 2===2
// value_compare_func: b===e
// key_compare_func: 3===0
// key_compare_func: 3===1
// key_compare_func: 3===2
// key_compare_func: 3===0
// key_compare_func: 3===1
// key_compare_func: 3===2
// key_compare_func: 3===3
// value_compare_func: c===1
// key_compare_func: 4===0
// key_compare_func: 4===1
// key_compare_func: 4===2
// key_compare_func: 4===0
// key_compare_func: 4===1
// key_compare_func: 4===2
// key_compare_func: 4===3
// Array
// (
//     [1] => 1
//     [2] => b
//     [3] => c
//     [4] => x
// )


