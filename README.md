# laravel-db2-raw

<p align="center">
    <!-- <a href="https://github.com/kalel1500/laravel-db2-raw/actions/workflows/tests.yml"><img src="https://github.com/kalel1500/laravel-db2-raw/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a> -->
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/dt/kalel1500/laravel-db2-raw" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/v/kalel1500/laravel-db2-raw" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-db2-raw" target="_blank"><img src="https://img.shields.io/packagist/l/kalel1500/laravel-db2-raw" alt="License"></a>
</p>


laravel-db2-raw is a simple helper for execute DB2 rqw querys.

---

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)

## Installation

Install laravel-db2-raw in your Laravel app with Composer:

```bash
composer require kalel1500/laravel-db2-raw
```

## Configuration

You can configure the connection to the DB2 database using the following environment variables.

```php
    /*
    |--------------------------------------------------------------------------
    | DB2 connection
    |--------------------------------------------------------------------------
    */

    'host' => env('DB2RAW_HOST'),

    'port' => env('DB2RAW_PORT'),

    'database' => env('DB2RAW_DATABASE'),

    'username' => env('DB2RAW_USERNAME'),

    'password' => env('DB2RAW_PASSWORD'),
```

You can also publish the configuration file with the following command

```bash
php artisan vendor:publish --tag="db2raw"
```

## Usage

To launch a query you can use the Db2 facade:

```php
use Thehouseofel\DB2Raw\Facades\Db2;

Db2::exec($query)
```

## License

Kalion is open-sourced software licensed under the [GNU General Public License v3.0](LICENSE).
