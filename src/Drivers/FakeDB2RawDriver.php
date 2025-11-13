<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Drivers;

use Thehouseofel\DB2Raw\Drivers\Contracts\DB2RawDriver;

final class FakeDB2RawDriver implements DB2RawDriver
{
    protected array $rows;
    protected int $index = 0;
    public array $queries = [];

    public function __construct(array $rows = [])
    {
        $this->rows = $rows;
    }

    public function connect(string $connectionString)
    {
        return 'fake_connection';
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
}
