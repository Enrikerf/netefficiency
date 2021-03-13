<?php


namespace App\Application\Service;



use App\Application\Port\in\CalculatePriceUseCase\CalculatePriceCommand;
use App\Application\Port\in\CalculatePriceUseCase\CalculatePriceUseCase;
use App\Domain\MainFinance;
use App\Domain\Price;

class CalculatePrice implements CalculatePriceUseCase
{
    private MainFinance $mainFinance;

    public function __construct()
    {
        $this->mainFinance = new MainFinance();
    }

    public function calculate(CalculatePriceCommand $calculatePriceCommand): Price
    {
        $tax = 0;
        $this->mainFinance->VAT($calculatePriceCommand->getBasePrice(),$tax);
        return new Price($calculatePriceCommand->getBasePrice(),$tax);
    }
}