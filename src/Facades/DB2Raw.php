<?php

declare(strict_types=1);

namespace Thehouseofel\DB2Raw\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array exec(string $query, array $fields)
 *
 * @see \Thehouseofel\DB2Raw\DB2Raw
 */
class DB2Raw extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'thehouseofel.db2raw.db2raw';
    }
}
