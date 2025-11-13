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
    public static function fromLaravelConfig(): self
    {
        return new self(
            config('db2_raw.host', ''),
            config('db2_raw.port', ''),
            config('db2_raw.database', ''),
            config('db2_raw.username', ''),
            config('db2_raw.password', ''),
        );
    }
}
