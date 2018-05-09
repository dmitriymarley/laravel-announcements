<?php
declare(strict_types = 1);

return [
    /*
    |--------------------------------------------------------------------------
    | Announcements driver
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */
    'driver' => env('ANNOUNCEMENT_DRIVER', 'redis'),

    /*
    |--------------------------------------------------------------------------
    | Redis Key
    |--------------------------------------------------------------------------
    |
    | Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
    | tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
    | veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
    | commodo consequat.
    */
    'redis_key' => 'announcements',

    /*
    |--------------------------------------------------------------------------
    | Broadcasting channel
    |--------------------------------------------------------------------------
    |
    | Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
    | tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
    | veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
    | commodo consequat.
    */
    'broadcasting_channel' => env('ANNOUNCEMENTS-CHANNEL', 'public-announcement-channel'),
];
