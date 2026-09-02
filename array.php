<?php

$words = [
    'php',
    'laravel',
    'php',
    'mysql',
    'laravel',
    'php',
];

$results = [];
foreach ($words as $word) {
    if (!isset($results[$word])) {
        $results[$word] = 0;
    }
    $results[$word]++;
}

print_r($results);

