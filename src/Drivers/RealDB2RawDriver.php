<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Drivers;

use Thehouseofel\DB2Raw\Drivers\Contracts\DB2RawDriver;

final class RealDB2RawDriver implements DB2RawDriver
{
    public function connect(string $connectionString)
    {
        return \db2_connect($connectionString, '', '');
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
