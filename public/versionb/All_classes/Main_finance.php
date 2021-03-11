<?php

class Main_finance
{

    const TAX = 0.2;

    function today()
    {

        $date_array = $this->getCurrentDay();
        $yearID = $date_array['year'];
        $monthID = $date_array['mon'];
        if ($monthID < 10) {
            $m2 = "0" . $monthID;
        } else {
            $m2 = $monthID;
        }
        $dayID = $date_array['mday'];
        if ($dayID < 10) {
            $d2 = "0" . $dayID;
        } else {
            $d2 = $dayID;
        }

        return $yearID . "-" . $m2 . "-" . $d2 . " 00:00:00";

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
        return round($price * (1 + self::TAX), 2);
    }


    function getCurrentDay()
    {
        return getdate();
    }

}


