<?php
namespace Vinted;
use Validator;

class DataCollector {
    
    public function getProviders() : array
    {
        $providers = unserialize(file_get_contents('src/data/providers.txt'));
        $providers = array_map(function($provider) {
            return [
                'id' => $provider['id'],
                'short' => $provider['short']
            ];
        }, $providers);
        return $providers;

    }
    public function getSizes() : array
    {
        $sizes = unserialize(file_get_contents('src/data/sizes.txt'));
        $sizes = array_map(function($size) {
            return [
                'id' => $size['id'],
                'short' => $size['short']
            ];
        }, $sizes);
        return $sizes;

    }
    public function getPriceList() : array
    {
        $providers = $this->getProviders();
        $sizes = $this->getSizes();
        $priceList = unserialize(file_get_contents('src/data/prices.txt'));

        $priceList = array_map(function($price) use ($providers, $sizes){
            $provider_id = array_search($price['provider_id'], array_column($providers, 'id'));
            $size_id = array_search($price['size_id'], array_column($sizes, 'id'));
            return [
                'provider' => $providers[$provider_id]['short'],
                'size' => $sizes[$size_id]['short'],
                'price' => $price['price'],
            ];
        }, $priceList);
        
        return $priceList;

    }
    public function getTransactions() : array
    {
        $inputData = file_get_contents('src/data/input.txt');
        $inputArr = explode("\n", $inputData);
        $inputArr = array_map(function($line){
            return explode(' ', $line);
        }, $inputArr);
        
        return $inputArr;
    }
}