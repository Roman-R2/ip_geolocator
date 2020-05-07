<?php

declare(strict_types=1);

namespace App\Classes;


use App\Interfaces\Locator;

class CacheLocator implements Locator
{
    private $next;
    private $cache;
    private $ttl;
    private $serviceId;

    public function __construct(Locator $next, Cache $cache, string $serviceId, int $ttl)
    {
        $this->next = $next;
        $this->cache = $cache;
        $this->ttl = $ttl;
        $this->serviceId = $serviceId;
    }

    public function locate(Ip $ip): ?Location
    {
        $key = 'location-' . $ip->getValue();
        $location = $this->cache->get($key);

        if ($location === null) {
            $location = $this->next->locate($ip);
            $this->cache->set($key, $ip->getValue(), $this->serviceId, $this->ttl);
        }

        return $location;
    }
}