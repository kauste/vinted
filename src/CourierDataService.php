<?php
namespace Vinted;
use Vinted\DataCollector;
use Vinted\Functions;


class CourierDataService{

    private $dataCollector;
    private $pricesFileName;
    private $courierFileName;
    private $sizesFileName;
    private $transactionsFileName;
    public $priceList;
    public $s_priceList;
    public $m_priceList;
    public $l_priceList;
    public $s_SizeMinPrice;
    public $transactions;

    public function __construct(string $pricesFileName, string $courierFileName, string $sizesFileName, string $transactionsFileName) 
    {
        $this->dataCollector = new DataCollector;
        $this->pricesFileName = $pricesFileName;
        $this->courierFileName = $courierFileName;
        $this->sizesFileName = $sizesFileName;
        $this->priceList = $this->getPriceList();
        $this->s_priceList = $this->getSizePriceList('S');
        $this->m_priceList = $this->getSizePriceList('M');
        $this->l_priceList = $this->getSizePriceList('L');
        $this->transactions = $this->getTransactions($transactionsFileName);
        $this->s_SizeMinPrice = Functions::minValue($this->s_priceList);
    }
    private function getPriceList() : array
    {
        $priceList = $this->dataCollector->getSerializedData($this->pricesFileName);
        $couriers = $this->dataCollector->getSerializedData($this->courierFileName);
        $sizes = $this->dataCollector->getSerializedData($this->sizesFileName);
        if($couriers && $sizes && $priceList){
            $priceList = $this->dataCollector->leftJoin( [$priceList, ['price as price']],
                                [
                                    [$couriers, ['short as courier'], 'courier_id', 'id'],
                                    [$sizes, ['short as size'], 'size_id', 'id']
                                ]);
            $priceList = array_filter( $priceList, fn($line) => $line['price'] && is_float($line['price']) && $line['price'] >= 0 && $line['price'] && $line['size'] &&  $line['courier']);
            return $priceList;
        }
        return [];
    }
    private function getSizePriceList(string $size) : array
    {
        $sizePriceList = array_filter($this->priceList, fn($item) => $item['size'] === $size && is_float($item['price']));
        $sizePriceList = array_combine(array_column($sizePriceList, 'courier'), array_column($sizePriceList, 'price'));
        return $sizePriceList;
    }
    public function getTransactions($transactionsFileName) : array
    {
        $inputData = $this->dataCollector->getData($transactionsFileName);
        if($inputData){
            $inputArr = Functions::strToNestedArr($inputData, "\n", " ");
            return $inputArr;
        }
        return [];
        
    }
}