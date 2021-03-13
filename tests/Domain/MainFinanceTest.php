<?php

namespace App\Tests\Domain;

use App\Domain\MainFinance;
use PHPUnit\Framework\TestCase;

class MainFinanceTest extends TestCase
{

    /**
     * Factor:
     *      - Current Day
     * Equivalence classes:
     *      - All days in the history are equals
     *  Limits
     *      - errors tend to show up in the limits, the limits to our equivalence class (day) are:
     *          - start and end of moths: 1,28,30,31
     *          - start and end months: 1 and 12
     *          - any year
     *      - we should make 4*2*1 = 8 asserts
     */
    public function testToday()
    {
        $this->assertToday(getdate(strtotime("2000-01-01 00:00:00")), "2000-01-01 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-01 00:00:00")), "2000-12-01 00:00:00");
        // it has no sense to prove 01 and 12 month with 28 so prove it with february and the result is two proves we can reduced to one
        $this->assertToday(getdate(strtotime("2000-02-28 00:00:00")), "2000-02-28 00:00:00");
        $this->assertToday(getdate(strtotime("2000-01-30 00:00:00")), "2000-01-30 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-30 00:00:00")), "2000-12-30 00:00:00");
        $this->assertToday(getdate(strtotime("2000-01-31 00:00:00")), "2000-01-31 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-31 00:00:00")), "2000-12-31 00:00:00");

    }

    private function assertToday($date, $assertResponse)
    {
        $mainFinanceTestFake = \Mockery::mock(MainFinance::class)->makePartial();
        $mainFinanceTestFake->shouldReceive('getCurrentDay')->andReturn($date);
        $this->assertEquals($assertResponse, $mainFinanceTestFake->today());
    }


    // Created to be parametric and make easier other proves of the limits, I use INF because PHP_FLOAT_MIN and so on its only available on php7.2
    const NEG_INF = -INF;
    const POS_INF = INF;
    const POS_ZERO = 0.01; //PHP_FLOAT_EPSILON only available on >php7.2
    const NEG_ZERO = -0.01;
    const TAX = 20;

    /**
     * Factor:
     *      - Price because taxes it is hardcoded inside the function to 20
     * Equivalence classes:
     *      - negative numbers
     *      - positive numbers
     *  Limits
     *      - errors tend to show up in the limits, the limits to our equivalence class (day) are:
     *          - -inf
     *          - 0 by the left
     *          - 0 by the right
     *          - inf
     *      - 4
     */
    public function testVAT()
    {
        // Test to discover the functionality and preserve de original output
        $this->assertVAT(400, 480, 80);
        $this->assertVAT(200, 240, 40);
        $this->assertVAT(150.85, 181.02, 30.17);
        // Unit test
        $this->assertVAT(self::NEG_INF, 0, 0);
        $this->assertVAT(self::NEG_ZERO, 0, 0);// not working on original code
        $this->assertVAT(self::POS_ZERO, round(self::POS_ZERO * 1.20, 2), round(self::POS_ZERO * 0.20, 2));
        $this->assertVAT(self::POS_INF, round(self::POS_INF * 1.20, 2),
            round(self::POS_INF * 0.20, 2)); //not working on original code

    }

    private function assertVAT($price, $priceResult, $taxResult)
    {
        $tax = self::TAX;
        $this->assertEquals($priceResult, (new MainFinance())->VAT($price, $tax));
        $this->assertEquals($taxResult, $tax);
    }

}