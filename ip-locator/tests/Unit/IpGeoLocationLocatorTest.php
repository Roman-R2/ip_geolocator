<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Classes\HttpClient;
use \App\Classes\IpGeoLocationLocator;
use \App\Classes\Ip;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IpGeoLocationLocatorTest extends TestCase
{
    public function testSuccess(): void
    {
        $client = $this->createMock(HttpClient::class);

        $client->method('get')->willReturn(
            json_encode(
                [
                    'country_name' => 'United States',
                    'state_prov' => 'California',
                    'city' => 'Mountain View',
                ]
            )
        );

        $locator = new IpGeoLocationLocator($client, 'fakeApiKey');

        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('California', $location->getRegion());
        self::assertEquals('Mountain View', $location->getCity());
    }

    public function testNotFound(): void
    {
        $client = $this->createMock(HttpClient::class);

        $client->method('get')->willReturn(
            json_encode(
                [
                    'country_name' => '-',
                    'state_prov' => '-',
                    'city' => '-',
                ]
            )
        );
        $locator = new IpGeoLocationLocator($client, 'fakeApiKey');

        $location = $locator->locate(new Ip('127.0.0.1'));

        self::assertNull($location);
    }
}
