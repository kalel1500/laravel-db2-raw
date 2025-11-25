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

    /**
     * Ejecuta una query y devuelve array de filas con las keys indicadas en $fields.
     */
    public function exec(string $query, array $fields): array
    {
        $conn = $this->driver->connect($this->config);

        if (!$conn) {
            throw new \RuntimeException("Failed connecting to DB2.");
        }

        $result = $this->driver->exec($conn, $query);
        $rows   = [];

        while ($row = $this->driver->fetchAssoc($result)) {
            $clean = [];
            foreach ($fields as $field) {
                $clean[$field] = $row[$field];
            }
            $rows[] = $clean;
        }

        $this->driver->close($conn);

        return $rows;
    }
}
