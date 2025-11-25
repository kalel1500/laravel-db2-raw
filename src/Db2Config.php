<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

class Db2Config
{
    public function __construct(
        public string $host,
        public string $port,
        public string $database,
        public string $username,
        public string $password
    ) {}

    public function toConnectionString(): string
    {
        return "DRIVER={IBM DB2 ODBC DRIVER};DATABASE={$this->database};"
            . "HOSTNAME={$this->host};PORT={$this->port};"
            . "PROTOCOL=TCPIP;UID={$this->username};PWD={$this->password};";
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['host'],
            $data['port'],
            $data['database'],
            $data['username'],
            $data['password']
        );
    }
}
