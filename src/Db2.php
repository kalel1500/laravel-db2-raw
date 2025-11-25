<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

class Db2
{
    public function __construct(
        protected Db2Driver $driver,
        protected Db2Config $config,
    )
    {
    }

    protected function startConnection()
    {
        $conn = $this->driver->connect($this->config);
        if ($conn === false || $conn === null) {
            throw new \RuntimeException('Could not connect to DB2');
        }
        return $conn;
    }

    protected function closeConnection($connection): void
    {
        $this->driver->close($connection);
    }

    /**
     * Ejecuta una query y devuelve array de filas con las keys indicadas en $fields.
     */
    public function exec(string $query, array $fields): array
    {
        $connection = $this->startConnection();
        $result = $this->driver->exec($connection, $query);

        $data = [];
        while ($row = $this->driver->fetchAssoc($result)) {
            $rowData = [];
            foreach ($fields as $field) {
                $rowData[$field] = $row[$field] ?? null;
            }
            $data[] = $rowData;
        }

        $this->closeConnection($connection);
        return $data;
    }
}
