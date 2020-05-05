<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Classes\HttpClient;
use App\Classes\IpApiLocator;
use \App\Classes\Ip;
use PHPUnit\Framework\TestCase;

class IpApiTest extends TestCase
{
    public function testSuccess(): void
    {
        $client = $this->createMock(HttpClient::class);

        $client->method('get')->willReturn(
            json_encode(
                [
                    'country' => 'United States',
                    'regionName' => 'New Jersey',
                    'city' => 'Newark',
                ]
            )
        );

        $locator = new IpApiLocator($client);

        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('New Jersey', $location->getRegion());
        self::assertEquals('Newark', $location->getCity());
    }

    public function testNotFound(): void
    {
        $client = $this->createMock(HttpClient::class);

        $client->method('get')->willReturn(
            json_encode(
                [
                    'country' => '-',
                    'regionName' => '-',
                    'city' => '-',
                ]
            )
        );
        $locator = new IpApiLocator($client);

        $location = $locator->locate(new Ip('127.0.0.1'));

        self::assertNull($location);
    }
}
