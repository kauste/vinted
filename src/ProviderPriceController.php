<?php
namespace Vinted;
use Vinted\Validator;
use Vinted\Output;
use Vinted\ProviderDataService;

class ProviderPriceController {

    private $currMonth;
    private $discount = 10.00;
    private $l_SizePuchaceCount = 0;
    private $l_SizeDiscountUsed = False;
    private $providerDataService;

    function __construct(Type $var = null) {
        $this->providerDataService = new ProviderDataService;
    }
    private function countSmallSizePrice($provider) : array
    {
        $shippingPrice = $this->providerDataService->s_priceList[$provider];
        $maxDiscount = $shippingPrice - $this->providerDataService->s_SizeMinPrice;
        if(!$this->discount || !$maxDiscount){
            $priceAndDiscount = [$shippingPrice, '-'];
        }
        elseif($this->discount - $maxDiscount <= 0){
            $purchaseInfo = [$shippingPrice - $this->discount, $this->discount];
            $this->discount = 0;
            $priceAndDiscount = $purchaseInfo;
        }
        else {
            $priceAndDiscount = [$this->providerDataService->s_SizeMinPrice, $maxDiscount];
        }
        $this->discount -= $maxDiscount;
        return $priceAndDiscount;
    }
    private function countLardgeSizePrice($purchase) : array
    {
        if($purchase[2] === 'LP'){
            $this->l_SizePuchaceCount++;
        }
        $shippingPrice = $this->providerDataService->l_priceList[$purchase[2]];
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
    private function monthWatch($date) :void
    {
        $month = date('m', strtotime($date));
        if($this->currMonth !== $month){
            $this->l_SizeDiscountUsed = False;
            $this->discount = 10;
        }
    }
    public function countPricesAndDiscounts() : void
    {
        $transactions = $this->providerDataService->getTransactions();

        $sizes = array_unique(array_column($this->providerDataService->priceList, 'size'));
        $providers = array_unique(array_column($this->providerDataService->priceList, 'provider'));

        $counted = array_map(function($purchase) use ($sizes, $providers){
            $this->monthWatch($purchase[0]);
            $addedData = match(true){
                            !Validator::isValidData($purchase, 2, $sizes, $providers) => ['Ignored'],
                            $purchase[1] === 'S' => $this->countSmallSizePrice($purchase[2]),
                            $purchase[1] === 'M' => [$this->providerDataService->m_priceList[$purchase[2]], '-'],
                            $purchase[1] === 'L' => $this->countLardgeSizePrice($purchase),
                            default => ['Ignored'],

                        };
            return [...$purchase, ...$addedData];
        },$transactions);
        $output = new Output;
        $output->printStr($counted);
    }

}