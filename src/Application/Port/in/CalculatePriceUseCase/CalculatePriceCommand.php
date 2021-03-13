<?php


namespace App\Application\Port\in\CalculatePriceUseCase;


class CalculatePriceCommand
{

    private float $basePrice;

    public function __construct(float $basePrice)
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }





}