<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thehouseofel\DB2Raw\DB2Raw;
use Thehouseofel\DB2Raw\DB2RawConfig;
use Thehouseofel\DB2Raw\Drivers\FakeDB2RawDriver;

class DB2RawTest extends TestCase
{
    public function test_exec_returns_expected_data()
    {
        $driver = new FakeDB2RawDriver([
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ]);
        $config = new DB2RawConfig('host', '50000', 'db', 'user', 'pass');

        $db2 = new DB2Raw($driver, $config);

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
        $driver = new FakeDB2RawDriver([]);
        $config = new DB2RawConfig('host', '50000', 'db', 'user', 'pass');
        $db2 = new DB2Raw($driver, $config);

        $result = $db2->exec('SELECT * FROM EMPTY', ['ID']);
        $this->assertSame([], $result);
    }
}
