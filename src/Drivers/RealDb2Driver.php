<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Drivers;

use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

final class RealDb2Driver implements Db2Driver
{
    public function connect(Db2Config $config)
    {
        // usa el connection string generado por Db2Config
        return \db2_connect($config->toConnectionString(), '', '');
    }

    public function exec($connection, string $query)
    {
        return \db2_exec($connection, $query);
    }

    public function fetchAssoc($result)
    {
        return \db2_fetch_assoc($result);
    }

    public function close($connection): void
    {
        \db2_close($connection);
    }
}
