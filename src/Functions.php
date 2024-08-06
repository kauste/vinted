<?php
namespace Vinted;

class Functions{
    
    public static function minValue($list) : float
    {
        $list = array_values($list);
        sort($list);
        return $list[0];
        
    }
    public static function strToNestedArr($inputStr, $separator1, $separator2) :array
    {
        $inputArr = explode($separator1, $inputStr);
        $inputArr = array_map(function($line) use ($separator2){
            $nestedArr = explode($separator2, $line);
            $nestedArr = array_map(fn($el) => trim($el),$nestedArr);
            return  $nestedArr;
        }, $inputArr);
        return $inputArr;
    }
}