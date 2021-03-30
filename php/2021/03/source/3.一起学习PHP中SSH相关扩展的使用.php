<?php

$conn = ssh2_connect('192.168.56.106');
var_dump(ssh2_auth_password($conn, 'root', '123456')); // bool(true)


// ssh2_exec 执行命令

$stream = ssh2_exec($conn, "ls -l /");

$dio_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$err_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

stream_set_blocking($dio_stream, true);
stream_set_blocking($err_stream, true);

echo stream_get_contents($dio_stream);
echo  stream_get_contents($err_stream);

// total 152
// drwxrwx---    1 root vboxsf 131072 Dec 31  1979 adata_hd330
// lrwxrwxrwx.   1 root root        7 May 10  2019 bin -> usr/bin
// dr-xr-xr-x.   6 root root     4096 Jan 29 01:54 boot
// drwxr-xr-x   20 root root     3080 Mar  4 19:42 dev
// drwxr-xr-x. 103 root root     8192 Mar  4 19:42 etc
// drwxr-xr-x.   3 root root       23 Mar  4 20:33 home
// lrwxrwxrwx.   1 root root        7 May 10  2019 lib -> usr/lib
// lrwxrwxrwx.   1 root root        9 May 10  2019 lib64 -> usr/lib64
// drwxr-xr-x.   3 root root       19 Jan 29 01:40 media
// drwxr-xr-x.   2 root root        6 May 10  2019 mnt
// drwxr-xr-x.   3 root root       39 Jan 29 02:07 opt
// dr-xr-xr-x  118 root root        0 Mar  4 19:42 proc
// dr-xr-x---.  15 root root     4096 Feb 25 04:58 root
// drwxr-xr-x   32 root root      940 Mar  4 19:43 run
// lrwxrwxrwx.   1 root root        8 May 10  2019 sbin -> usr/sbin
// drwxr-xr-x.   2 root root        6 May 10  2019 srv
// dr-xr-xr-x   13 root root        0 Mar  4 19:41 sys
// drwxrwxrwt.   5 root root      118 Mar  4 20:36 tmp
// drwxr-xr-x.  12 root root      144 Mar 16  2020 usr
// drwxr-xr-x.  21 root root     4096 Mar 16  2020 var

fclose($stream);

echo '===============', PHP_EOL;

// ssh2_shell 执行命令
$shell = ssh2_shell($conn, 'xterm');
fwrite($shell, "mkdir /home/shelltest/;".PHP_EOL);
fwrite($shell, "cd /home;".PHP_EOL);
fwrite($shell, "ls -l /home;". PHP_EOL);
sleep(1);

echo stream_get_contents($shell);
// Activate the web console with: systemctl enable --now cockpit.socket

// Last login: Thu Mar  4 20:36:36 2021 from 192.168.56.102
// mkdir /home/shelltest/;
// cd /home;
// ls -l /home;
// [root@localhost ~]# mkdir /home/shelltest/;
// [root@localhost ~]# cd /home;
// [root@localhost home]# ls -l /home;
// total 0
// drwxr-xr-x 2 root root 20 Mar  4 20:36 shelltest

fclose($shell);


// sftp 上传下载

$sftp = ssh2_sftp($conn);
ssh2_sftp_mkdir($sftp, '/tmp/test/');
copy('./1.txt', "ssh2.sftp://{$sftp}/tmp/test/11.txt");

$stream = ssh2_exec($conn, "ls -l /tmp/test/");

$dio_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
$err_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

stream_set_blocking($dio_stream, true);
stream_set_blocking($err_stream, true);

echo stream_get_contents($dio_stream);
echo  stream_get_contents($err_stream);

// total 1
// -rw-r--r-- 1 root root 73 Mar  4 20:37 11.txt

fclose($stream);

echo file_get_contents("ssh2.sftp://{$sftp}/tmp/test/11.txt"); // 123123123123123123123123123123123123123123123123123123123123123123123123


// scp 传输文件

ssh2_scp_send($conn, './1.txt', '/home/shelltest/22.txt'); // /home/shelltest/22.txt

ssh2_scp_recv($conn, '/home/shelltest/22.txt', './222.txt'); // ./222.txt
