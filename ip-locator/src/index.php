<?php
declare(strict_types=1);

namespace App;

use App\Classes\ChainLocator;
use App\Classes\HttpClient;
use App\Classes\IpApiLocator;
use App\Classes\IpGeoLocationLocator;

$client = new HttpClient();

$locator = new ChainLocator(
    new IpGeoLocationLocator($client, '98330ba2173741718993e7cbe8024f73'),
    new IpApiLocator($client)
);