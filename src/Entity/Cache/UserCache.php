<?php
declare(strict_types=1);

namespace App\Entity\Cache;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

class UserCache extends AbstractCacheDto
{
    /**
     * @Serializer\Exclude
     */
    protected string $cacheKey="user_info_%s";


    /**
     * @Serializer\Type("array<string>")
     */
    public array $tokens;

    public string $id;

    public string $parent_id;

    public int $status;

    public string $phone;

    public string $score;

    public int $identity;

    public string $promotionCode;

    public string $promotionRevenue;

    public int $promotionPeople;

    public Datetime $loginDate;

    public function __construct(string $userId)
    {
        $this->setCacheKey($userId);
    }
}
