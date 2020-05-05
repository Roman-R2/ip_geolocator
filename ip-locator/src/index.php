<?php

declare(strict_types=1);

namespace App;

require '../vendor/autoload.php';

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

$locator = new ChainLocator(
    new MuteLocator(
        new IpApiLocator($client),
        $handler
    ),
    new MuteLocator(
        new IpGeoLocationLocator($client, '98330ba2173741718993e7cbe8024f73'),
        $handler
    )
);

var_dump($locator->locate(new Ip('8.8.8.8')));