<?php declare(strict_types = 1);

namespace Gaua;

class CurrencyExchanger
{
    const ROUND_UP = 'up';
    const ROUND_DOWN = 'down';

    /** @var ExchangeRatesRepository */
    protected $rateRepository;

    /** @var Rounder */
    protected $rounder;

    /** @var DateProvider */
    protected $dateProvider;

    public function __construct(ExchangeRatesRepository $rateRepository, Rounder $rounder, DateProvider $dateProvider)
    {
        $this->rateRepository = $rateRepository;
        $this->rounder = $rounder;
        $this->dateProvider = $dateProvider;
    }


    public function exchange(Money $money, CurrencyCode $toCurrency, string $roundMode = self::ROUND_UP) : float
    {
        $rate = $this->rateRepository->getExchangeRate(
            $money->getCurrencyCode(),
            $toCurrency,
            $this->dateProvider->getCurrentDate()
        );

        $amount = $money->getAmount() * $rate;

        return $roundMode === self::ROUND_UP ? $this->rounder->up($amount) : $this->rounder->down($amount);
    }
}