<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Drivers;

use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

final class FakeDb2Driver implements Db2Driver
{
    protected int   $index     = 0;
    protected array $rows;
    public array    $queries   = [];
    public bool     $connected = true;

    public function connect(Db2Config $config)
    {
        if (!$this->connected) {
            throw new \RuntimeException("Failed connecting to DB2.");
        }

        return 'fake_conn';
    }

    public function exec($connection, string $query)
    {
        $this->queries[] = $query;
        return 'fake_result';
    }

    public function fetchAssoc($result)
    {
        $row = $this->rows[$this->index] ?? false;
        $this->index++;
        return $row;
    }

    public function close($connection): void
    {
        // noop
    }

    // Helpers para tests
    public function setRows(array $rows): static
    {
        $this->rows  = $rows;
        $this->index = 0;
        return $this;
    }
}
