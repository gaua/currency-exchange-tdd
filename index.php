<?php declare(strict_types = 1);

require_once 'vendor/autoload.php';

$exchangeRepository = new \Gaua\ExchangeRatesRepository(new \GuzzleHttp\Client());
$currencyExchanger = new \Gaua\CurrencyExchanger($exchangeRepository, new \Gaua\DateProvider());

$amount = $currencyExchanger->exchange(
    new \Gaua\Money(100, new \Gaua\CurrencyCode('EUR')),
    new \Gaua\CurrencyCode('PLN')
);
echo "100 EUR = $amount PLN" . nl2br(PHP_EOL);

$amount = $currencyExchanger->exchange(
    new \Gaua\Money(100, new \Gaua\CurrencyCode('USD')),
    new \Gaua\CurrencyCode('PLN')
);
echo "100 USD = $amount PLN";