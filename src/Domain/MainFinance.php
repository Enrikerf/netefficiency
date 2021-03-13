<?php

namespace App\Domain;

use DateTime;

class MainFinance
{

    const TAX = 0.2;

    public function today(): string
    {
        $todayDateArray = $this->getCurrentDay();
        $todayDate = (new DateTime())->setTimestamp($todayDateArray[0]);
        return $todayDate->format("Y-m-d") . " 00:00:00";
    }

    public function VAT(float $price, float &$tax): float
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
        return number_format(round($price * (1 + self::TAX), 2), 2, '.', '');
    }


    public function getCurrentDay(): array
    {
        return getdate();
    }

}


