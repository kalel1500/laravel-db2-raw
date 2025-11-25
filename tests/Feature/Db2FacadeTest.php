<?php

declare(strict_types=1);

namespace Feature;

use Thehouseofel\DB2Raw\Facades\Db2 as Db2Facade;
use Thehouseofel\DB2Raw\Tests\TestCase;

class Db2FacadeTest extends TestCase
{
    public function test_it_executes_query_through_facade()
    {
        $result = Db2Facade::exec('SELECT * FROM USERS', ['ID', 'NAME']);

        $this->assertEquals([
            ['ID' => 5, 'NAME' => 'Alice'],
            ['ID' => 6, 'NAME' => 'Bob'],
        ], $result);
    }
}
