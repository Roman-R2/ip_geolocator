<?php
declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Locator;

class IpApiLocator implements Locator
{

    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function locate(Ip $ip): ?Location
    {
        $url = 'http://ip-api.com/json/' . $ip->getValue();

        $response = $this->client->get($url);

        $data = json_decode($response, true);
        $data = array_map(
            function ($value) {
                return $value !== '-' ? $value : null;
            },
            $data
        );

        if (empty($data['country'])){
            return null;
        }

        return new Location($data['country'], $data['regionName'], $data['city']);
    }




}