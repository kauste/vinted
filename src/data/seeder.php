<?php
$providers = [
    ['id' => 1, 'title' => 'La Poste', 'short' => 'LP'],
    ['id' => 2, 'title' => 'Mondial Relay', 'short' => 'MR'],
];
$sizes = [
    ['id' => 1, 'title' => 'small', 'short' => 'S'],
    ['id' => 2, 'title' => 'medium', 'short' => 'M'],
    ['id' => 3, 'title' => 'lardge', 'short' => 'L'],
];
$prices = [
    ['provider_id' => 1, 'size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
    ['provider_id' => 1, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
    ['provider_id' => 1, 'size_id' => 3, 'price' => 6.90, 'currency' => 'euro'],
    ['provider_id' => 2, 'size_id' => 1, 'price' => 2.00, 'currency' => 'euro'],
    ['provider_id' => 2, 'size_id' => 2, 'price' => 3.00, 'currency' => 'euro'],
    ['provider_id' => 2, 'size_id' => 3, 'price' => 4.00, 'currency' => 'euro'],
];
file_put_contents(__DIR__. '/providers.txt', serialize($providers));
file_put_contents(__DIR__. '/sizes.txt', serialize($sizes));
file_put_contents(__DIR__. '/prices.txt', serialize($prices));

