<?php
declare(strict_types=1);

namespace App\Utils;

use App\Entity\Cache\CacheDtoInterface;
use JMS\Serializer\SerializerBuilder;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisUtils
{
    private array $redisConfig;

    private $client;

    public function __construct($redisConfig)
    {
        $this->redisConfig = $redisConfig;
        ['dsn' => $dsn, 'options' => $options] = $this->redisConfig;
        $this->client = RedisAdapter::createConnection($dsn, $options);
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $class
     * @return RedisQuery
     * @throws ReflectionException
     */
    public function getCacheQuery(string $class): RedisQuery
    {
        $reflection = new ReflectionClass($class);
        if (!$reflection->implementsInterface(CacheDtoInterface::class)) {
            throw new ReflectionException();
        }
        return new RedisQuery($this->client, $class);
    }

    /**
     * save object cache
     * @param CacheDtoInterface $cache
     * @param int $ttl
     * @return bool
     */
    public function setObject(CacheDtoInterface $cache, $ttl = 0): bool
    {
        $serializer = SerializerBuilder::create()->build();
        $data = $serializer->serialize($cache, 'json');
        $key = $cache->getCacheKey();

        if ($ttl > 0) {
            return $this->client->setex($key, $ttl, $data);
        }

        return $this->client->set($key, $data);
    }

    /**
     * @param CacheDtoInterface $cache
     * @return int
     */
    public function delObject(CacheDtoInterface $cache): int
    {
        $key = $cache->getCacheKey();
        return $this->client->del($key);
    }
}
