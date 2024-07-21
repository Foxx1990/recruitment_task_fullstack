<?php
namespace App\Service;

use App\Api\NBPApiClient;
use App\Factory\ExchangeRateFactory;
use App\Validator\DateValidator;

class ExchangeRateService
{
    private $nbpApiClient;
    private $exchangeRateFactory;
    private $dateValidator;

    public function __construct(NBPApiClient $nbpApiClient, ExchangeRateFactory $exchangeRateFactory, DateValidator $dateValidator)
    {
        $this->nbpApiClient = $nbpApiClient;
        $this->exchangeRateFactory = $exchangeRateFactory;
        $this->dateValidator = $dateValidator;
    }

    public function getRatesByDate(string $date): array
    {
        $dateTime = new \DateTime($date);

        if (!$this->dateValidator->validate($dateTime)) {
            throw new \InvalidArgumentException('Invalid date. Date must be between ' . $this->dateValidator->getMinDate()->format('Y-m-d') . ' and ' . $this->dateValidator->getMaxDate()->format('Y-m-d'));
        }

        $currencies = ['USD', 'EUR', 'CZK', 'IDR', 'BRL'];
        $rates = [];

        foreach ($currencies as $currency) {
            $nbpRate = $this->nbpApiClient->getRateByDate($currency, $date);
            $rates[] = $this->exchangeRateFactory->create($currency, $nbpRate);
        }

        return $rates;
    }
}