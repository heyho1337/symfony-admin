<?php

// src/Service/CacheService.php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Psr\Log\LoggerInterface;

class CacheService
{
    public function __construct(protected LoggerInterface $logger, protected CacheInterface $cache)
    {
    }

    public function setData($key, $data)
    {
        $cachedData = $this->cache->get($key, function (ItemInterface $item) use ($data) {
            //$item->expiresAfter((int)$_ENV['CACHE']);
            $this->logger->info('Cache miss: Setting data to cache');
            return $data;
        });

        return $cachedData;
    }

    public function cacheKeyGen(string $url)
    {
        return "{$_ENV['SYMFONY_URL']}{$url}?apikey={$_ENV['API_KEY']}";
    }

    public function getData(string $url, callable $callback, bool $isCached = false)
    {
        if ($isCached) {
            $result = $this->cache->get($this->cacheKeyGen($url), $callback);
        } else {
            $result = $callback();
        }
        return $result;
    }
}
