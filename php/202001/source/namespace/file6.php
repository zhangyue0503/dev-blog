<?php

namespace FILE6;

function show()
{
    echo strtoupper('aaa'), PHP_EOL; // 调用自己的
    echo \strtoupper('aaa'), PHP_EOL; // 调用全局的
}

function strtoupper($str)
{
    return __NAMESPACE__ . '：' . \strtoupper($str);
}
