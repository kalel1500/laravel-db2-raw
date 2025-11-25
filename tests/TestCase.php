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
            'host' => 'fake-host',
            'port' => '50000',
            'database' => 'fake-db',
            'username' => 'fake-user',
            'password' => 'fake-pass',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Bindear el FakeDriver en vez del RealDriver
        $this->app->bind(Db2Driver::class, function() {
            return new FakeDb2Driver([
                ['ID' => 5, 'NAME' => 'Alice'],
                ['ID' => 6, 'NAME' => 'Bob'],
            ]);
        });
    }
}
