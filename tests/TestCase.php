<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Thehouseofel\DB2Raw\DB2RawServiceProvider;
use Thehouseofel\DB2Raw\Drivers\Contracts\DB2RawDriver;
use Thehouseofel\DB2Raw\Drivers\FakeDB2RawDriver;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            DB2RawServiceProvider::class,
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
        $this->app->bind(DB2RawDriver::class, function() {
            return new FakeDB2RawDriver([
                ['ID' => 5, 'NAME' => 'Alice'],
                ['ID' => 6, 'NAME' => 'Bob'],
            ]);
        });
    }
}
