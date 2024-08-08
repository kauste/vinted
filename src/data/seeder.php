<?php

$couriers = [
    ['id' => 1, 'title' => 'La Poste', 'short' => 'LP'],
    ['id' => 2, 'title' => 'Mondial Relay', 'short' => 'MR'],
];
$sizes = [
    ['id' => 1, 'title' => 'small', 'short' => 'S'],
    ['id' => 2, 'title' => 'medium', 'short' => 'M'],
    ['id' => 3, 'title' => 'lardge', 'short' => 'L'],
];
$prices = [
    ['courier_id' => 1, 'size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
    ['courier_id' => 1, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
    ['courier_id' => 1, 'size_id' => 3, 'price' => 6.90, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 1, 'price' => 2.00, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 2, 'price' => 3.00, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 3, 'price' => 4.00, 'currency' => 'euro'],
];
$testSerialized = [
    ['id' => 1, 'surname' => 'Brown', 2 => 2, 'a' => [], 'school_id' => 1, 'group_id' => 1],
    ['name' => 'Ieva', 'surname' => 'Kučinskaitė', 7 => null, 'school_id' => 1,],
    ['id' => 3, 'name' => 'Bradd', 'surname' => 'Pitt', 'cccc', 'school_id' => 2, 'group_id' => 1],
    ['name' => 'Agnė', 'surname' => 'Kiškytė', 'school_id' => 1,'school_id' => 2, 'group_id' => 2],
    ['ksdvnl', 'white' => '#fff', '%%%%%', '58758p50' => json_encode([1,1,1,1,1])],
    ['id'=> 6, 'name' => [], 'surname' => 2],

];
$testText = "2020-01-01 John Brown\n 2000-07-02 Ann Pitt\n 1999-02-02 Bradd Brown\n 1984 000 AAA\n AAA BBB 2024-01-01 Ieva Kučinskaitė";

file_put_contents(__DIR__. '/couriers.txt', serialize($couriers));
file_put_contents(__DIR__. '/sizes.txt', serialize($sizes));
file_put_contents(__DIR__. '/prices.txt', serialize($prices));
file_put_contents(__DIR__. '/test-serialized.txt', serialize($testSerialized));
file_put_contents(__DIR__. '/test-text.txt', $testText);



