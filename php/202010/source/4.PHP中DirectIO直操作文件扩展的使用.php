<?php

$fd = dio_open("./test", O_RDWR | O_CREAT);

echo dio_write($fd, "This is Test.I'm ZyBlog.Show me the money4i"), PHP_EOL;
// 43

print_r(dio_stat($fd));
// Array
// (
//     [device] => 64768
//     [inode] => 652548
//     [mode] => 35432
//     [nlink] => 1
//     [uid] => 0
//     [gid] => 0
//     [device_type] => 0
//     [size] => 43
//     [block_size] => 4096
//     [blocks] => 8
//     [atime] => 1602643459
//     [mtime] => 1602656963
//     [ctime] => 1602656963
// )

dio_close($fd);

$fd = dio_open("./test", O_RDWR | O_CREAT);

echo dio_read($fd), PHP_EOL;
// This is Test.I'm ZyBlog.Show me the money4i

dio_close($fd);

$fd = dio_open("./test", O_RDWR | O_CREAT);

var_dump(dio_truncate ($fd , 20)); 
// bool(true)
echo dio_read($fd), PHP_EOL;
// This is Test.I'm ZyB

dio_seek($fd, 3); 

echo dio_read($fd), PHP_EOL;
// s is Test.I'm ZyB

dio_close($fd);


$fd = dio_open('./test', O_RDWR | O_NOCTTY | O_NONBLOCK);

dio_fcntl($fd, F_SETFL, O_SYNC);

dio_tcsetattr($fd, array(
  'baud' => 9600,
  'bits' => 8,
  'stop'  => 1,
  'parity' => 0
));

while (($data = dio_read($fd, 4))!=false) {
    echo $data, PHP_EOL;
}
// This
//  is
// Test
// .I'm
//  ZyB

dio_close($fd);