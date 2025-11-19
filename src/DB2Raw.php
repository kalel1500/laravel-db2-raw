<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Thehouseofel\DB2Raw\Drivers\Contracts\DB2RawDriver;

class DB2Raw
{
    protected DB2RawConfig $config;
    protected ?string $connection = null;

    public function __construct(protected DB2RawDriver $driver)
    {
        $conf = app()->bound('config');
        $this->config = $conf ? DB2RawConfig::fromLaravelConfig($connection) : DB2RawConfig::empty();
    }

    public function connection($name): DB2Raw
    {
        $this->connection = $name;
        return $this;
    }

    protected function startConnection()
    {
        $conn = $this->driver->connect($this->config->toConnectionString());
        if (! $conn) {
            throw new \RuntimeException('Failed to connect to DB2');
        }
        return $conn;
    }

    protected function closeConnection($connection): void
    {
        $this->driver->close($connection);
    }

    public function exec(string $query, array $fields): array
    {
        $conn   = $this->startConnection();
        $result = $this->driver->exec($conn, $query);
        $data   = [];

        while ($row = $this->driver->fetchAssoc($result)) {
            $rowData = [];
            foreach ($fields as $field) {
                $rowData[$field] = $row[$field] ?? null;
            }
            $data[] = $rowData;
        }

        $this->closeConnection($conn);
        return $data;
    }
}
