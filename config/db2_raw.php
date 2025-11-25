<?php

return [

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
];
