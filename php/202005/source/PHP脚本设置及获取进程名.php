<?php

// Mac OS：Warning: cli_set_process_title(): cli_set_process_title had an error: Not initialized correctly 

cli_set_process_title("test");

sleep(10);

// ps -ef | grep test
// root     32172 31511  0 09:03 pts/0    00:00:00 test

// top -p 32172 -c
//32198 root      20   0  113100  18052  13088 S   0.0   0.2   0:00.00 test                                                      

// Mac OS：Warning: cli_set_process_title(): cli_set_process_title had an error: Not initialized correctly 

echo "Process title: " . cli_get_process_title() . "\n";
// Process title: test

