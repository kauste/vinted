<?php
namespace Vinted;

class Validator {

    public static function isValidDate($date) :bool
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
               && self::isValidDate($purchase[0])  
               && in_array($purchase[1], $sizes) 
               && in_array($purchase[2], $couriers)
               ;

    }
}