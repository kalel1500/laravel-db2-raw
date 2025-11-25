<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests\Feature;

use Thehouseofel\DB2Raw\Db2;
use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;
use Thehouseofel\DB2Raw\Facades\Db2 as Db2Facade;
use Thehouseofel\DB2Raw\Tests\TestCase;

class Db2Test extends TestCase
{
    public function test_exec_calls_driver_methods()
    {
        // 1️⃣ Creamos un mock del driver
        $driver = \Mockery::mock(Db2Driver::class);

        // 2️⃣ Definimos expectativas de llamada
        $driver->shouldReceive('connect')->once()->andReturn('conn');
        $driver->shouldReceive('exec')->once()->with('conn', 'q')->andReturn('result');
        $driver->shouldReceive('fetchAssoc')->andReturn(
            ['ID' => 1, 'NAME' => 'A'],
            ['ID' => 2, 'NAME' => 'B'],
            false
        );
        $driver->shouldReceive('close')->once()->with('conn');

        // 3️⃣ Creamos una config dummy
        $config = new Db2Config('h', 'p', 'd', 'u', 'pw');

        // 4️⃣ Instanciamos Db2 con el mock
        $db2 = new Db2($driver, $config);

        // 5️⃣ Ejecutamos la consulta
        $out = $db2->exec('q', ['ID', 'NAME']);

        // 6️⃣ Comprobamos el resultado
        $this->assertCount(2, $out);
        $this->assertEquals([
            ['ID' => 1, 'NAME' => 'A'],
            ['ID' => 2, 'NAME' => 'B']
        ], $out);

        \Mockery::close();
    }

    public function test_exec_throws_when_cannot_connect()
    {
        // 1️⃣ Mock del driver que simula fallo al conectar
        $driver = \Mockery::mock(Db2Driver::class);
        $driver->shouldReceive('connect')->once()->andReturn(false);

        // 2️⃣ Config dummy
        $config = new Db2Config('h', 'p', 'd', 'u', 'pw');

        // 3️⃣ Instancia de Db2
        $db2 = new Db2($driver, $config);

        // 4️⃣ Esperamos excepción
        $this->expectException(\RuntimeException::class);

        $db2->exec('SELECT 1', []);
    }

    public function test_it_executes_query_through_facade()
    {
        $result = Db2Facade::exec('SELECT * FROM USERS', ['ID', 'NAME']);

        $this->assertEquals([
            ['ID' => 5, 'NAME' => 'Alice'],
            ['ID' => 6, 'NAME' => 'Bob'],
        ], $result);
    }

    public function test_it_can_resolve_db2_from_container()
    {
        $instance = $this->app->make(Db2::class);

        $this->assertInstanceOf(Db2::class, $instance);
    }
}
