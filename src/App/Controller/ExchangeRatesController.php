<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRatesController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getRates($date): JsonResponse
    {
        $currencies = ['EUR', 'USD', 'CZK', 'IDR', 'BRL'];
        $response = [];

        foreach ($currencies as $currency) {
            $url = "http://api.nbp.pl/api/exchangerates/rates/A/{$currency}?/{$date}/?format=json";
            $data = $this->client->request('GET', $url)->toArray();
            $mid = $data['rates'][0]['mid'];

            if (in_array($currency, ['EUR', 'USD'])) {
                $buy = $mid - 0.05;
                $sell = $mid + 0.07;
            } else {
                $buy = null;
                $sell = $mid + 0.15;
            }

            $response[] = [
                'currency' => $currency,
                'name' => $data['currency'],
                'mid' => $mid,
                'buy' => $buy,
                'sell' => $sell,
            ];
        }

        return new JsonResponse($response);
    }
}