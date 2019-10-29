<?php

echo '"1234" == " 1234" is ' . ('1234' == ' 1234'), PHP_EOL;
echo '"1234" == "\n1234" is ' . ('1234' == "\n1234"), PHP_EOL;
echo '"1234" == "1234" is ' . ('1234' == '1234'), PHP_EOL;
echo '"1234" == "1234 " is ' . ('1234' == '1234 '), PHP_EOL;
echo '"1234" == "1234\n" is ' . ('1234' == "1234\n"), PHP_EOL;

echo '"aa" == " aa" is ' . ('aa' == ' aa'), PHP_EOL;
echo '"aa" == "\naa" is ' . ('a' == '\naa'), PHP_EOL;
echo '"aa" == "aa" is ' . ('aa' == 'aa'), PHP_EOL;
echo '"aa" == "aa " is ' . ('aa' == 'aa '), PHP_EOL;
echo '"aa" == "aa\n" is ' . ('aa' == "aa\n"), PHP_EOL;
