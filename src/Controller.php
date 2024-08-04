<?php
namespace Vinted;
use Vinted\Validator;
use Vinted\DataCollector;

class Controller {

    private $currMonth;
    private $discount = 10;
    private $s_SizePriceList;
    private $l_SizePriceList;
    private $s_SizeMinPrice;
    private $l_SizePuchaceCount = 0;
    private $l_SizeDiscountUsed = False;

    private function smallPrices($priceList) : void
    {
        $s_SizePriceList = array_filter($priceList, function($price){
                        return $price['size'] === 'S' && is_float($price['price']);
                    });
        $this->s_SizePriceList = array_combine(array_column($s_SizePriceList, 'provider'), 
                                              array_column($s_SizePriceList, 'price')
                                             );
        
        $s_SizePriceList = array_values($this->s_SizePriceList);
        sort($s_SizePriceList);
        $this->s_SizeMinPrice = $s_SizePriceList[0];
        
    }
    private function lardgePrices($priceList) : void
    {
        $l_SizePriceList = array_filter($priceList, function($price){
                        return $price['size'] === 'L' && is_float($price['price']);
                    });
        $this->l_SizePriceList = array_combine(array_column($l_SizePriceList, 'provider'), 
                                              array_column($l_SizePriceList, 'price')
                                             );
        
        
    }
    private function smallPriceCount($provider)
    {
        $shippingPrice = $this->s_SizePriceList[$provider];
        $maxDiscount = $shippingPrice - $this->s_SizeMinPrice;

        if($this->discount 
        && $maxDiscount === 0){
            return [$shippingPrice, '-'];
        }

        if($this->discount - $maxDiscount <= 0){
            $purchaseInfo = [$shippingPrice - $this->discount, $this->discount];
            $this->discount = 0;
            return $purchaseInfo;
        }

        $this->discount -= $maxDiscount;
        return [$this->s_SizeMinPrice, $maxDiscount];
    }
    private function lardgePriceCount($purchace)
    {
        $l_SizePuchaceCount++;
        $shippingPrice = $this->l_SizePuchaceCount[$purchace['provider']];
        if($purchace['provider'] !== 'LP' 
        || $l_SizePuchaceCount % 3 !== 0 
        ||  $l_SizeDiscountUsed 
        || $this->discount === 0){
            return [$shippingPrice, '-'];
        }
        if($shippingPrice > $this->discount){
            return [$shippingPrice - $this->discount, $this->discount];
        }
        return ['-', $shippingPrice];
    }
    private function monthWatch($date)
    {
        $month = date('m', strtotime($date));
        if($this->currMonth !== $month){
            $this->l_SizeDiscountUsed = False;
            $this->discount = 10;
        }
    }
    public function countPrices()
    {
        $dataCollector = new DataCollector;
        $transactions = $dataCollector->getTransactions();
        $priceList = $dataCollector->getPriceList();
        $this->smallPrices($priceList);
        $this->lardgePrices($priceList);
        $counted = array_map(function($purchace) use ($priceList){
            $this->monthWatch($purchace[0]);
            $addedData = match(true){
                            !Validator::isValidData($purchace, 2, $priceList) => ['Ignored'],
                            $purchace[1] === 'S' => $this->smallPriceCount($purchace[2]),
                            $purchace[1] === 'L' => $this->lardgePriceCount($purchace),

                        };
            return [...$purchace, ...$addedData];


        },$transactions);
        // print_r($counted);
    }


}