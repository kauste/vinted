<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Vinted\DataCollector;

class DataCollectorTest extends TestCase 
{
    private $dataCollectorClass;


    protected function setUp () : void
    {
        $this->dataCollectorClass = new DataCollector();
        
    }
    public static function getDataProvider() :array
    {
        $fileName1 = 'test-text.txt';
        $expectedResult1 = "jsvkjvsdnk\n2005-08-01 S MR\n2015-08-09 Mr MR\n2015-08-12 s mr\n2015-08-09 M MR\n2025-08-09 L MR\n2016-08-09 Mr MR\n2025-08-09MrMR\n\n\n\n     2016-08-19 S LP";
        return [
                  [$fileName1, $expectedResult1]
               ];
    }
    public static function selectDataProvider () : array
    {
        $data1 = [
            ['id' => 1, 'title' => 'La Poste', 'short' => 'LP', 'b'],
            ['id' => 2, 'title' => 'Mondial Relay', 'short' => 'MR', null],
            ['id' => 3, 'title' => 2, 'short' => 5],
            ['id' => 4, 'title' => 'Mondial Relay', 'short' => []],
            ['id' => 'aaa', 'title' => 'La Poste', 'short' => 'LP', []],
            ['id' => [], 'title' => '', 'short' => '', '', '%%%%%'],
            [ 'title' => 'La Poste', 'short' => 'fff'],
            ['id' => -2, 'title' => 'Mondial Relay', 'short' => -10.5],
        
        ];
        $keys1 = ['id', 'short'];
        $expectedResult1 = [
            ['id' => 1, 'short' => 'LP'],
            ['id' => 2, 'short' => 'MR'],
            ['id' => 3, 'short' => 5],
            ['id' => 4, 'short' => []],
            ['id' => 'aaa', 'short' => 'LP'],
            ['id' => [], 'short' => ''],
            ['id' => null, 'short' => 'fff'],
            ['id' => -2, 'short' => -10.5],
        ];
        return  [
                  [$data1, $keys1, $expectedResult1],
                ];
    }
    public static function getSelectedDataProvider() :array
    {
        
        $keys1 = ['id', 'short'];
        $expectedResult1 = [
            ['id' => 1, 'short' => 'LP'],
            ['id' => 2, 'short' => 'MR'],
            ['id' => 3, 'short' => 5],
            ['id' => 4, 'short' => []],
            ['id' => 'aaa', 'short' => 'LP'],
            ['id' => [], 'short' => ''],
            ['id' => null, 'short' => 'fff'],
            ['id' => -2, 'short' => -10.5],
        ];
        return [
                 [$keys1, $expectedResult1],
               ];
    }
    public static function leftJoinProvider() :array
    {
        $couriersData1 = [
            ['id' => 1, 'title' => 'La Poste', 'short' => 'LP', 'b'],
            ['id' => 2, 'title' => 'Mondial Relay', 'short' => 'MR', null],
            ['id' => 3, 'title' => 2, 'short' => 5],
            ['id' => 4, 'title' => 'Mondial Relay', 'short' => []],
            ['id' => 'aaa', 'title' => 'La Poste', 'short' => 'LP', []],
            ['id' => [], 'title' => '', 'short' => '', '', '%%%%%'],
            [ 'title' => 'La Poste', 'short' => 'fff'],
            ['id' => -2, 'title' => 'Mondial Relay', 'short' => -10.5],
        
        ];
        $sizesData1 =  [
            ['id' => 1, 'title' => 'small', 'short' => 'S'],
            ['id' => 2, 'title' => 'medium', 'short' => 'M'],
            ['id' => 3, 'title' => 'lardge', 'short' => 'L'],
            ['id' => 4, 'title' => 'small', 'short' => []],
            ['id' => 5, 'title' => ''],
            ['id' => 6, 'title' => 'aaa', 'short' => 5],
            [ 'title' => 'small', 'short' => 'S'],
            ['id' => 'bbb', 'title' => 'medium', 'short' => 'M'],
            ['id' => [], 'title' => 'lardge', 'short' => 'L'],
        ];
        $pricesData1 =  [
            ['courier_id' => 1, 'size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => 1, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => 1, 'size_id' => 3, 'price' => 6.90, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 1, 'price' => 2.00, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 2, 'price' => 3.00, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 3, 'price' => 4.00, 'currency' => 'euro'],
            ['courier_id' => 10, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => 'aaa', 'size_id' => 'bbb', 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => [], 'size_id' => [], 'price' => 6.90, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => -1000, 'price' => 2.00, 'currency' => 'euro'],
            ['courier_id' => 4, 'size_id' => 6, 'price' => 3.00, 'currency' => 'euro'],
            ['courier_id' => 4, 'size_id' => 5, 'price' => 4.00, 'currency' => 'euro'],
            ['size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => null, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => [], 'price' => -1000, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => null, 'price' => 2.00, 'currency' => '[]]'],
            ['courier_id' => null, 'size_id' => null, 'price' => 'hiohohi', 'currency' => 'euro'],
            ['courier_id' => 1000, 'size_id' => 3, 'price' => 'jabas', 'currency' => 'euro'],
        ];
        $leftData1 = [$pricesData1, ['price as price']];
        $rightData1 = [
                [$couriersData1, ['short as courier'], 'courier_id', 'id'],
                [$sizesData1, ['short as size'], 'size_id', 'id'],
        ];
        $expectedResult1 =[
            ['courier' => 'LP', 'size' => 'S', 'price' => 1.50 ],
            ['courier' => 'LP', 'size' => 'M', 'price' => 4.90 ],
            ['courier' => 'LP', 'size' => 'L', 'price' => 6.90 ],
            ['courier' => 'MR', 'size' => 'S', 'price' => 2.00 ],
            ['courier' => 'MR', 'size' => 'M', 'price' => 3.00 ],
            ['courier' => 'MR', 'size' => 'L', 'price' => 4.00 ],
            ['courier' => null, 'size' => null,'price' => 1.50 ],
            ['courier' => 'LP', 'size' => 'M', 'price' => 4.90 ],
            
            ['courier' => '', 'size' => 'L', 'price' => 6.90 ],
            ['courier' => 'MR', 'size' => null, 'price' => 2.00 ],
            ['courier' => [], 'size' => 5, 'price' => 3.00 ],
            ['courier' => [], 'size' => null, 'price' => 4.00 ],
            ['courier' => null, 'size' => 'S', 'price' => 1.50 ],
            ['courier' => null, 'size' => 'M', 'price' => 4.90 ],
            ['courier' => '', 'size' => null, 'price' => -1000 ],
            ['courier' => 'MR', 'size' => null, 'price' => 2.00 ],
            ['courier' => null, 'size' => null, 'price' => 'hiohohi' ],
            ['courier' => null, 'size' => 'L', 'price' => 'jabas' ],
        ];
        return [
            [$leftData1, $rightData1, $expectedResult1],
        ];
    }

    #[DataProvider('getDataProvider')]
    public function testGetData($fileName, $expectedResult) : void
    {
        $result = $this->dataCollectorClass->getData($fileName);
        $this->assertEquals($expectedResult, $result);
    }
    public function testGetSerializedData() : void 
    {
        $expectedResult = [
            ['courier_id' => 1, 'size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => 1, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => 1, 'size_id' => 3, 'price' => 6.90, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 1, 'price' => 2.00, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 2, 'price' => 3.00, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => 3, 'price' => 4.00, 'currency' => 'euro'],
            ['courier_id' => 10, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => 'aaa', 'size_id' => 'bbb', 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => [], 'size_id' => [], 'price' => 6.90, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => -1000, 'price' => 2.00, 'currency' => 'euro'],
            ['courier_id' => 4, 'size_id' => 6, 'price' => 3.00, 'currency' => 'euro'],
            ['courier_id' => 4, 'size_id' => 5, 'price' => 4.00, 'currency' => 'euro'],
            ['size_id' => 1, 'price' => 1.50, 'currency' => 'euro'],
            ['courier_id' => null, 'size_id' => 2, 'price' => 4.90, 'currency' => 'euro'],
            ['courier_id' => [], 'price' => -1000, 'currency' => 'euro'],
            ['courier_id' => 2, 'size_id' => null, 'price' => 2.00, 'currency' => '[]]'],
            ['courier_id' => null, 'size_id' => null, 'price' => 'hiohohi', 'currency' => 'euro'],
            ['courier_id' => 1000, 'size_id' => 3, 'price' => 'jabas', 'currency' => 'euro'],
        ];
        $result = $this->dataCollectorClass->getSerializedData('test-prices.txt');
        $this->assertEquals($expectedResult, $result);
    }

    #[DataProvider('selectDataProvider')]
    public function testSelectData($data, $keys, $expectedResult) : void
    {

        $result = $this->dataCollectorClass->selectData($data, $keys);
        $this->assertEquals($expectedResult, $result);

    }
    #[DataProvider('getSelectedDataProvider')]
    public function testGetSelectedData($keys, $expectedResult) : void
    {
        $result = $this->dataCollectorClass->getSelectedData('test-couriers.txt', $keys);
        $this->assertEquals($expectedResult, $result);
    }
    #[DataProvider('leftJoinProvider')]
    public function testLeftJoin($leftData, $rightData, $expectedResult) : void
    {

        $result = $this->dataCollectorClass->leftJoin($leftData, $rightData);
        $this->assertEquals($expectedResult, $result);

    }

}