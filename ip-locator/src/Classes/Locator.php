<?php
declare(strict_types=1);

namespace App\Classes;

use http\Exception\RuntimeException;

class Locator
{

    private $client;
    private $apiKey;

    //'apiKey' => '98330ba2173741718993e7cbe8024f73',
    public function __construct(HttpClient $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function locate(Ip $ip): ?Location
    {
        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query(
                [
                    'apiKey' => $this->apiKey,
                    'ip' => $ip->getValue(),
                ]
            );

        $response = $this->client->get($url);

        $data = json_decode($response, true);
        $data = array_map(
            function ($value) {
                return $value !== '-' ? $value : null;
            },
            $data
        );

        if (empty($data['country_name'])){
            return null;
        }

        return new Location($data['country_name'], $data['state_prov'], $data['city']);
    }




}