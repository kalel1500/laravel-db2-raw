<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests;

use Thehouseofel\DB2Raw\DB2Raw;

class DB2RawTest extends TestCase
{
    public function test_exec_returns_expected_data()
    {
        // Simulamos las funciones nativas de DB2
        $mockConnection = 'mock_connection';
        $mockResult = 'mock_result';

        // Sobrescribimos funciones globales
        require_once __DIR__ . '/stubs/db2_functions.php';

        // Ejecutamos la clase real
        $db2 = new DB2Raw();

        $query = 'SELECT * FROM users';
        $fields = ['ID', 'NAME'];

        $result = $db2->exec($query, $fields);

        $this->assertEquals([
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ], $result);
    }
}
