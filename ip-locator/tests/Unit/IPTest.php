<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use \App\Classes\IpGeoLocationLocator;
use \App\Classes\Ip;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IPTest extends TestCase
{

    public function testIp4(): void
    {
        $ip = new Ip($value ='8.8.8.8');
        self:self::assertEquals($value, $ip->getValue());
    }

    public function testIp6(): void
    {
        $ip = new Ip($value ='8:8:8:8:8:8:8:8');
        self:self::assertEquals($value, $ip->getValue());
    }

    public function testInvalid() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Ip ('incorrect');
    }

    public function testEmpty() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Ip ('');
    }
}
