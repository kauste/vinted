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
$testPrices = [
    ['courier_id' => 1, 'size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
    ['courier_id' => 1, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
    ['courier_id' => 1, 'size_id' => 3, 'price' => 6.90, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 1, 'price' => 2.00, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 2, 'price' => 3.00, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => 3, 'price' => 4.00, 'currency' => 'euro'],
    ['courier_id' => 10, 'price' => 1.50, 'currency' => 'euro'],

    ['courier_id' => 'aaa', 'size_id' => 'bbb', 'price' => 4.90, 'currency' => 'euro'],
    ['courier_id' => [], 'size_id' => [], 'price' => 6.90, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => -1000, 'price' => 2.00, 'currency' => 'euro'],
    ['courier_id' => 4, 'size_id' => 6, 'price' => 3.00, 'currency' => 'euro'],
    ['courier_id' => 4, 'size_id' => 5, 'price' => 4.00, 'currency' => 'euro'],
    ['size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
    ['courier_id' => null, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
    ['courier_id' => [], 'price' => -1000, 'currency' => 'euro'],
    ['courier_id' => 2, 'size_id' => null, 'price' => 2.00, 'currency' => '[]]'],
    ['courier_id' => null, 'size_id' => null, 'price' => 'hiohohi', 'currency' => 'euro'],
    ['courier_id' => 1000, 'size_id' => 3, 'price' => 'jabas', 'currency' => 'euro'],
];
$testCouriers =[
    ['id' => 1, 'title' => 'La Poste', 'short' => 'LP', 'b'],
    ['id' => 2, 'title' => 'Mondial Relay', 'short' => 'MR', null],
    ['id' => 3, 'title' => 2, 'short' => 5],
    ['id' => 4, 'title' => 'Mondial Relay', 'short' => []],
    ['id' => 'aaa', 'title' => 'La Poste', 'short' => 'LP', []],
    ['id' => [], 'title' => '', 'short' => '', '', '%%%%%'],
    [ 'title' => 'La Poste', 'short' => 'fff'],
    ['id' => -2, 'title' => 'Mondial Relay', 'short' => -10.5],

];
$testSizes =  [
    ['id' => 1, 'title' => 'small', 'short' => 'S'],
    ['id' => 2, 'title' => 'medium', 'short' => 'M'],
    ['id' => 3, 'title' => 'lardge', 'short' => 'L'],
    ['id' => 4, 'title' => 'small', 'short' => []],
    ['id' => 5, 'title' => ''],
    ['id' => 6, 'title' => 'aaa', 'short' => 5],
    [ 'title' => 'small', 'short' => 'S'],
    ['id' => 'bbb', 'title' => 'medium', 'short' => 'M'],
    ['id' => [], 'title' => 'lardge', 'short' => 'L'],
];

$testText = "jsvkjvsdnk\n2005-08-01 S MR\n2015-08-09 Mr MR\n2015-08-12 s mr\n2015-08-09 M MR\n2025-08-09 L MR\n2016-08-09 Mr MR\n2025-08-09MrMR\n\n\n\n     2016-08-19 S LP";

file_put_contents(__DIR__. '/couriers.txt', serialize($couriers));
file_put_contents(__DIR__. '/sizes.txt', serialize($sizes));
file_put_contents(__DIR__. '/prices.txt', serialize($prices));
file_put_contents(__DIR__. '/test-prices.txt', serialize($testPrices));
file_put_contents(__DIR__. '/test-couriers.txt', serialize($testCouriers));
file_put_contents(__DIR__. '/test-sizes.txt', serialize($testSizes));

file_put_contents(__DIR__. '/test-text.txt', $testText);



