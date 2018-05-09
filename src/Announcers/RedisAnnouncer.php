<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Announcers;

use Carbon\Carbon;
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
     * Get all announcements from storage.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $keys = Redis::keys("{$this->keyPrefix}:*");

        $announcements = \collect();

        foreach ($keys as $key) {
            $data = \json_decode(Redis::get($key), \true);
            $announcements->push($this->generateAnnouncement($data));
        }

        return $announcements;
    }

    /**
     * Get single announcement by key.
     *
     * @param string|integer $key
     *
     * @return \stdClass
     */
    public function get($key): \stdClass
    {
        $data = \json_decode(Redis::get($key), \true);

        return $this->generateAnnouncement($data);
    }

    /**
     * Create new announcement
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int $minutes
     *
     * @return \stdClass
     */
    public function create(string $title, string $message, string $type, int $minutes): \stdClass
    {
        $key = $this->generateUniqueKey();

        $seconds = $minutes * 60;

        $data = [
            'key'        => $key,
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
            'expires_at' => Carbon::now()->addSeconds($seconds)->toDateTimeString(),
        ];

        Redis::set($key, \json_encode($data));
        Redis::expire($key, $seconds);

        return $this->generateAnnouncement($data);
    }

    public function update(string $key, string $title, string $message, string $type, ?int $minutes = null): \stdClass
    {
        $announcement = \json_decode(Redis::get($key), \true);

        $data = [
            'key'        => $key,
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
            'expires_at' => $announcement['expires_at'],
        ];

        if (null !== $minutes) {
            $seconds = $minutes * 60;
            $data['expires_at'] = Carbon::now()->addSeconds($seconds)->toDateTimeString();
            Redis::expire($key, $seconds);
        }

        Redis::set($key, \json_encode($data));

        return $this->generateAnnouncement($data);
    }

    public function delete()
    {
        //
    }

    /**
     * Generate full key by combining prefix, title and type
     * of announcement.
     *
     * @return string
     */
    protected function generateUniqueKey(): string
    {
        $hash = \encrypt(\time());

        return "{$this->keyPrefix}:{$hash}";
    }

    /**
     * @param array $data
     *
     * @return \stdClass
     */
    protected function generateAnnouncement(array $data): \stdClass
    {
        return (object)[
            'key'        => $data['key'],
            'title'      => $data['title'],
            'type'       => $data['type'],
            'message'    => $data['message'],
            'expires_at' => $data['expires_at'],
        ];
    }
}
