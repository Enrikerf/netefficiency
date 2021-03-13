<?php


namespace App\Application\Port\in\CalculatePriceUseCase;


use App\Domain\Price;

interface CalculatePriceUseCase
{
    public function calculate(CalculatePriceCommand $calculatePriceCommand) :Price;
}