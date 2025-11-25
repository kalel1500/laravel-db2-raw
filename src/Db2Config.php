<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

class Db2Config
{
    public string $host;
    public string $port;
    public string $database;
    public string $username;
    public string $password;

    public function __construct(
        string|array $host,
        ?string $port = null,
        ?string $database = null,
        ?string $username = null,
        ?string $password = null,
    )
    {
        if (is_array($host)) {
            $arr = $host;
            $this->host = $arr['host'] ?? '';
            $this->port = $arr['port'] ?? '50000';
            $this->database = $arr['database'] ?? '';
            $this->username = $arr['username'] ?? '';
            $this->password = $arr['password'] ?? '';
        } else {
            $this->host = $host;
            $this->port = $port ?? '50000';
            $this->database = $database ?? '';
            $this->username = $username ?? '';
            $this->password = $password ?? '';
        }
    }

    public function toConnectionString(): string
    {
        return "DRIVER={IBM DB2 ODBC DRIVER};DATABASE={$this->database};HOSTNAME={$this->host};PORT={$this->port};PROTOCOL=TCPIP;UID={$this->username};PWD={$this->password};";
    }

    public static function fromLaravelConfig(string $connectionName = null): self
    {
        $cfg = config('db2_raw', []);
        $name = $connectionName ?? ($cfg['default'] ?? null);
        $connections = $cfg['connections'] ?? [];

        $conn = $connections[$name] ?? [];
        return new self($conn);
    }
}
