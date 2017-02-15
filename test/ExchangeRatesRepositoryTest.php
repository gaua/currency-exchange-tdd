<?php declare(strict_types = 1);

namespace Test;

use Gaua\ExchangeRatesRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ExchangeRatesRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client | \PHPUnit_Framework_MockObject_MockObject */
    private $clientMock;

    public function testRepositoryReturnsExchangeRate()
    {
        $this->prepareClientMockForReturnsExchangeRateTest();

        $repository = new ExchangeRatesRepository($this->clientMock);
        $rate = $repository->getExchangeRate(
            new \Gaua\CurrencyCode('PLN'),
            new \Gaua\CurrencyCode('USD'),
            date('Y-m-d')
        );

        $this->assertEquals(1.23, $rate);
    }

    private function prepareClientMockForReturnsExchangeRateTest()
    {
        $responseMock = $this->getMockBuilder(Response::class)
            ->getMock();

        $responseMock->expects($this->once())
            ->method('getBody')
            ->willReturn('{"rates": {"USD": 1.23}}');

        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);

        $this->clientMock = $clientMock;
    }

    public function testRepositoryThrowsHttpException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Something wrong with request to external service!');

        $this->prepareClientMockForThrowsHttpExceptionTest();

        $repository = new ExchangeRatesRepository($this->clientMock);
        $repository->getExchangeRate(
            new \Gaua\CurrencyCode('PLN'),
            new \Gaua\CurrencyCode('USD'),
            date('Y-m-d')
        );
    }

    private function prepareClientMockForThrowsHttpExceptionTest()
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->expects($this->once())
            ->method('request')
            ->willThrowException(new RequestException('foo', new Request('', '')));

        $this->clientMock = $clientMock;
    }
}