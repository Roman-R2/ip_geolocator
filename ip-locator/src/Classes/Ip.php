<?php

declare(strict_types=1);

namespace App\Classes;

use http\Exception\InvalidArgumentException;

class Ip
{
    private $value;

    public function __construct(string $ip)
    {
        if (empty($ip)) {
            throw new InvalidArgumentException('Empty Ip');
        }
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new InvalidArgumentException('Invalid Ip' . $ip);
        }

        $this->value = $ip;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}