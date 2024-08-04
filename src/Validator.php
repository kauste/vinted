<?php
namespace Vinted;
use Vinted\DataCollector;

class Validator {

    public static function isDate($value) :bool
    {
        $pattern = '/\d{4}-\d{2}-\d{2}/';
        return preg_match($pattern, $value) === 1;
    }
    public static function isAllSet($purchce, $lastIndex)
    {
        foreach(range(0, $lastIndex) as $index){
            if(!isset($purchce[$index])) return false;
        }
        return true;
    }
    public static function isValidData($purchce, $lastIndex, $priceList) : bool
    {
        // echo 'ce';

        // print_r(array_column($priceList, 'provider'));

        // echo 'ce';

        return self::isAllSet($purchce, $lastIndex)
               && self::isDate($purchce[0])  
               && in_array($purchce[1], array_column($priceList, 'size')) 
               && in_array($purchce[2], array_column($priceList, 'provider'))
               ;

    }
}