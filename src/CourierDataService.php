<?php
namespace Vinted;
use Vinted\DataCollector;
use Vinted\Functions;


class CourierDataService{

    private $dataCollector;
    public $priceList;
    public $s_priceList;
    public $m_priceList;
    public $l_priceList;
    public $s_SizeMinPrice;

    public function __construct() 
    {
        $this->dataCollector = new DataCollector;
        $this->priceList = $this->getPriceList();
        $this->s_priceList = $this->getSizePriceList('S');
        $this->m_priceList = $this->getSizePriceList('M');
        $this->l_priceList = $this->getSizePriceList('L');
        $this->s_SizeMinPrice = Functions::minValue($this->s_priceList);
    }
    public function getPriceList() : array
    {
        $couriers = $this->dataCollector->getSerializedData('couriers');
        $sizes = $this->dataCollector->getSerializedData('sizes');
        $priceList = $this->dataCollector->getSerializedData('prices');

        $priceList = $this->dataCollector->connectData( [$priceList, ['price as price']],
                            [
                                [$couriers, ['short as courier'], 'courier_id', 'id'],
                                [$sizes, ['short as size'], 'size_id', 'id']
                            ]);
        return $priceList;
    }
    public function getSizePriceList($size) : array
    {
        $sizePriceList = array_filter($this->priceList, fn($item) => $item['size'] === $size && is_float($item['price']));
        $sizePriceList = array_combine(array_column($sizePriceList, 'courier'), array_column($sizePriceList, 'price'));
        return $sizePriceList;
    }
    public function getTransactions() : array
    {
        $inputData = $this->dataCollector->getData('input');
        $inputArr = Functions::strToNestedArr($inputData, "\n", " ");
        return $inputArr;
        
    }
}