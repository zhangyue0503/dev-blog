<?php

$key = hash('sha256', 'secret key', true);
$input = json_encode(['id'=>1, 'data'=>'Test mcrypt!']);

$td = @mcrypt_module_open('rijndael-128', '', 'cbc', '');
$iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
@mcrypt_generic_init($td, $key, $iv);
$encrypted_data = @mcrypt_generic($td, $input);
@mcrypt_generic_deinit($td);
@mcrypt_module_close($td);

echo $encrypted_data, PHP_EOL;
// ��I      $�3���gE�ǣu(�9n�����
//                            p�>P

$td = @mcrypt_module_open('rijndael-128', '', 'cbc', '');

@mcrypt_generic_init($td, $key, $iv);
$data = @mdecrypt_generic($td, $encrypted_data);
echo $data, PHP_EOL;
// {"id":1,"data":"Test mcrypt!"}

@mcrypt_generic_deinit($td);
@mcrypt_module_close($td);

$string = 'Test MCrypt2';
$algorithm = 'rijndael-128';
$key = md5( "mypassword", true);
$iv_length = @mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
$iv = @mcrypt_create_iv( $iv_length, MCRYPT_RAND );

$encrypted = @mcrypt_encrypt( $algorithm, $key, $string, MCRYPT_MODE_CBC, $iv );
$result = @mcrypt_decrypt( $algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv );

echo $encrypted, PHP_EOL; // \<�`�U��Uf)�Y
echo $result, PHP_EOL; // Test MCrypt2

$algorithms = @mcrypt_list_algorithms();
print_r($algorithms);
// Array
// (
//     [0] => cast-128
//     [1] => gost
//     [2] => rijndael-128
//     [3] => twofish
//     [4] => arcfour
//     [5] => cast-256
//     [6] => loki97
//     [7] => rijndael-192
//     [8] => saferplus
//     [9] => wake
//     [10] => blowfish-compat
//     [11] => des
//     [12] => rijndael-256
//     [13] => serpent
//     [14] => xtea
//     [15] => blowfish
//     [16] => enigma
//     [17] => rc2
//     [18] => tripledes
// )

$modes = @mcrypt_list_modes();
print_r($modes);
// Array
// (
//     [0] => cbc
//     [1] => cfb
//     [2] => ctr
//     [3] => ecb
//     [4] => ncfb
//     [5] => nofb
//     [6] => ofb
//     [7] => stream
// )