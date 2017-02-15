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

    /** @var Rounder | \PHPUnit_Framework_MockObject_MockObject*/
    private $rounderMock;

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
        $this->prepareRounderMockForRoundsDownTest();

        $currencyExchanger = new CurrencyExchanger(
            $this->rateRepositoryMock,
            $this->rounderMock,
            $this->dateProviderMock
        );

        $amount = $currencyExchanger->exchange(
            new Money(1.23, new CurrencyCode(self::FROM_CURRENCY)),
            new CurrencyCode(self::TO_CURRENCY),
            CurrencyExchanger::ROUND_DOWN
        );

        $this->assertInternalType('float', $amount);
    }

    public function testExchangeRoundUp()
    {
        $this->prepareRounderMockForRoundsUpTest();

        $currencyExchanger = new CurrencyExchanger(
            $this->rateRepositoryMock,
            $this->rounderMock,
            $this->dateProviderMock
        );

        $amount = $currencyExchanger->exchange(
            new Money(1.23, new CurrencyCode(self::FROM_CURRENCY)),
            new CurrencyCode(self::TO_CURRENCY)
        );

        $this->assertInternalType('float', $amount);
    }

    private function prepareRounderMockForRoundsDownTest()
    {
        $rounderMock = $this->getMockBuilder(Rounder::class)->getMock();

        $rounderMock->expects($this->once())
            ->method('down')
            ->willReturn(1.23);
        $rounderMock->expects($this->never())
            ->method('up');

        $this->rounderMock = $rounderMock;
    }

    private function prepareRounderMockForRoundsUpTest()
    {
        $rounderMock = $this->getMockBuilder(Rounder::class)->getMock();

        $rounderMock->expects($this->once())
            ->method('up')
            ->willReturn(1.23);
        $rounderMock->expects($this->never())
            ->method('down');

        $this->rounderMock = $rounderMock;
    }
}