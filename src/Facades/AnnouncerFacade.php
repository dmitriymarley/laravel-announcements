<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Announce
 *
 * @package DmitriyMarley\Announcement\Facades
 */
class AnnouncerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Announcer';
    }
}
