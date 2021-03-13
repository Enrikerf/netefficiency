<?php


namespace App\Adapter\in\Api\Controller;


use App\Application\Port\in\CalculatePriceUseCase\CalculatePriceCommand;
use App\Application\Port\in\CalculatePriceUseCase\CalculatePriceUseCase;
use App\Application\Port\in\GetToday\GetTodayQuery;
use App\Domain\Price;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainFinancesController
{


    private const VAT_STRING = ' VAT: ';
    private const TAX_STRING = ' Tax: ';
    private const HELLO_STRING = "Hello!";
    private const FIXED_BASE_PRICE = 400;
    /**
     * @Route("/time", methods={"GET"})
     * @param GetTodayQuery $getTodayQuery
     * @return Response
     */
    public function timeEndpoint(GetTodayQuery $getTodayQuery): Response
    {
        return new Response($getTodayQuery->getToday(),Response::HTTP_OK);
    }

    /**
     * @Route("/vat", methods={"GET"})
     * @param CalculatePriceUseCase $calculatePrice
     * @return Response
     */
    public function vatEndpoint(CalculatePriceUseCase $calculatePrice): Response
    {
        $price = $calculatePrice->calculate(new CalculatePriceCommand(self::FIXED_BASE_PRICE));

        return new Response($this->generatePriceView($price),Response::HTTP_OK);
    }

    /**
     * @Route("/{uri}",name="", requirements={"uri"=".+"})
     */
    public function defaultEndpoint(): Response
    {
        return new Response(self::HELLO_STRING,Response::HTTP_OK);
    }

    private function generatePriceView(Price $price):string{
        return self::VAT_STRING  . $price->getTotalPrice() .  self::TAX_STRING . $price->getVat();
    }
}