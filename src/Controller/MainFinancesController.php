<?php


namespace App\Controller;

use App\Domain\MainFinance;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainFinancesController
{


    /**
     * @Route("/time", methods={"GET"})
     */
    public function timeEndpoint(): Response
    {
        return new Response((new MainFinance())->today(),Response::HTTP_OK);
    }

    /**
     * @Route("/vat", methods={"GET"})
     */
    public function vatEndpoint(): Response
    {
        $tax = "";
        $response =  ' VAT: ' . (new MainFinance())->VAT(400, $tax) .  ' Tax: ' . $tax;
        return new Response($response,Response::HTTP_OK);
    }

    /**
     * @Route("/{uri}",name="", requirements={"uri"=".+"})
     */
    public function defaultEndpoint(): Response
    {
        return new Response('Hello!',Response::HTTP_OK);
    }
}