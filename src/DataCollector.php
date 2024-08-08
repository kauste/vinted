<?php
namespace Vinted;

class DataCollector {

    public function getData($fileName) : string
    {
        if(!Validator::fileExists('src/data/',  $fileName))  return '';

        return file_get_contents('src/data/' . $fileName);
    }
    public function getSerializedData($fileName) : array 
    {
        $data = $this->getData($fileName);
        if(!$data || !Validator::isSerialized($data)) return [];

        return unserialize($data);
    }
    public function selectData($data, $keys) : array
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
    public function getSelectedData($fileName, $keys) : array
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
    public function connectData($parentData, $childrenData) : array
    {
        $parentRecords = $parentData[0];
        $parentAliases = $this->prepareAliases($parentData[1]);

        // Map through parent records
        $list = array_map(function($item) use ($parentAliases, $childrenData){
            //  Map and extract the required parent data
            $parentReturn = array_map(function($key) use ($item){ 
                return isset($item[$key]) ? $item[$key] : null;
            }, $parentAliases);
            // Map through all children data
            $childrenReturn = array_map(function($childData) use ($item){
                $childRecords = $childData[0];
                $childAliases =  $this->prepareAliases($childData[1]);
                $secondaryKey = $childData[2];
                $primaryKey = $childData[3] ?? 'id';
                // Find the child record where the child's ID matches the parent record's child_id
                $connectioniD = $item[$secondaryKey];

                if(isset($connectioniD)){
                    $childIndex = array_search($connectioniD, array_column($childRecords, $primaryKey));
                    $childReturn = array_map(fn($oldKey) => $childRecords[$childIndex][$oldKey] , $childAliases);
                }
                else {
                    $childReturn = [array_key_first($childAliases) => null ];
                }
                return $childReturn;

            }, $childrenData);
            // Merge parent and child data
            return array_merge($parentReturn, ...$childrenReturn);

        }, $parentRecords);
        return $list;
    }

    // public function getPriceList() : array
    // {
    //     $couriers = $this->getSelectedData('couriers', ['id', 'short']);
    //     $sizes = $this->getSelectedData('sizes', ['id', 'short']);
    //     $priceList = $this->getSerializedData('prices');

        // $priceList = $this->connectData($priceList, $sizes, 'size')
        // $priceList = $this->connectData($priceList, $couriers, 'privider')
        // $priceList = $this->selectData($priceList, [])

        // $priceList = array_map(function($price) use ($couriers, $sizes){
        //     $courier_index = array_search($price['courier_id'], array_column($couriers, 'id'));
        //     $size_index = array_search($price['size_id'], array_column($sizes, 'id'));
        //     return [
        //         'courier' => $couriers[$courier_index]['short'],
        //         'size' => $sizes[$size_index]['short'],
        //         'price' => $price['price'],
        //     ];
        // }, $priceList);
        // return $priceList;

    // }

}