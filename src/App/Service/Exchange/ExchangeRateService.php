<?php
namespace App\Service;

use App\Api\NBPApiClient;
use App\Factory\ExchangeRateFactory;

class ExchangeRateService
{
    private $nbpApiClient;
    private $exchangeRateFactory;

    public function __construct(NBPApiClient $nbpApiClient, ExchangeRateFactory $exchangeRateFactory)
    {
        $this->nbpApiClient = $nbpApiClient;
        $this->exchangeRateFactory = $exchangeRateFactory;
    }

    public function getRatesByDate(string $date): array
    {
        $currencies = ['USD', 'EUR', 'CZK', 'IDR', 'BRL'];
        $rates = [];

        foreach ($currencies as $currency) {
            $nbpRate = $this->nbpApiClient->getRateByDate($currency, $date);
            $rates[] = $this->exchangeRateFactory->create($currency, $nbpRate);
        }

        return $rates;
    }
}