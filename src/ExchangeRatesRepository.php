<?php declare(strict_types = 1);

namespace Gaua;

use GuzzleHttp\Exception\RequestException;

class ExchangeRatesRepository
{
    const BASE_URL = 'http://api.fixer.io/';
    const BASE_METHOD = 'GET';

    /** @var  \GuzzleHttp\Client */
    protected $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    public function getExchangeRate(CurrencyCode $from, CurrencyCode $to, string $date): float
    {
        try {
            $response = $this->client->request(
                self::BASE_METHOD,
                self::BASE_URL . $date,
                [
                    'query' => [
                        'base' => $from->getValue(),
                        'symbols' => $to->getValue()
                    ]
                ]
            );
        } catch(RequestException $e) {
            throw new \Exception('Something wrong with request to external service!');
        }

        $result = json_decode((string)$response->getBody());

        return $result->rates->{$to->getValue()};
    }
}