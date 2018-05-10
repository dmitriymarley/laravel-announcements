<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface AnnouncerContract
 *
 * @package DmitriyMarley\Announcement\Contracts
 */
interface Announcer
{
    /**
     * Get all announcements from storage
     *
     * @return Collection
     */
    public function all(): Collection ;

    /**
     * Get single announcement by key. Depending on the driver
     * selected, key is either a redis key or model primary key.
     *
     * @param string|integer $key
     *
     * @return \stdClass
     */
    public function get($key);

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
    public function create(string $title, string $message, string $type, int $minutes);

    /**
     * Update existing announcement by key. Depending on the driver
     * selected, key is either a redis key or model primary key.
     *
     * @param $key
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int $minutes
     *
     * @return \stdClass
     */
    public function update($key, string $title, string $message, string $type, int $minutes);

    /**
     * Delete existing announcement by key. Depending on the driver
     * selected, key is either a redis key or model primary key.
     *
     * @param $key
     *
     * @return bool
     */
    public function delete($key): bool ;
}