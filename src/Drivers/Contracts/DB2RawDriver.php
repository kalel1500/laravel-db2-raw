<?php

namespace Thehouseofel\DB2Raw\Drivers\Contracts;

interface DB2RawDriver
{
    /** Conectar -> devuelve un "resource" / handle */
    public function connect(string $connectionString);

    /** Ejecutar query -> devuelve un "result" handle */
    public function exec($connection, string $query);

    /** Devuelve fila asociativa o false */
    public function fetchAssoc($result);

    /** Cierra la conexión */
    public function close($connection): void;
}
