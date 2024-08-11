<?php
namespace Vinted;
use Vinted\Validator;
use Vinted\Output;
use Vinted\CourierDataService;

class CourierPriceController {
  
    private $currMonth;
    private $discount = 10.00;
    private $l_SizePuchaceCount = 0;
    private $l_SizeDiscountUsed = False;
    private $courierDataService;
    private $output;


    function __construct(string $pricesFileName, string $courierFileName, string $sizesFileName, string $transactionsFileName) {
        $this->courierDataService = new CourierDataService($pricesFileName, $courierFileName, $sizesFileName, $transactionsFileName);
        $this->output = new Output;

    }
    private function countSmallSizePrice(string $courier) : array
    {
        if(!isset($this->courierDataService->s_priceList[$courier])
        || $this->courierDataService->s_SizeMinPrice < 0.0 ){
            return ['Ignored'];
        }
        $shippingPrice = $this->courierDataService->s_priceList[$courier] ;
        $maxDiscount = $shippingPrice - $this->courierDataService->s_SizeMinPrice;
        if(!$this->discount || !$maxDiscount){
            $priceAndDiscount = [$shippingPrice, '-'];
        }
        elseif($this->discount - $maxDiscount <= 0){
            $purchaseInfo = [$shippingPrice - $this->discount, $this->discount];
            $this->discount = 0;
            $priceAndDiscount = $purchaseInfo;
        }
        else {
            $priceAndDiscount = [$this->courierDataService->s_SizeMinPrice, $maxDiscount];
            $this->discount -= $maxDiscount;
        }
        return $priceAndDiscount;
    }
    private function countLardgeSizePrice(array $purchase) : array
    {
        if($purchase[2] === 'LP'){
            $this->l_SizePuchaceCount++;
        }
        $shippingPrice = $this->courierDataService->l_priceList[$purchase[2]];
        if($purchase[2] !== 'LP' 
        || $this->l_SizePuchaceCount % 3 !== 0 
        || $this->l_SizeDiscountUsed 
        || $this->discount === 0.00){
            $priceAndDiscount = [$shippingPrice, '-'];
        }
        elseif($shippingPrice > $this->discount){
            $priceAndDiscount = [$shippingPrice - $this->discount, $this->discount];
            $this->discount = 0;
        }
        else{
            $priceAndDiscount = [0.00, $shippingPrice];
            $l_SizeDiscountUsed = True;
            $this->discount -= $shippingPrice;
        }
        return $priceAndDiscount;
    }
    private function monthWatch(string $date) :void
    {
        $month = date('m', strtotime($date));
        if($this->currMonth !== $month){
            $this->l_SizeDiscountUsed = False;
            $this->discount = 10;
        }
    }
    public function countPricesAndDiscounts() : void
    {
        $sizes = array_unique(array_column($this->courierDataService->priceList, 'size'));
        $couriers = array_unique(array_column($this->courierDataService->priceList, 'courier'));
        if($this->courierDataService->transactions && $sizes && $couriers){
            $counted = array_map(function($purchase) use ($sizes, $couriers){
                $this->monthWatch($purchase[0]);
                $addedData = match(true){
                                !Validator::isValidData($purchase, 2, $sizes, $couriers) => ['Ignored'],
                                $purchase[1] === 'S' => $this->countSmallSizePrice($purchase[2]),
                                $purchase[1] === 'M' => [$this->courierDataService->m_priceList[$purchase[2]], '-'],
                                $purchase[1] === 'L' => $this->countLardgeSizePrice($purchase),
                                default => ['Ignored'],

                            };
                return [...$purchase, ...$addedData];
            },$this->courierDataService->transactions );
            $rez = $this->output->getOutputStr($counted);
            echo $rez;
        }

    }

}