<?php
namespace Vinted;

class Validator {

    public static function isDate($value) :bool
    {
        $pattern = '/\d{4}-\d{2}-\d{2}/';
        return preg_match($pattern, $value) === 1;
    }
    public static function isAllSet($purchase, $lastIndex)
    {
        foreach(range(0, $lastIndex) as $index){
            if(!isset($purchase[$index])) return false;
        }
        return true;
    }
    public static function isValidData($purchase, $lastIndex, $sizes, $couriers) : bool
    {

        return self::isAllSet($purchase, $lastIndex)
               && self::isDate($purchase[0])  
               && in_array($purchase[1], $sizes) 
               && in_array($purchase[2], $couriers)
               ;

    }
}