<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thehouseofel\DB2Raw\Db2Connection;
use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\FakeDb2Driver;

class Db2Test extends TestCase
{
    public function test_exec_returns_expected_data()
    {
        $driver = new FakeDb2Driver([
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ]);
        $config = new Db2Config('host', '50000', 'db', 'user', 'pass');

        $db2 = new Db2Connection($driver, $config);

        $result = $db2->exec('SELECT * FROM USERS', ['ID', 'NAME']);

        $this->assertEquals([
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ], $result);

        // opcional: comprobar que exec fue llamado con la query
        $this->assertSame(['SELECT * FROM USERS'], $driver->queries);
    }

    public function test_exec_handles_empty_result()
    {
        $driver = new FakeDb2Driver([]);
        $config = new Db2Config('host', '50000', 'db', 'user', 'pass');
        $db2 = new Db2Connection($driver, $config);

        $result = $db2->exec('SELECT * FROM EMPTY', ['ID']);
        $this->assertSame([], $result);
    }
}
