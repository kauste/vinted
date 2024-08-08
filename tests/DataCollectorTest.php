<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../vendor/autoload.php';
use Vinted\DataCollector;

class DataCollectorTest extends TestCase 
{
    private $dataCollectorClass;
    private $serializedFileName;
    private $arrFromSerialized;

    protected function setUp () : void
    {
        $this->dataCollectorClass = new DataCollector();
        $this->serializedFileName = 'test-serialized.txt';
        $this->arrFromSerialized = [
            ['id' => 1, 'surname' => 'Brown', 2 => 2, 'a' => [], 'school_id' => 1, 'group_id' => 1],
            ['name' => 'Ieva', 'surname' => 'Kučinskaitė', 7 => null, 'school_id' => 1,],
            ['id' => 3, 'name' => 'Bradd', 'surname' => 'Pitt', 'cccc', 'school_id' => 2, 'group_id' => 1],
            ['name' => 'Agnė', 'surname' => 'Kiškytė', 'school_id' => 1,'school_id' => 2, 'group_id' => 2],
            ['ksdvnl', 'white' => '#fff', '%%%%%', '58758p50' => json_encode([1,1,1,1,1])],
            ['id'=> 6, 'name' => [], 'surname' => 2],
        ];
        $this->schoolsData = [
            ['id' => 1, 'title' => 'Jotvingių gimnazija', 'short' => 'JG'],
            ['id' => 2, 'title' => 'Marcinkevičiaus gimnazija', 'short' => 'MG'],
            ['id' => 3, 'title' => 'Kybartų pradinė', 'short' => 'KP'],
        ];
        $this->groupsData = [
            ['id' => 1, 'title' => 'Tiksliukai', 'short' => 'T'],
            ['id' => 2, 'title' => 'Humanitarai', 'short' => 'H'],
        ];

    }

    public function testGetData() : void
    {
        $fileName = 'test-text.txt';
        $expectedResult = "2020-01-01 John Brown\n 2000-07-02 Ann Pitt\n 1999-02-02 Bradd Brown\n 1984 000 AAA\n AAA BBB 2024-01-01 Ieva Kučinskaitė";
        $result = $this->dataCollectorClass->getData($fileName);
        $this->assertEquals($expectedResult, $result);
    }
    public function testGetSerializedData() : void 
    {
        $expectedResult = $this->arrFromSerialized;
        $result = $this->dataCollectorClass->getSerializedData($this->serializedFileName);
        $this->assertEquals($expectedResult, $result);
    }

    public function testSelectData() : void
    {
        $dataCollectorClass = new DataCollector();
        $data = $this->arrFromSerialized;
        $keys = ['name', 'surname'];
        $expectedResult = [
            ['name' => null, 'surname' => 'Brown'],
            ['name' => 'Ieva', 'surname' => 'Kučinskaitė'],
            ['name' => 'Bradd', 'surname' => 'Pitt'],
            ['name' => 'Agnė', 'surname' => 'Kiškytė'],
            ['name' => null, 'surname' => null],
            ['name' => [], 'surname' => 2],

        ];
        $result = $dataCollectorClass->selectData($data, $keys);
        $this->assertEquals($expectedResult, $result);

    }
    public function testGetSelectedData() : void
    {
        $keys = ['id', 'surname'];
        $expectedResult =[
            ['id' => 1, 'surname' => 'Brown'],
            ['id' => null, 'surname' => 'Kučinskaitė'],
            ['id' => 3, 'surname' => 'Pitt'],
            ['id' => null, 'surname' => 'Kiškytė'],
            ['id' => null, 'surname' => null],
            ['id' => 6, 'surname' => 2],

        ];
        $result = $this->dataCollectorClass->getSelectedData($this->serializedFileName, $keys);
        $this->assertEquals($expectedResult, $result);
    }
    public function testConnectData() : void
    {

        $parentData = [$this->arrFromSerialized, ['name as name', 'surname as surname']];
        $childrenData = [
                [$this->schoolsData, ['short as school'], 'school_id', 'id'],
                [$this->groupsData, ['short as group'], 'group_id', 'id'],
        ];
        $expectedResult =[
            ['name' => null, 'surname' => 'Brown', 'school' => 'JG' ,'group' => 'T'],
            ['name' => 'Ieva', 'surname' => 'Kučinskaitė', 'school' => 'JG', 'group' => null],
            ['name' => 'Bradd', 'surname' => 'Pitt', 'school' => 'MG', 'group' => 'T'],
            ['name' => 'Agnė', 'surname' => 'Kiškytė', 'school' => 'MG', 'group' => 'H'],
            ['name' => null, 'surname' => null, 'school' => null, 'group' => null],
            ['name' => [], 'surname' => 2, 'school' => null, 'group' => null],
        ];
        $result = $this->dataCollectorClass->connectData($parentData, $childrenData);
        $this->assertEquals($expectedResult, $result);

    }
}