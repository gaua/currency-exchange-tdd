<?php declare(strict_types = 1);

namespace Gaua;

class CurrencyCode
{
    const PLN = 'PLN';
    const EUR = 'EUR';
    const USD = 'USD';

    /** @var string */
    protected $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::getSupportedCurrencies())) {
            throw new \InvalidArgumentException('Currency code not supported!');
        }

        $this->value = $value;
    }

    public static function getSupportedCurrencies() : array
    {
        return [self::PLN, self::EUR, self::USD];
    }

    public function getValue() : string
    {
        return $this->value;
    }
}