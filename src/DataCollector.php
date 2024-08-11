<?php
namespace Vinted;

class DataCollector {

    public function getData($fileName) : string
    {
        if(!Validator::fileExists('src/data/',  $fileName))  return '';

        return file_get_contents('src/data/' . $fileName);
    }
    public function getSerializedData(string $fileName) : array 
    {
        $data = $this->getData($fileName);
        if(!$data || !Validator::isSerialized($data)) return [];

        return unserialize($data);
    }
    public function selectData(array $data, array $keys) : array
    {
        $selectedData = array_map(function($item) use ($keys) {
            $filteredItem = array_reduce($keys, function($carry, $key) use ($item){
                $carry[$key] = isset($item[$key]) ? $item[$key] : null;
                return $carry;
            });
            return $filteredItem;
        }, $data);
        return $selectedData;
    }
    public function getSelectedData(string $fileName, array $keys) : array
    {
        $data = $this->getSerializedData($fileName);
        $selectedData = $this->selectData($data, $keys);
        return $selectedData;
    }
    private function prepareAliases(array $renameColumns) : array
    {
        // Extract child column keys and their aliases, make aliases keys and keys values
        $exploded = array_reduce($renameColumns,function($carry, string $selection){
            [$value, $key] = explode(' as ', $selection) + [null, null];
            if($value && $key){
                $carry[$key] = $value;
            }
            elseif($value){
                $carry[$value] = $value;
            }
            return $carry;
        });
        return $exploded;
    }
    public function leftJoin(array $leftData, array $rightData) : array
    {
        $leftRecords = $leftData[0];
        $leftAliases = $this->prepareAliases($leftData[1]);

        if(!$leftData || !$leftRecords || !$rightData){
            echo "\n\033[31m*** ERROR! No table to connect added ***\033[0m\n";
            return [];
        }
        // Map through parent records
        $list = array_map(function($leftRecord) use ($leftAliases, $rightData){

            $leftReturn = array_map(function($oldkey) use ($leftRecord){ 
                return isset($leftRecord[$oldkey]) ? $leftRecord[$oldkey] : null;
            }, $leftAliases);

            $rightReturn = array_map(function($rightOneItemData) use ($leftRecord){
                $secondaryKey = $rightOneItemData[2];
                $primaryKey = $rightOneItemData[3] ?? 'id';

                $rightOneItemRecords = $rightOneItemData[0];
                $rightOneItemAliases =  $this->prepareAliases($rightOneItemData[1]);


                
                if(isset($leftRecord[$secondaryKey]) 
                && in_array($leftRecord[$secondaryKey], array_column($rightOneItemRecords, $primaryKey))){
                    $connectioniD = $leftRecord[$secondaryKey];
                    $recordToJoin;
                    foreach($rightOneItemRecords as $rightOneItemRecord){
                        if(isset($rightOneItemRecord[$primaryKey]) && $rightOneItemRecord[$primaryKey] === $connectioniD){
                            $recordToJoin =  $rightOneItemRecord;
                            break;
                        }
                    }
                    $rightReturn = array_map(function($oldkey) use ($recordToJoin){ 
                        return isset($recordToJoin[$oldkey]) ? $recordToJoin[$oldkey] : null;
                    }, $rightOneItemAliases);
                    return $rightReturn;
                }
                else {
                    $rightReturn = [array_key_first($rightOneItemAliases) => null ];
                }
                return $rightReturn;
            }, $rightData);

            return array_merge($leftReturn, ...$rightReturn);

        }, $leftRecords);
        return $list;
    }


}