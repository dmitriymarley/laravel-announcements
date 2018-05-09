<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface AnnouncerContract
 *
 * @package DmitriyMarley\Announcement\Contracts
 */
interface AnnouncerContract
{
    /**
     * Get all announcements from storage.
     *
     * @return Collection
     */
    public function all(): Collection ;

    /**
     * Get single announcement by key.
     *
     * @param string|integer $key
     *
     * @return \stdClass
     */
    public function get($key): \stdClass ;

    /**
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int $minutes
     *
     * @return array
     */
    public function create(string $title, string $message, string $type, int $minutes);

    public function update(string $key, string $title, string $message, string $type, int $minutes);

    public function delete();
}