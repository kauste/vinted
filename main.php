<?php
const BASE_DIR = __DIR__;
require_once __DIR__.'/autoload.php';

use Vinted\ProviderPriceController;
$ProviderPriceController = new ProviderPriceController;
$ProviderPriceController->countPricesAndDiscounts();
