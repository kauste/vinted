<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Vinted\CourierPriceController;
use Vinted\CourierDataService;
use Vinted\Validator;
use Vinted\Output;

class CourierPriceControllerTest extends TestCase
{
    private $courierPriceController;

    protected function setUp(): void
    {

        $this->courierPriceController = new CourierPriceController('test-prices.txt', 'test-couriers.txt', 'test-sizes.txt', 'test-text.txt');
    }

    public static function countPricesAndDiscountsProvider(): array
    {
        return [
            [
                'expectedOutput' =>  "jsvkjvsdnk Ignored\n2005-08-01 S MR Ignored\n2015-08-09 Mr MR Ignored\n2015-08-12 s mr Ignored\n2015-08-09 M MR 3.00 -\n2025-08-09 L MR Ignored\n2016-08-09 Mr MR Ignored\n2025-08-09MrMR Ignored\n2016-08-19 S LP 1.50 -",
            ],
        ];
    }

    #[DataProvider('countPricesAndDiscountsProvider')]
    public function testCountPricesAndDiscounts($expectedOutput)
    {
        $this->courierPriceController->countPricesAndDiscounts();
        $this->expectOutputString($expectedOutput);
    }
}
