<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Illuminate\Support\ServiceProvider;

class DB2RawServiceProvider extends ServiceProvider
{
    public array $singletons = [
        'thehouseofel.kalion.redirectAfterLogin'  => DB2Raw::class,
    ];

    public function register(): void
    {
        if (! defined('DB2RAW_PATH')) {
            define('DB2RAW_PATH', realpath(__DIR__ . '/../'));
        }

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(DB2RAW_PATH . '/config/db2_raw.php', 'db2_raw');
        }
    }

    public function boot(): void
    {
        // kalion.php
        $this->publishes([
            DB2RAW_PATH . '/config/db2_raw.php' => config_path('db2_raw.php'),
        ], 'db2raw');

    }
}
