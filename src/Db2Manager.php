<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw;

use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

/**
 * @mixin \Thehouseofel\DB2Raw\Db2Connection
 */
class Db2Manager
{
    protected array $connections = [];
    protected array $configConnections = [];
    protected Db2Driver $driver;
    protected string $default;

    public function __construct(array $config, Db2Driver $driver)
    {
        // $config esperado: ['default' => 'db2Main', 'connections' => [ 'db2Main' => [...], ... ]]
        $this->configConnections = $config['connections'] ?? [];
        $this->driver = $driver;
        $this->default = $config['default'] ?? array_key_first($this->configConnections) ?? null;
    }

    /**
     * Devuelve la instancia Db2 para la conexión dada (o la por defecto).
     */
    public function connection(?string $name = null): Db2Connection
    {
        $name = $name ?? $this->default;

        if (!$name) {
            throw new \InvalidArgumentException('No default DB2 connection configured.');
        }

        if (!isset($this->configConnections[$name])) {
            throw new \InvalidArgumentException("DB2 connection [$name] does not exist.");
        }

        if (!isset($this->connections[$name])) {
            $cfg = new Db2Config($this->configConnections[$name]);
            $this->connections[$name] = new Db2Connection($this->driver, $cfg);
        }

        return $this->connections[$name];
    }

    /**
     * Shortcut que delega a connection() para encadenar: Db2::connection('x')->exec(...)
     */
    public function __call($method, $args)
    {
        // si se llama directo al manager como Db2::exec(), asumimos default connection
        $instance = $this->connection();
        return $instance->{$method}(...$args);
    }
}

