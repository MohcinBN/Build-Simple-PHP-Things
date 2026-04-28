<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

// collection is a object wrapper for arrays that provides a way to manipulate data, like map, filer.. 
class StringCollection {
    private array $strings = [];
    
    public function add(string $string): void {
        $this->strings[] = $string;
    }
    
    public function all(): array {
        return $this->strings;
    }

    public function filter(callable $callback): array {
        // here we used closure concept
        return array_filter($this->strings, $callback);
    }

    public function first(): ?string {
        return $this->strings[0] ?? null;
    }

    public function map(callable $callback): array {
        // here we used closure concept
        return array_map($callback, $this->strings);
    }
}

$collection = new StringCollection();
$collection->add("String 11");
$collection->add("String 22");
$collection->add("Short");

echo "<pre>";
print_r($collection->all());
echo "</pre>";

echo "<pre>";
print_r($collection->filter(function($string) {
    return strlen($string) < 6;
}));
echo "</pre>";

echo "<pre>";
print_r($collection->first());
echo "</pre>";

echo "<pre>";
print_r($collection->map(function($string) {
    return strrev($string);
}));
echo "</pre>";






