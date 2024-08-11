<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Vinted\Functions;

class FunctionsTest extends TestCase 
{
    public static function minValueProvider() : array
    {
        $data1 = ['a', 100, 2, [], 15, 11.5, 'A'];
        $expectedResult1 = 2;
        return [ [ $data1, $expectedResult1 ] ];
    }
    public static function nestedArrProvider() : array
    {
        $data1 = "jsvkjvsdnk\n2005-08-01 S MR\n2015-08-09 Mr MR\n2015-08-12 s mr\n2015-08-09 M MR\n2025-08-09 L MR\n2016-08-09 Mr MR\n2025-08-09MrMR\n\n\n\n     2016-08-19 S LP";
        $separator1_1 = "\n";
        $separator2_1 = ' ';
        $expectedResult1 = [
            ['jsvkjvsdnk'],
            ['2005-08-01', 'S', 'MR'],
            ['2015-08-09', 'Mr', 'MR'],
            ['2015-08-12', 's', 'mr'],
            ['2015-08-09', 'M', 'MR'],
            ['2025-08-09', 'L', 'MR'],
            ['2016-08-09', 'Mr', 'MR'],
            ['2025-08-09MrMR'],
            ['2016-08-19', 'S', 'LP'],
        ];
        return [
            [$data1, $separator1_1, $separator2_1,  $expectedResult1]
        ];
    }

    #[DataProvider('minValueProvider')]
    public function testMinValue($data, $expectedResult) : void
    {
        $result = Functions::minValue($data);
        $this->assertEquals($expectedResult, $result);

    }

    #[DataProvider('nestedArrProvider')]
    public function testNestedArr($data, $separator1, $separator2, $expectedResult) : void
    {
        $result = Functions::strToNestedArr($data, $separator1, $separator2);

        $this->assertEquals($expectedResult, $result);

    }

}