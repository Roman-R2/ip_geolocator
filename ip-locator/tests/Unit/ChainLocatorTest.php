<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Classes\ChainLocator;
use \App\Classes\Ip;
use App\Classes\Location;
use App\Interfaces\Locator;
use PHPUnit\Framework\TestCase;

class ChainLocatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $locators = [
            $this->mockLocator(null),
            $this->mockLocator($expected = new Location('Expected_country', 'Expected_region', 'Expected_city')),
            $this->mockLocator(null),
            $this->mockLocator(new Location('Other', null, null)),
            $this->mockLocator(null)
        ];

        $locator = new ChainLocator(...$locators);
        $actual = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($actual);
        self::assertEquals($expected, $actual);
    }

    private function mockLocator(?Location $location): Locator
    {
        $mock = $this->createMock(Locator::class);
        $mock->method('locate')->willReturn($location);
        return $mock;
    }
}
