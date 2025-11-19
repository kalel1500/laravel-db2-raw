<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

class DB2RawConfig
{
    public function __construct(
        public string $host,
        public string $port,
        public string $database,
        public string $username,
        public string $password
    )
    {
    }

    public function toConnectionString(): string
    {
        return "DRIVER={IBM DB2 ODBC DRIVER};DATABASE={$this->database};HOSTNAME={$this->host};PORT={$this->port};PROTOCOL=TCPIP;UID={$this->username};PWD={$this->password};";
    }

    /** Crea desde la configuración Laravel */
    public static function fromLaravelConfig($connection): self
    {
        $connection = config('db2_raw.connections.' . $connection, []);
        return new self(
            $connection['host'] ?? '',
            $connection['port'] ?? '',
            $connection['database'] ?? '',
            $connection['username'] ?? '',
            $connection['password'] ?? '',
        );
    }

    /** Crea desde la configuración Laravel */
    public static function empty(): self
    {
        return new self(
            '',
            '',
            '',
            '',
            '',
        );
    }
}
