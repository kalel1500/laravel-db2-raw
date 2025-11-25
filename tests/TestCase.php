<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Thehouseofel\DB2Raw\Db2ServiceProvider;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;
use Thehouseofel\DB2Raw\Drivers\FakeDb2Driver;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            Db2ServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Configuración de conexión ficticia para testing
        $app['config']->set('db2_raw', [
            'default' => 'main',
            'connections' => [
                'main' => [
                    'host' => 'fake-host',
                    'port' => '50000',
                    'database' => 'fake-db',
                    'username' => 'fake-user',
                    'password' => 'fake-pass',
                ],
                'db2Users' => [
                    'host' => 'fake-host-2',
                    'port' => '50001',
                    'database' => 'fake-db-2',
                    'username' => 'fake-user-2',
                    'password' => 'fake-pass-2',
                ]
            ]
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Bindear el FakeDriver en vez del RealDriver
        $this->app->bind(Db2Driver::class, function() {
            $driver = new FakeDb2Driver();
            $driver->setRows(static::getFakeDriverData());
            return $driver;
        });
    }


    protected static function getFakeDriverData(): array
    {
        return [
            ['ID' => 5, 'NAME' => 'Alice'],
            ['ID' => 6, 'NAME' => 'Bob'],
        ];
    }

}
