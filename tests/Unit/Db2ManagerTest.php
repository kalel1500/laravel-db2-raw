<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thehouseofel\DB2Raw\Db2;
use Thehouseofel\DB2Raw\Db2Manager;
use Thehouseofel\DB2Raw\Drivers\FakeDb2Driver;

class Db2ManagerTest extends TestCase
{
    public function test_connection_returns_db2_instance_for_named_connection()
    {
        $config = [
            'default' => 'db2Main',
            'connections' => [
                'db2Main' => [
                    'host' => 'h1', 'port'=>'50000','database'=>'db1','username'=>'u','password'=>'p'
                ],
                'db2Users' => [
                    'host' => 'h2', 'port'=>'50001','database'=>'db2','username'=>'u2','password'=>'p2'
                ],
            ],
        ];

        $fakeDriver = new FakeDb2Driver([ ['ID'=>1,'NAME'=>'X'] ]);
        $manager = new Db2Manager($config, $fakeDriver);

        $db = $manager->connection('db2Users');

        $this->assertInstanceOf(Db2::class, $db);

        // verificar caching: segunda llamada devuelve misma instancia
        $db2 = $manager->connection('db2Users');
        $this->assertSame($db, $db2);
    }

    public function test_connection_throws_if_missing_connection()
    {
        $this->expectException(\InvalidArgumentException::class);

        $config = [
            'default' => 'db2Main',
            'connections' => [
                'db2Main' => [
                    'host' => 'h1', 'port'=>'50000','database'=>'db1','username'=>'u','password'=>'p'
                ],
            ],
        ];

        $fakeDriver = new FakeDb2Driver([]);
        $manager = new Db2Manager($config, $fakeDriver);

        // nombre erróneo -> excepción
        $manager->connection('no-existe');
    }
}
