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

    public function __construct(
        protected array $config, // $config esperado: ['default' => 'main', 'connections' => [ 'main' => [...], ... ]]
        protected Db2Driver $driver,
    )
    {
    }

    /**
     * Devuelve la instancia Db2 para la conexión dada (o la por defecto).
     */
    public function connection(?string $name = null): Db2Connection
    {
        $name = $name ?? ($this->config['default'] ?? null);

        if (!$name) {
            throw new \InvalidArgumentException("No default DB2 connection is configured.");
        }

        if (!isset($this->config['connections'][$name])) {
            throw new \InvalidArgumentException("DB2 connection [$name] does not exist.");
        }

        if (!isset($this->connections[$name])) {
            $db2Config = Db2Config::fromArray($this->config['connections'][$name]);
            $this->connections[$name] = new Db2Connection($db2Config, $this->driver);
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

