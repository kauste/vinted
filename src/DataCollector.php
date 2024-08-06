<?php
namespace Vinted;

class DataCollector {

    public function getData($fileName) : string
    {
        return file_get_contents('src/data/' . $fileName . '.txt');
    }
    public function getSerializedData($fileName) : array 
    {
        return unserialize($this->getData($fileName));
    }
    public function selectData($data, $keys) : array
    {
        $selectedData = array_map(function($item) use ($keys) {
            $filteredItem = array_filter($item, function($cellKey) use ($keys){
                return in_array($cellKey, $keys);
            }, ARRAY_FILTER_USE_KEY);
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
    public function connectData($parentData, $childrenData) : array
    {
        $parentRecords = $parentData[0];
        // Extract parent column keys and their aliases, make aliases keys and keys values
        $parentColumnKeys = array_reduce($parentData[1],function($carry, $selection){
                [$name, $rename] = explode(' as ', $selection);
                $carry[$rename] = $name;
                return $carry;
        }) ;

        // Map through parent records
        $list = array_map(function($item) use ($parentColumnKeys, $childrenData){
            //  Map and extract the required parent data
            $parentReturn = array_map(function($key) use ($item){ 
                return $item[$key];
            }, $parentColumnKeys);
            // Map through all children data
            $childrenReturn = array_map(function($childData) use ($item){
                $childRecords = $childData[0];
                 // Extract child column keys and their aliases, make aliases keys and keys values
                $childColumnKeys =  array_reduce($childData[1], function($carry,$selection){
                    [$name, $rename] = explode(' as ', $selection);
                    $carry[$rename] = $name;
                    return $carry;
                });
                $idInParent = $childData[2];
                $idInChild = $childData[3] ?? 'id';
                // Find the child record where the child's ID matches the parent record's child_id
                $childIndex = array_search($item[$idInParent], array_column($childRecords, $idInChild));
                //  Map and extract the required child data
                $childReturn = array_map(fn($selected) => $childRecords[$childIndex][$selected] , $childColumnKeys);
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