<?php
namespace App\Controller;

use App\Service\ExchangeRateService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExchangeRateController extends AbstractController
{
    private $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    /**
     * @Route("/api/exchange-rates/{date}", name="get_exchange_rates", methods={"GET"})
     */
    public function getExchangeRates(Request $request, $date): JsonResponse
    {
        $rates = $this->exchangeRateService->getRatesByDate($date);
        return new JsonResponse($rates);
    }
}