<?php
namespace Vinted;

class Validator {
    public static function fileExists($path, $fileName) : bool
    {
        if(!file_exists($path . $fileName)){
            echo "\n\033[31m*** ERROR! File \"" .$fileName . "\" does not exist in directory \"". $path ."\" ***\033[0m\n";
            return false;
        }
        return true;
    }
    public static function isSerialized($data): bool
    {

        if(!is_string($data) || (!@unserialize($data) && $data === 'b:0;')){
            echo "\n\033[31m*** ERROR! File is not in PHP serialization format ***\033[0m\n";
            return false;
        }
        return true;
    }
    public static function isValidDate(string $date) :bool
    {
        $registerdDate = '2012-04-23';
        $currDate = date('Y-m-d');
        [$year, $month, $day] = explode('-', $date) + [null, null, null];
        
        return intval($year) 
               && intval($month) 
               && intval($day) 
               && checkdate($month,$day, $year)
               && $date <= $currDate
               && $registerdDate <= $date;
    }
    public static function isNotEmptyArray(array $array, string $arrayName) : bool
    {
        if(!$array){
            echo "\n\033[31m*** ERROR! " . $arrayName . " shold be not empty array ***\033[0m\n";
            return false;
        }
        return true;
    }
    public static function isNumeric(float $number, string $numberName) : bool
    {

        if(!is_numeric($number)){
            echo "\n\033[31m*** ERROR! Minimal ". $numberName ." should be number ***\033[0m\n";
            return false;
        }
        return true;
    }
    public static function isGreaterThanZero(float $number, string $numberName) : bool
    {
        if( $number < 0){
            echo "\n\033[31m*** ERROR! Minimal ".$numberName." should greater than or equal to 0.00 ***\033[0m\n";
            return false;
        }
        return true;

    }
    public static function isAllSet(array $purchase, int $lastIndex) : bool
    {
        foreach(range(0, $lastIndex) as $index){
            if(!isset($purchase[$index])) return false;
        }
        return true;
    }
    public static function isValidData(array $purchase, int $lastIndex, array $sizes, array $couriers) : bool
    {
        return self::isAllSet($purchase, $lastIndex)
               && self::isValidDate($purchase[0])  
               && in_array($purchase[1], $sizes) 
               && in_array($purchase[2], $couriers)
               ;

    }
}