<?php

class Main_finance
{

    const TAX = 0.2;

    function today()
    {
        $todayDateArray = $this->getCurrentDay();
        $todayDate = (new DateTime())->setTimestamp($todayDateArray[0]);
        return $todayDate->format("Y-m-d") . " 00:00:00";
    }

    function VAT($price, &$tax)
    {
        if ($price <= 0) {
            $tax = 0.00;
            return 0.00;
        }
        if ($price >= INF) {
            $tax = INF;
            return INF;
        }
        $tax = round($price * self::TAX, 2);
        return number_format(round($price * (1 + self::TAX), 2),2,'.','');
    }


    function getCurrentDay()
    {
        return getdate();
    }

}


