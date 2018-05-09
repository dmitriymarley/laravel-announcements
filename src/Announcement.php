<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

/**
 * Class Announcement
 *
 * @package DmitriyMarley\Announcement
 */
class Announcement
{
    /**
     * Type of the announcement. For example: success,info,danger,warning (or anything you would like to use).
     *
     * @var string
     */
    public $type;

    /**
     * It should be a short message, that what is the message about. For example: Breaking news!
     *
     * @var string
     */
    public $title;

    /**
     * A bit longer message that what is the situation.
     * For example: Our servers are under a DDoS attack. We are trying hard to mitigate it.
     *
     * @var string
     */
    public $message;

    /**
     * When should the announcement expire. [Time to live] in seconds.
     *
     * @var integer
     */
    public $ttl;

    /**
     * Announcement constructor.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int    $ttl
     */
    public function __construct(string $title, string $message, string $type, int $ttl)
    {
        $this->title   = $title;
        $this->message = $message;
        $this->type    = $type;
        $this->ttl     = $ttl;
    }

    /**
     * @return void
     */
    public function save(): void
    {
        $key = $this->key();
        Redis::set($key, $this->message);
        Redis::expire($key, $this->ttl);
    }

    /**
     * @return string
     */
    public function key(): string
    {
        $key = config('announcement.redis_key');

        return "{$key}:{$this->type}:{$this->title}";
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return Redis::ttl($this->key());
    }

    /**
     * @param $seconds
     *
     * @return mixed
     */
    public function setTtl($seconds)
    {
        return Redis::expire($this->key(), $seconds);
    }

    /**
     * @return Collection
     */
    public static function all()
    {
        $keys = Redis::keys(config('announcement.redis_key').':*');

        $collection = new Collection();

        if ( ! $keys) {
            return $collection;
        }

        /*
         * 0 - package key
         * 1 - type
         * 2 - title
         */

        foreach ($keys as $key) {
            $key_data     = explode(':', $key, 3);
            $message      = Redis::get($key);
            $ttl          = Redis::ttl($key);
            $announcement = new self($key_data[2], $message, $key_data[1], $ttl);
            $collection->push($announcement);
        }

        $collection->each(function ($item) {
            $item->show = \true;
        });

        return $collection;
    }
}
