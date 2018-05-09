<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Announcers;

use DmitriyMarley\Announcement\Contracts\AnnouncerContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

/**
 * Class RedisAnnouncer
 *
 * @package DmitriyMarley\Announcement\Announcers
 */
class RedisAnnouncer implements AnnouncerContract
{
    /**
     * @var string
     */
    private $keyPrefix;

    /**
     * RedisAnnouncer constructor.
     */
    public function __construct()
    {
        $this->keyPrefix = \config('laravel-announcement.redis_key');
    }

    /**
     * Get all announcements from Redis storage.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $keys = Redis::keys("{$this->keyPrefix}:*");

        $announcements = \collect();

        return $announcements;
    }

    public function get()
    {
        // Get single announcement.
    }

    public function create(string $title, string $body, string $type, int $minutes)
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}