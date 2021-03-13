<?php


namespace App\Application\Service;

use App\Application\Port\in\GetToday\GetTodayQuery;
use App\Domain\MainFinance;

class GetToday implements GetTodayQuery
{
    private MainFinance $mainFinance;

    public function __construct()
    {
        $this->mainFinance = new MainFinance();
    }

    public function getToday(): string
    {
        return $this->mainFinance->today();
    }
}