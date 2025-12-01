<?php

namespace Thehouseofel\DB2Raw\Drivers\Contracts;

use Thehouseofel\DB2Raw\Db2Config;

interface Db2Driver
{
    /**
     * Conecta usando la configuración (Devuelve handle / resource / falso).
     *
     * @param Db2Config $config
     * @return resource
     */
    public function connect(Db2Config $config);

    /**
     * Ejecuta query y devuelve un resultado handle.
     */
    public function exec($connection, string $query);

    /**
     * Devuelve la siguiente fila asociativa o false.
     */
    public function fetchAssoc($result);

    /**
     * Cierra la conexión.
     */
    public function close($connection): void;
}
