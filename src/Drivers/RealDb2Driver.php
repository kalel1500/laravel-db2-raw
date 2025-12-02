<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Drivers;

use Thehouseofel\DB2Raw\Db2Config;
use Thehouseofel\DB2Raw\Drivers\Contracts\Db2Driver;

final class RealDb2Driver implements Db2Driver
{
    public function connect(Db2Config $config)
    {
        // 1. Intentar la conexión
        // Usamos @ para suprimir el Warning nativo y manejar la lógica
        // de error *dentro* de nuestra excepción personalizada.
        $conn = @\db2_connect($config->toConnectionString(), '', '');

        // 2. Comprobar el resultado y lanzar una excepción detallada
        if (!$conn) {
            $errorMsg = \db2_conn_errormsg();
            // db2_conn_errormsg() a veces devuelve información vacía si el fallo es crítico.
            $details = $errorMsg ?: "Verify the connection string or the DB2 server configuration.";

            throw new \RuntimeException("Failed connecting to DB2: " . $details);
        }

        return $conn;
    }

    public function exec($connection, string $query)
    {
        // 1. Intentar ejecutar la consulta
        // Usamos @ para suprimir el Warning nativo.
        $stmt = @\db2_exec($connection, $query);

        // 2. Comprobar el resultado y lanzar una excepción detallada
        if ($stmt === false) {
            $errorMsg = \db2_stmt_errormsg(); // Usamos stmt_errormsg para errores de ejecución.
            $sqlstate = \db2_stmt_error();

            throw new \RuntimeException(
                "DB2 Query Execution Failed. SQLSTATE [$sqlstate]. Error: " . $errorMsg . ".  \nQuery: " . $query
            );
        }

        return $stmt;
    }

    public function fetchAssoc($result)
    {
        return \db2_fetch_assoc($result);
    }

    public function close($connection): void
    {
        \db2_close($connection);
    }
}
