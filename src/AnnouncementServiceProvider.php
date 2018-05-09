<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement;

use Illuminate\Support\ServiceProvider;

/**
 * Class AnnouncementServiceProvider
 *
 * @package DmitriyMarley\Announcement
 */
class AnnouncementServiceProvider extends ServiceProvider
{
    private const PACKAGE_NAME = 'laravel-announcement';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register Views from your package
        $this->loadViewsFrom(__DIR__.'/../views', self::PACKAGE_NAME);

        // Publish your config
        $this->publishes([
            __DIR__.'/../config/config.php'                      => config_path(self::PACKAGE_NAME.'.php'),
            __DIR__.'/../views/alert.blade.php'                  => resource_path('views/vendor/'.self::PACKAGE_NAME.'/alert.blade.php'),
            __DIR__.'/../Events/NewAnnouncement.php'             => app_path('Events/NewAnnouncement.php'),
            __DIR__.'/../components/Announcement-bootstrap.vue'  => resource_path('assets/js/components/Announcement-bootstrap.vue'),
            __DIR__.'/../components/Announcement-sweetalert.vue' => resource_path('assets/js/components/Announcement-sweetalert.vue'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', self::PACKAGE_NAME);

        $this->app->bind('announce', function () {
            return new Announce;
        });
    }
}
