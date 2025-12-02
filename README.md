# laravel-db2-raw

<p align="center">
    <!-- <a href="https://github.com/kalel1500/laravel-db2-raw/actions/workflows/tests.yml"><img src="https://github.com/kalel1500/laravel-db2-raw/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a> -->
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/dt/kalel1500/laravel-db2-raw" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/v/kalel1500/laravel-db2-raw" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/l/kalel1500/laravel-db2-raw" alt="License"></a>
</p>


laravel-db2-raw is a simple helper to execute raw DB2 queries in Laravel.

This package provides a thin wrapper around the native `ibm_db2` functions (`db2_connect`, `db2_exec`, `db2_fetch_assoc`, `db2_close`) to make it easier to run raw DB2 SQL queries in Laravel without using Eloquent.

---

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)

## Installation

### Requirements

* PHP >= 8.2
* `ext-json`
* `ext-ibm_db2`
* Laravel >= 12.x

### Installation

Install laravel-db2-raw in your Laravel app with Composer:

```bash
composer require kalel1500/laravel-db2-raw
```

## Configuration

The following environment variables are used by the default connection:

- `DB2RAW_CONNECTION`: Default logical connection name (e.g. `main`).
- `DB2RAW_HOST`: DB2 server hostname or IP.
- `DB2RAW_PORT`: DB2 server port.
- `DB2RAW_DATABASE`: DB2 database name.
- `DB2RAW_USERNAME`: Username used to connect.
- `DB2RAW_PASSWORD`: Password used to connect.

This is the default configuration file (`config/db2_raw.php`):

```php
    
    /*
    |--------------------------------------------------------------------------
    | DB2 connections
    |--------------------------------------------------------------------------
    */

    'default' => env('DB2RAW_CONNECTION', 'main'),

    'connections' => [

        'main' => [
            'host' => env('DB2RAW_HOST'),
            'port' => env('DB2RAW_PORT'),
            'database' => env('DB2RAW_DATABASE'),
            'username' => env('DB2RAW_USERNAME'),
            'password' => env('DB2RAW_PASSWORD'),
        ]

    ]
```

You can also publish the configuration file (`config/db2_raw.php`) with the following command

```bash
php artisan vendor:publish --tag="db2raw"
```

## Usage

### Basic

To launch a query you can use the Db2 facade:

```php
use Thehouseofel\DB2Raw\Facades\Db2;

Db2::exec($query)
```

The `exec` method receives the full SQL string and returns an array of associative arrays. Column names are normalized to lowercase. Currently, parameter binding (e.g. using `?`) is not supported: you must build the full SQL statement yourself.

Be careful when building SQL strings with user input to avoid SQL injection vulnerabilities.

### Defining additional connections

You can also define additional connections in the configuration file:

```php
    
    'connections' => [
        //...

        'admin' => [
            'host' => env('DB2RAW_ADMIN_HOST'),
            'port' => env('DB2RAW_ADMIN_PORT'),
            'database' => env('DB2RAW_ADMIN_DATABASE'),
            'username' => env('DB2RAW_ADMIN_USERNAME'),
            'password' => env('DB2RAW_ADMIN_PASSWORD'),
        ]

    ]
```

And before executing the query you can select which connection to use:

```php
use Thehouseofel\DB2Raw\Facades\Db2;

Db2::connection('admin')->exec($query)
```

## License

laravel-db2-raw is open-sourced software licensed under the [GNU General Public License v3.0](LICENSE).
