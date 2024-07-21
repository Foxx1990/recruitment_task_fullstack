<?php
namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class NBPApiClient
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getRateByDate(string $currency, string $date): array
    {
        $response = $this->httpClient->request('GET', "https://api.nbp.pl/api/exchangerates/rates/A/{$currency}?/{$date}?format=json");

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to fetch exchange rates from NBP API.');
        }

        return $response->toArray();
    }
}