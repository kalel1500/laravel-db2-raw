<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

class Db2Connection
{
    public function __construct(
        protected Db2Config $config,
        protected Db2Driver $driver,
    )
    {
    }

    public function exec(string $query): array
    {
        $conn = $this->driver->connect($this->config);

        $result = $this->driver->exec($conn, $query);
        $rows   = [];

        while ($row = $this->driver->fetchAssoc($result)) {
            $normalized = [];
            foreach ($row as $key => $value) {
                $normalized[strtolower($key)] = $value;
            }
            $rows[] = $normalized;
        }

        $this->driver->close($conn);

        return $rows;
    }
}
