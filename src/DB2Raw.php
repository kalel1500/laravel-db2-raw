<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

class DB2Raw
{
    private string $connection_string;

    public function __construct()
    {
        $hostname = config('db2_raw.host');
        $port     = config('db2_raw.port');
        $database = config('db2_raw.database');
        $user     = config('db2_raw.username');
        $password = config('db2_raw.password');

        $this->connection_string = "DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$database;HOSTNAME=$hostname;PORT=$port;PROTOCOL=TCPIP;UID=$user;PWD=$password;";
    }

    protected function startConnection()
    {
        return db2_connect($this->connection_string, '', '');
    }

    protected function closeConnection($connection): void
    {
        db2_close($connection);
    }

    public function exec(string $query, array $fields): array
    {
        $connection = $this->startConnection();
        $result     = db2_exec($connection, $query);
        $data       = [];

        while ($row = db2_fetch_assoc($result)) {
            $rowData = [];
            foreach ($fields as $field) {
                $rowData[$field] = $row[$field];
            }
            $data[] = $rowData;
        }

        $this->closeConnection($connection);

        return $data;
    }
}
