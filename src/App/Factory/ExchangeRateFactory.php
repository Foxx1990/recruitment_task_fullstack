<?php
namespace App\Factory;

class ExchangeRateFactory
{
    public function create(string $currency, array $nbpRate): array
    {
        $midRate = $nbpRate['rates'][0]['mid'];

        if (in_array($currency, ['USD', 'EUR'])) {
            $buyRate = $midRate - 0.05;
            $sellRate = $midRate + 0.07;
        } else {
            $buyRate = null;
            $sellRate = $midRate + 0.15;
        }

        return [
            'currency' => $currency,
            'name' => $this->getCurrencyName($currency),
            'mid' => $midRate,
            'buy' => $buyRate,
            'sell' => $sellRate,
        ];
    }

    private function getCurrencyName(string $currency): string
    {
        $names = [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'CZK' => 'Czech Koruna',
            'IDR' => 'Indonesian Rupiah',
            'BRL' => 'Brazilian Real',
        ];

        return $names[$currency] ?? 'Unknown';
    }
}