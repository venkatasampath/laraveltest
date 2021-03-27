<?php

/*
|-----------------------------------------------------------------------------
| DATABASE SETUP for HEROKU AWS,
| Reading from URL provided by Cloud Service Provider
|-----------------------------------------------------------------------------
|
| We need to do a little bit of logic to parse the Database configuration URL
| into the environment variables Laravel is expecting.
| This checks if DATABASE_URL is defined as an environment variable and if so,
| parses the URL and places the relevant components into new environment
| variables.
|
*/
if (getenv('DATABASE_URL')) {
    $databaseUrl = parse_url(getenv('DATABASE_URL'));

    putenv('DB_HOST='.$databaseUrl['host']);
    putenv('DB_PORT='.$databaseUrl['port']);
    putenv('DB_DATABASE='. substr($databaseUrl['path'], 1));
    putenv('DB_USERNAME='.$databaseUrl['user']);
    putenv('DB_PASSWORD='.$databaseUrl['pass']);
}

/*
|--------------------------------------------------------------------------
| REDIS SETUP for HEROKU AWS,
| Reading from URL provided by Cloud Service Provider
|--------------------------------------------------------------------------
|
| We need to do a little bit of logic to parse the Redis configuration URL
| into the environment variables Laravel is expecting.
| This checks if REDIS_URL is defined as an environment variable and if so,
| parses the URL and places the relevant components into new environment
| variables.
|
*/
if (getenv('REDIS_URL')) {
    $redisUrl = parse_url(getenv('REDIS_URL'));

    putenv('REDIS_HOST='.$redisUrl['host']);
    putenv('REDIS_PORT='.$redisUrl['port']);
    putenv('REDIS_PASSWORD='.$redisUrl['pass']);
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
            'read_write_timeout' => -1, // If you are using Predis in a daemon-like script (in our case we are using Horizon)
        ],

    ],

];
