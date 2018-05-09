<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Contracts;

/**
 * Interface AnnouncerContract
 *
 * @package DmitriyMarley\Announcement\Contracts
 */
interface AnnouncerContract
{
    public function all();
    public function get();
    public function create(string $title, string $body, string $type, int $minutes);
    public function update();
    public function delete();
}