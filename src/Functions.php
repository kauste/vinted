<?php
namespace Vinted;

class Functions{
    
    public static function minValue(array $list) : float
    {
       if(!Validator::isNotEmptyArray($list, 'Sizes list')) return -1.00;
      
        $list = array_values($list);
        sort($list);
        if(!Validator::isNumeric($list[0], 'size')) return -1.00;
        if(!Validator::isGreaterThanZero($list[0], 'size')) return -1.00;
        return $list[0];
        
    }
    public static function strToNestedArr(string $inputStr, string $separator1, string $separator2) :array
    {

        $inputArr = explode($separator1, $inputStr);
        $inputArr = array_map(fn($el) => trim($el), $inputArr);
        $inputArr = array_filter($inputArr, fn($el) => !!$el);
        $inputArr = array_map(function($line) use ($separator2){
            $nestedArr = explode($separator2, $line);
            $nestedArr = array_map(fn($el) => trim($el), $nestedArr);
            $nestedArr = array_filter($nestedArr, fn($el) => !!$el);
            return  array_values($nestedArr);
        }, $inputArr);
        return array_values($inputArr);
    }
}