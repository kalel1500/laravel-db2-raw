<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Illuminate\Support\ServiceProvider;
use Thehouseofel\DB2Raw\Drivers\Contracts\DB2RawDriver;
use Thehouseofel\DB2Raw\Drivers\RealDB2RawDriver;

class DB2RawServiceProvider extends ServiceProvider
{
    public array $singletons = [
        'thehouseofel.db2raw.db2raw' => DB2Raw::class,
        DB2RawDriver::class          => RealDB2RawDriver::class,
    ];

    public function register(): void
    {
        if (! defined('DB2RAW_PATH')) {
            define('DB2RAW_PATH', realpath(__DIR__ . '/../'));
        }

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(DB2RAW_PATH . '/config/db2_raw.php', 'db2_raw');
        }

        $this->app->singleton(DB2RawConfig::class, fn() => DB2RawConfig::fromLaravelConfig());
    }

    public function boot(): void
    {
        // kalion.php
        $this->publishes([
            DB2RAW_PATH . '/config/db2_raw.php' => config_path('db2_raw.php'),
        ], 'db2raw');

    }
}
