<?php
declare(strict_types = 1);

namespace DmitriyMarley\Announcement;

use DmitriyMarley\Announcement\Contracts\Announcer;
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
        $this->loadViewsFrom(__DIR__ . '/../views', self::PACKAGE_NAME);

        // Publish your config
        $this->publishes([
            __DIR__ . '/../config/config.php'                               => config_path(self::PACKAGE_NAME . '.php'),
            __DIR__ . '/../resources/views/alert.blade.php'                 => resource_path('views/vendor/' . self::PACKAGE_NAME . '/alert.blade.php'),
            __DIR__ . '/../resources/assets/js/components/Announcement.vue' => resource_path('assets/js/components/Announcement.vue'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', self::PACKAGE_NAME);

        $this->app->bind(Announcer::class, function () {
            $driver = $this->getDriver();
            $class = "DmitriyMarley\\Announcement\\Announcers\\{$driver}Announcer";

            return new $class;
        });
    }

    /**
     * @return string
     */
    protected function getDriver(): string
    {
        return \ucfirst(\config('laravel-announcement.driver'));
    }
}
