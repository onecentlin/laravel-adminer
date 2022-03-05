<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Adminer
    |--------------------------------------------------------------------------
    |
    */
    'enabled' => env('ADMINER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Auto Login
    |--------------------------------------------------------------------------
    |
    | Enable autologin to database
    |
    | ATTENTION: Please only enable autologin with authenticated protection
    |
    */
    'autologin' => env('ADMINER_AUTO_LOGIN', false),

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | You may customize route prefix. (default: 'adminer')
    |
    */
    'route_prefix' => env('ADMINER_ROUTE_PREFIX', 'adminer'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware for authentication protection
    |
    | Default laravel authentication middleware: 'auth'
    |
    | Multiple middleware allowed using array:
    |    Example:
    |       'middleware' => ['auth', 'adminer']
    |
    */
    'middleware' => 'auth',
];
