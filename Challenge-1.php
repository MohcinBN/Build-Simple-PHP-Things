<?php

declare(strict_types=1);

$text = 'swiss';

$counts = count_chars($text, 1);

$uniqueChar = null;
foreach (str_split($text) as $char) {
    if ($counts[ord($char)] === 1) {
        $uniqueChar = $char;
        break;
    }
}

echo ($uniqueChar ?? 'none') . PHP_EOL;