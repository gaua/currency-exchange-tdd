<?php declare(strict_types = 1);

namespace Test;

use Gaua\Rounder;

class RounderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider roundUpDataProvider
     */
    public function testRoundsUp($amount, $expected)
    {
        $rounder = new Rounder();

        $this->assertEquals($expected, $rounder->up($amount));
    }

    /**
     * @dataProvider roundDownDataProvider
     */
    public function testRoundsDown($amount, $expected)
    {
        $rounder = new Rounder();

        $this->assertEquals($expected, $rounder->down($amount));
    }

    public function roundDownDataProvider()
    {
        return[
            [1.220, 1.22],
            [1.221, 1.22],
            [1.225, 1.22],
            [1.229, 1.22],
        ];
    }

    public function roundUpDataProvider()
    {
        return[
            [1.220, 1.22],
            [1.221, 1.23],
            [1.225, 1.23],
            [1.229, 1.23],
        ];
    }
}