<?php


namespace App\Domain;


class Price
{

    private float $basePrice;
    private float $vat;

    public function __construct(float $basePrice, float $vat)
    {
        $this->basePrice =$basePrice;
        $this->vat = $vat;
    }

    public function getTotalPrice(): float
    {
        return $this->basePrice + $this->vat;
    }

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     */
    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     */
    public function setVat(float $vat): void
    {
        $this->vat = $vat;
    }



}