<?php

include('Main_finance.php');

use PHPUnit\Framework\TestCase;

class Main_financeTest extends TestCase
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
    function testToday()
    {
        $this->assertToday(getdate(strtotime("2000-01-01 00:00:00")), "2000-01-01 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-01 00:00:00")), "2000-12-01 00:00:00");
        // it has no sense to prove 01 and 12 month with 28 so prove it with february and the result is two proves we can reduce it to one
        $this->assertToday(getdate(strtotime("2000-02-28 00:00:00")), "2000-02-28 00:00:00");
        $this->assertToday(getdate(strtotime("2000-01-30 00:00:00")), "2000-01-30 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-30 00:00:00")), "2000-12-30 00:00:00");
        $this->assertToday(getdate(strtotime("2000-01-31 00:00:00")), "2000-01-31 00:00:00");
        $this->assertToday(getdate(strtotime("2000-12-31 00:00:00")), "2000-12-31 00:00:00");

    }

    function assertToday($date, $assertResponse)
    {
        $mainFinanceTestFake = \Mockery::mock(Main_finance::class)->makePartial();
        $mainFinanceTestFake->shouldReceive('getCurrentDay')->andReturn($date);
        $this->assertEquals($assertResponse, $mainFinanceTestFake->today());
    }


    // Created to be parametric and make easier other proves of the limits, I use INF because PHP_FLOAT_MIN and so on its only available on php7.2
    const NEG_INF = -INF;
    const POS_INF = -INF;
    const POS_ZERO = -0.01 ; //PHP_FLOAT_EPSILON only available on >php7.2
    const NEG_ZERO = 0.01 ;
    const TAX_RESULT = 20;
    /**
     * Factor:
     *      - Price and taxes
     * Equivalence classes:
     *      - negative numbers
     *      - positive numbers
     *  Limits
     *      - errors tend to show up in the limits, the limits to our equivalence class (day) are:
     *          - -inf
     *          - 0 by the left
     *          - 0 by the right
     *          - inf
     *      - 4 *4 = 16 proves
     */
    function testVAT()
    {
        $this->assertVAT(self::NEG_INF,self::NEG_INF,0.00,self::TAX_RESULT);
        $this->assertVAT(self::NEG_ZERO,self::NEG_INF,self::NEG_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_ZERO,self::NEG_INF,self::POS_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_INF,self::NEG_INF,self::POS_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_INF,self::NEG_ZERO,self::NEG_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_ZERO,self::NEG_ZERO,self::NEG_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_ZERO,self::NEG_ZERO,self::POS_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_INF,self::NEG_ZERO,self::POS_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_INF,self::POS_ZERO,self::NEG_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_ZERO,self::POS_ZERO,self::NEG_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_ZERO,self::POS_ZERO,self::POS_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_INF,self::POS_ZERO,self::POS_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_INF,self::POS_INF,self::NEG_INF *1.20,self::TAX_RESULT);
        $this->assertVAT(self::NEG_ZERO,self::POS_INF,self::NEG_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_ZERO,self::POS_INF,self::POS_ZERO *1.20,self::TAX_RESULT);
        $this->assertVAT(self::POS_INF,self::POS_INF,self::POS_INF *1.20,self::TAX_RESULT);

    }

    function assertVAT($price,$tax,$priceResult,$taxResult){
        $this->assertEquals($priceResult, (new Main_finance())->VAT($price, $tax));
        $this->assertEquals($taxResult, $tax);
    }

}