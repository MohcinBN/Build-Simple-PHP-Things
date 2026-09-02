<?php 

$a = 5;

function increment(&$value)
{
    $value++;
}

increment($a);

printf("%d", $a);

