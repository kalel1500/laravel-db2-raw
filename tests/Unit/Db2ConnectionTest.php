<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thehouseofel\DB2Raw\Db2Connection;
use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\FakeDb2Driver;

class Db2ConnectionTest extends TestCase
{
    public function test_exec_returns_clean_fields()
    {
        $driver = new FakeDb2Driver();
        $driver->setRows([
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ]);

        $config = new Db2Config('h', 'p', 'db', 'u', 'pw');
        $conn   = new Db2Connection($config, $driver);

        $out = $conn->exec("SELECT * FROM USERS");

        $this->assertCount(2, $out);
        $this->assertEquals([
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Smith'],
        ], $out);

        // opcional: comprobar que exec fue llamado con la query
        $this->assertSame(['SELECT * FROM USERS'], $driver->queries);
    }

    public function test_exec_handles_empty_result()
    {
        $driver = new FakeDb2Driver();
        $config = new Db2Config('h', 'p', 'db', 'u', 'pw');
        $db2 = new Db2Connection($config, $driver);

        $result = $db2->exec('SELECT * FROM EMPTY', ['ID']);
        $this->assertSame([], $result);
    }

    public function test_exec_throws_on_failed_connection()
    {
        $driver = new FakeDb2Driver();
        $driver->connected = false;

        $config = new Db2Config('h','p','db','u','pw');
        $conn   = new Db2Connection($config, $driver);

        $this->expectException(\RuntimeException::class);
        $conn->exec('SELECT 1', []);
    }
}
