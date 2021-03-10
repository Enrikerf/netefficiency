<?php
class Main_finance {

    function Main_finance() {


    }

    function getpcnumber($code) {

        $n = 0;
        $ascii_zero = ord("0");
        $ascii_nine = ord("9");


        $l = strlen($code);
        for ($c=1; $c<=$l; $c++) {
            $a1 = substr($code,$c-1,1);
            $ascii = ord($a1);
            if (($ascii >= $ascii_zero) && ($ascii <= $ascii_nine)) {
                $cn = $ascii - $ascii_zero;
                if ($n > 0) {
                    $n=$n*10;
                }
                $n = $n+$cn;
            } else if ($n > 0) {
                return $n;
            }
        }

        return $n;

    }

    function attendance($attend_start, $attend_end, &$ndays) {


        $tstart = strtotime($attend_start);
        $currentday = $attend_start;
        $tend = strtotime($attend_end);

        $att = date("D jS M",$tstart);

        $ndays = 1;

        $maxloops = 10;
        $loops = 0;
        while (($loops < $maxloops) && ($currentday < $attend_end) ) {
            $loops++;
            if ($loops > $maxloops) die (" Error in finance->attendance() too many steps through loop ");

            $nextday = strtotime($currentday." + 1 days ");


            if ($tend >= $nextday) {
                $att.=", ".date("D jS M", $nextday);
                $ndays++;
            }
            $currentday = date("Y-m-d",$nextday);
        }

        return $att;

    }

    function getenddate($thisyear,$thismonth,$day,$term) {


        if (($term=="1 months") or ($term=="1 month")) {

            $imonth= (int)($thismonth);
            $imonth++;
            if ($imonth > 12) {
                $iyear = (int)($thisyear) + 1;
                $imonth = $imonth-12;
            } else {
                $iyear = (int)($thisyear);
            }
            $newyear = strval($iyear);
            $newmonth = strval($imonth);

            return $newyear."-".$newmonth."-".$day." 00:00:00";

        } else if (substr($term,-6)=="months") {
            $imonth= (int)($thismonth);
            $addmonth = (int)(substr($term,0,1));
            $imonth = $imonth + $addmonth;
            if ($imonth > 12) {
                $iyear = (int)($thisyear) + 1;
                $imonth = $imonth-12;
            } else {
                $iyear = (int)($thisyear);
            }
            $newyear = strval($iyear);
            $newmonth = strval($imonth);
        } else {
            $addyear = 1;
            if (($term=="2 year") or ($term=="2 years")) {
                $addyear = 2;
            }

            $iyear = intval($thisyear);
            $iyear = $iyear + $addyear;
            $newyear = strval($iyear);
            $newmonth=$thismonth;
        }

        $newday = $day;
        $iday = intval($day);
        if ($iday > 1) {
            $iday--;
            if ($iday > 9) {
                $newday = strval($iday);
            } else {
                $newday = "0".strval($iday);
            }
        }

        return $newyear."-".$newmonth."-".$newday." 00:00:00";

    }

    function publicationmonth($startdate) {

        $mnames = array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");

        $m = substr($startdate, 5, 2);
        if (!isset($mnames[$m])) return " month error ";

        $pubmonth = $mnames[$m]." ".substr($startdate,0,4);

        return $pubmonth;
    }


    function today() {

        $date_array = getdate();
        $yearID=$date_array['year'];
        $monthID=$date_array['mon'];
        if ($monthID < 10) {
            $m2 = "0".$monthID;
        } else {
            $m2 = $monthID;
        }
        $dayID = $date_array['mday'];
        if ($dayID < 10) {
            $d2 = "0".$dayID;
        } else {
            $d2 = $dayID;
        }

        return $yearID."-".$m2."-".$d2." 00:00:00";

    }


    function addstringprices($price1, $price2) {


        $price1 = str_replace(",","",$price1);
        $price2 = str_replace(",","",$price2);


        $ip1 = $this->makeintegerpence($price1);
        $ip2 = $this->makeintegerpence($price2);
        $ip3 = $ip1 + $ip2;


        $p1 = floor($ip3/100);
        $p2 = $p1*100;
        $p3 = $ip3 - $p2;
        $p4 = "$p3";
        if ($p3 <= 9) $p4 = "0".$p3;

        $p5 =  "$p1".".".$p4;

        return $p5;
    }

    function makeintegerpence($price) {

        $price = trim($price);
        $price = str_replace(",","",$price);
        $dot = false;
        $len = strlen($price);
        $pence = 0;
        $power = 1;
        $afterdot = 0;
        for ($a=1; $a<=$len; $a++) {
            $c1 = substr($price,$a-1,1);
            if ($c1==".") {
                $dot = true;
            } else {
                $n1 = ord($c1) - 48;

                $pence = $pence*$power;

                if ($n1 <> 0) {
                    $pence = $pence+$n1;
                }
                $power=10;
                if ($dot) $afterdot++;
            }
        }
        if ($afterdot==1) $pence = $pence*10;
        if (!$dot) {
            $pence = $pence*100;
        }
        return $pence;
    }

    function subtractstringprices($price1, $price2) {


        $price1 = str_replace(",","",$price1);
        $price2 = str_replace(",","",$price2);

        $ip1 = $this->makeintegerpence($price1);
        $ip2 = $this->makeintegerpence($price2);
        $ip3 = $ip1 - $ip2;

        $p1 = floor($ip3/100);
        $p2 = $p1*100;
        $p3 = $ip3 - $p2;
        $p4 = "$p3";
        if ($p3 < 9) $p4 = "0".$p3;

        $p5 =  "$p1".".".$p4;

        return $p5;
    }

    function VAT($price, &$tax) {

        if ($price=="0.00") return $price;
        $tax = "0.00";

        $today = $this->today();

        $thisyear = substr($today,0,4);
        $rate = 20;

        $fullprice = (int)($price*100);
        $tax = floor($fullprice*$rate)/100;
        $tax = (int)$tax;

        $finalprice = $fullprice + $tax;


        $p1 = floor($finalprice/100);
        $p2 = $p1*100;
        $p3 = $finalprice - $p2;
        $p4 = "$p3";
        if ($p3 < 9) $p4 = "0".$p3;

        $price = $p1.".".$p4;

        $p1 = floor($tax/100);
        $p2 = $p1*100;
        $p3 = $tax - $p2;
        $p4 = "$p3";
        if ($p3 < 9) $p4 = "0".$p3;

        $tax = $p1.".".$p4;

        return $price;

    }
}


?>