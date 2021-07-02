<?php
declare(strict_types=1);

namespace App\Utils;

use App\Entity\Cache\CacheDtoInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use ReflectionClass;
use ReflectionException;

class RedisQuery
{
    /**
     * @var \Redis|\RedisArray|\RedisCluster|\Predis\ClientInterface $client
     */
    private $client;

    private string $targetClass;

    private Serializer $serializer;


    /**
     * RedisQuery constructor.
     * @param $client
     * @param string $targetClass
     */
    public function __construct($client, string $targetClass)
    {
        $this->client = $client;
        $this->targetClass = $targetClass;
        $this->serializer = SerializerBuilder::create()->build();

    }

    /**
     * @param mixed ...$keys
     * @return object|null
     * @throws ReflectionException
     */
    public function getObject(...$keys): ?object
    {
        $reflection = new ReflectionClass($this->targetClass);
        /**@var CacheDtoInterface $object */
        $object = $reflection->newInstance(...$keys);
        $data = $this->client->get($object->getCacheKey());
        if (!$data) {
            return null;
        }

        $object = $this->serializer->deserialize($data, $this->targetClass, 'json');
        $object->setCacheKey(...$keys);
        return $object;
    }



    /**
     * @param mixed ...$keys
     * @return int
     * @throws ReflectionException
     */
    public function delObject(...$keys): int
    {
        $reflection = new ReflectionClass($this->targetClass);
        /**@var CacheDtoInterface $object */
        $object = $reflection->newInstance(...$keys);
        return $this->client->del($object->getCacheKey());
    }

}
