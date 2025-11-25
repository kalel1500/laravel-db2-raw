<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Illuminate\Support\ServiceProvider;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;
use Thehouseofel\DB2Raw\Drivers\RealDb2Driver;

class Db2ServiceProvider extends ServiceProvider
{
    public array $singletons = [
        'thehouseofel.db2raw.db2' => Db2::class,
        Db2Driver::class          => RealDb2Driver::class,
    ];

    public function register(): void
    {
        if (! defined('DB2RAW_PATH')) {
            define('DB2RAW_PATH', realpath(__DIR__ . '/../'));
        }

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(DB2RAW_PATH . '/config/db2_raw.php', 'db2_raw');
        }

        $this->app->singleton(Db2Config::class, fn() => Db2Config::fromLaravelConfig());
    }

    public function boot(): void
    {
        // kalion.php
        $this->publishes([
            DB2RAW_PATH . '/config/db2_raw.php' => config_path('db2_raw.php'),
        ], 'db2raw');

    }
}
