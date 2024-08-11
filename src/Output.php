<?php
namespace Vinted;

class Output{
    public function getOutputStr($arrayData) : string
    {
        $outputSts = array_map(function($line){
            if(isset($line[3]) && is_float($line[3])) $line[3] = number_format($line[3], 2, '.', '');
            if(isset($line[4]) && is_float($line[4])) $line[4] = number_format($line[4], 2, '.', '');
            return implode(' ', $line);
        }, $arrayData);
        $outputStr = implode("\n",  $outputSts);

        return $outputStr;
    }
}