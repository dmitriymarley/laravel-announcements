<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement;

use App\Events\NewAnnouncement;

/**
 * Class Announce
 *
 * @package DmitriyMarley\Announcement
 */
class Announce
{
    /**
     * Create new announcement.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int    $ttl
     *
     * @return void
     */
    public static function create($title = '', $message = '', $type = 'info', $ttl = 60): void
    {
        $announcement = new Announcement($title, $message, $type, $ttl);
        $announcement->save();
    }

    /**
     * display the announcement.
     *
     * @return [type]
     */
    public static function display()
    {
        $announcements = Announcement::all();

        return view('announcement::alert', compact('announcements'))->render();
    }

    /**
     * [broadcast description].
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int    $ttl
     * @param string $transition
     * @param [type] $channel_name
     *
     * @return [type]
     */
    public static function broadcast($title = '', $message = '', $type = 'info', $ttl = 60, $transition = 'fade', $channel_name = null)
    {
        $channel = $channel_name ?? config('announcement.broadcasting_channel');

        $ttl = $ttl * 1000;

        self::create($title, $message, $type, $ttl);

        event(new NewAnnouncement($title, $message, $type, $ttl, $transition, $channel));
    }
}
