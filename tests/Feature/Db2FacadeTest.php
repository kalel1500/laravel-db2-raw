<?php

declare(strict_types=1);

namespace Feature;

use PHPUnit\Framework\Attributes\Test;
use Thehouseofel\DB2Raw\Facades\Db2 as Db2Facade;
use Thehouseofel\DB2Raw\Tests\TestCase;

class Db2FacadeTest extends TestCase
{
    #[Test]
    public function facade_exec_through_named_connection()
    {
        // Usando la Facade: connection('db2Users')->exec(...)
        $result = Db2Facade::connection('db2Users')->exec('SELECT * FROM users', ['ID','NAME']);

        $this->assertEquals([
            ['ID' => 5, 'NAME' => 'Alice'],
            ['ID' => 6, 'NAME' => 'Bob'],
        ], $result);
    }

    #[Test]
    public function facade_uses_default_connection_when_none_given()
    {
        // default en getEnvironmentSetUp es db2Users, así que Db2::exec() por defecto funciona
        $result = Db2Facade::exec('SELECT * FROM users', ['ID','NAME']);

        $this->assertEquals([
            ['ID' => 5, 'NAME' => 'Alice'],
            ['ID' => 6, 'NAME' => 'Bob'],
        ], $result);
    }
}
