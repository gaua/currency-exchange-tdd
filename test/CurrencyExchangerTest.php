<?php declare(strict_types = 1);

namespace Test;

use Gaua\CurrencyCode;
use Gaua\CurrencyExchanger;
use Gaua\DateProvider;
use Gaua\ExchangeRatesRepository;
use Gaua\Money;
use Gaua\Rounder;

class CurrencyExchangerTest extends \PHPUnit_Framework_TestCase
{
    const DATE = '2017-02-15';
    const TO_CURRENCY = 'PLN';
    const FROM_CURRENCY = 'USD';

    /** @var ExchangeRatesRepository | \PHPUnit_Framework_MockObject_MockObject */
    private $rateRepositoryMock;

    /** @var DateProvider | \PHPUnit_Framework_MockObject_MockObject*/
    private $dateProviderMock;

    public function setUp()
    {
        $dateProviderMock = $this->getMockBuilder(DateProvider::class)->getMock();
        $rateRepositoryMock = $this->getMockBuilder(ExchangeRatesRepository::class)
            ->disableOriginalConstructor()->getMock();

        $dateProviderMock->expects($this->once())
            ->method('getCurrentDate')
            ->willReturn(self::DATE);
        $this->dateProviderMock = $dateProviderMock;
        $rateRepositoryMock->expects($this->once())
            ->method('getExchangeRate')
            ->with(
                new CurrencyCode(self::FROM_CURRENCY),
                new CurrencyCode(self::TO_CURRENCY),
                self::DATE
            )
            ->willReturn(1.23);
        $this->rateRepositoryMock = $rateRepositoryMock;
    }

    public function testExchangeRoundsDown()
    {

        $currencyExchanger = new CurrencyExchanger(
            $this->rateRepositoryMock,
            new Rounder(),
            $this->dateProviderMock
        );

        $amount = $currencyExchanger->exchange(
            new Money(1.23, new CurrencyCode(self::FROM_CURRENCY)),
            new CurrencyCode(self::TO_CURRENCY),
            CurrencyExchanger::ROUND_DOWN
        );

        $this->assertSame(1.51, $amount);
    }

    public function testExchangeRoundUp()
    {
        $currencyExchanger = new CurrencyExchanger(
            $this->rateRepositoryMock,
            new Rounder(),
            $this->dateProviderMock
        );

        $amount = $currencyExchanger->exchange(
            new Money(1.23, new CurrencyCode(self::FROM_CURRENCY)),
            new CurrencyCode(self::TO_CURRENCY)
        );

        $this->assertSame(1.52, $amount);
    }

}