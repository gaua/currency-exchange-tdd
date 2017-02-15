<?php declare(strict_types = 1);

namespace Test;

use Gaua\CurrencyCode;

class CurrencyCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsValidCurrencyCode()
    {
        $currencyCode = new \Gaua\CurrencyCode('USD');

        $this->assertEquals('USD', $currencyCode->getValue());
        $this->assertInternalType('string', $currencyCode->getValue());
    }

    public function testThrowExceptionWhenCurrencyCodeIsNotSupported()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency code not supported!');

        new \Gaua\CurrencyCode('FOOBAR');
    }

    public function testSupportedCurrencyCodes()
    {
        $expected = ['PLN', 'USD', 'EUR'];
        $actual = CurrencyCode::getSupportedCurrencies();

        sort($expected); sort($actual);

        $this->assertEquals($expected, $actual);
    }
}