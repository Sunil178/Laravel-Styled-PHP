<?php

$data = array(
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => 30,
    'gender' => 'female',
);

$time = microtime();
$values = implode(',', str_split(str_repeat('?', count($data))));
echo (microtime() - $time);

// echo $values;

echo "\n";
$time = microtime();
$values = implode(',', array_map(function () {return '?';}, $data));
echo (microtime() - $time);
// echo $values;
echo "\n";