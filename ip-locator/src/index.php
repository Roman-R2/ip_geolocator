<?php

declare(strict_types=1);

namespace App;

require '../vendor/autoload.php';

use App\Classes\Cache;
use App\Classes\CacheLocator;
use App\Classes\ChainLocator;
use App\Classes\ErrorHandler;
use App\Classes\HttpClient;
use App\Classes\Ip;
use App\Classes\IpApiLocator;
use App\Classes\IpGeoLocationLocator;
use App\Classes\Logger;
use App\Classes\MuteLocator;

$handler = new ErrorHandler(new Logger());

$client = new HttpClient();
$cache = new Cache();

$locator = new ChainLocator(
    new CacheLocator(
        new MuteLocator(
            new IpApiLocator($client),
            $handler
        ),
        $cache,
        'servise_1',
        3600
    ),
    new CacheLocator(
        new MuteLocator(
            new IpGeoLocationLocator($client, '98330ba2173741718993e7cbe8024f73'),
            $handler
        ),
        $cache,
        'servise_2',
        3600
    )
);

$info = $locator->locate(new Ip('8.8.8.8'));
echo $info->getCountry() . " :: " . $info->getRegion() . " :: " . $info->getCity();