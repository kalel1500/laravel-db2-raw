<?php

if (!function_exists('db2_connect')) {
    function db2_connect($connectionString, $user, $password)
    {
        return 'mock_connection';
    }
}

if (!function_exists('db2_exec')) {
    function db2_exec($connection, $query)
    {
        return 'mock_result';
    }
}

if (!function_exists('db2_fetch_assoc')) {
    function db2_fetch_assoc($result)
    {
        static $calls = 0;
        static $data = [
            ['ID' => 1, 'NAME' => 'John Doe'],
            ['ID' => 2, 'NAME' => 'Jane Smith'],
        ];

        $row = $data[$calls] ?? false;
        $calls++;
        return $row;
    }
}

if (!function_exists('db2_close')) {
    function db2_close($connection)
    {
        return true;
    }
}
