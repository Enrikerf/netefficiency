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

    public function calculateVat(float $basePrice): float
    {
        if ($basePrice <= 0) {
            return 0.00;
        }
        if ($basePrice >= INF) {
            return INF;
        }
       return round($basePrice * self::TAX, 2);
    }


    public function getCurrentDay(): array
    {
        return getdate();
    }

}


