<?php


namespace App\Application\Port\in\GetToday;


interface GetTodayQuery
{
        public function getToday():string;
}