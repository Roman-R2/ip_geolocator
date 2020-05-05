<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Classes\Ip;
use App\Classes\Location;

interface Locator
{
    public function locate(Ip $ip): ?Location;
}