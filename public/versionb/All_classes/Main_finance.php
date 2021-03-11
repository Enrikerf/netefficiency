<?php

class Main_finance
{


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

        if ($price == "0.00") {
            return $price;
        }
        $tax = "0.00";
        $rate = 20;
        $fullprice = (int)($price * 100);
        $tax = floor($fullprice * $rate) / 100;
        $tax = (int)$tax;
        $finalprice = $fullprice + $tax;

        $p1 = floor($finalprice / 100);
        $p2 = $p1 * 100;
        $p3 = $finalprice - $p2;
        $p4 = "$p3";
        if ($p3 < 9) {
            $p4 = "0" . $p3;
        }

        $price = $p1 . "." . $p4;

        $p1 = floor($tax / 100);
        $p2 = $p1 * 100;
        $p3 = $tax - $p2;
        $p4 = "$p3";
        if ($p3 < 9) {
            $p4 = "0" . $p3;
        }

        $tax = $p1 . "." . $p4;

        return $price;

    }


    function getCurrentDay(){
        return getdate();
    }

}


