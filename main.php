<?php
const BASE_DIR = __DIR__;
// require_once __DIR__.'/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';


use Vinted\CourierPriceController;
$courierPriceController = new CourierPriceController;
$courierPriceController->countPricesAndDiscounts();
