<?php declare(strict_types = 1);

namespace Gaua;

/** @codeCoverageIgnore */
class Money
{
    /** @var float */
    private $amount;

    /** @var CurrencyCode */
    private $currencyCode;

    public function __construct(float $amount, CurrencyCode $currencyCode)
    {
        $this->amount = $amount;
        $this->currencyCode = $currencyCode;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrencyCode(): CurrencyCode
    {
        return $this->currencyCode;
    }
}