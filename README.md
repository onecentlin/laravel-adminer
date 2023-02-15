# Laravel Adminer Database Manager

Light weight [Adminer](https://www.adminer.org) database management tool integrated into Laravel 5/6/7/8/9.

Various database support: MySQL, SQLite, PostgreSQL, Oracle, MS SQL, Firebird, SimpleDB, MongoDB, Elasticsearch, and etc.

## v6.0 New Features

 Make life easier with minimized package setup =)

- Enable laravel auto package discovery
- New config setting: `middleware` (default value: `auth`)
- Enable env variables to setup adminer config
    - `ADMINER_ENABLED`
    - `ADMINER_AUTO_LOGIN`
    - `ADMINER_ROUTE_PREFIX`

## Installation

```
composer require onecentlin/laravel-adminer
```

OR

Update `composer.json` in require section:

```json
"require": {
    "onecentlin/laravel-adminer": "^6.0"
},
```

Run:
```
composer update onecentlin/laravel-adminer
```

## Register package

> Laravel auto package discovery feature added since package v6.0, you may skip this step.

Update `config/app.php`

```php
'providers' => [
    ...
    Onecentlin\Adminer\ServiceProvider::class,
];
```

## Publish config and theme file

```
php artisan vendor:publish --provider="Onecentlin\Adminer\ServiceProvider"
```

This action will copy two files:

- `config/adminer.php` - Adminer config file
- `public/adminer.css` - Adminer theme file

### config file: `config/adminer.php`

```php
<?php

return [
    'enabled' => env('ADMINER_ENABLED', true),
    'autologin' => env('ADMINER_AUTO_LOGIN', false),
    'route_prefix' => env('ADMINER_ROUTE_PREFIX', 'adminer'),
    'middleware' => 'auth',
];
```

> <span style="color: #a00">ATTENSION: Please only enable autologin with authenticated protection.</span>

### theme file: `public/adminer.css`

You may download `adminer.css` from [Adminer](https://www.adminer.org) or create custom style, and place it into `public` folder.

## Setup Access Permission (Middleware)

> Package v6.0 allow customized middleware config, you may skip this step or modify to fit your needs.

### Laravel 5.2 and above

Setup for middleware group supported for Laravel 5.2 above

Modify `config/adminer.php` : `'middleware' => 'adminer',`

Modify `app/Http/Kernel.php` file with `adminer` in `$middlewareGroups`

```php
protected $middlewareGroups = [
    ...
    'adminer' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        // TODO: you may create customized middleware to fit your needs
        // example uses Laravel default authentication (default protection)
        \Illuminate\Auth\Middleware\Authenticate::class,
    ],
];
```

## Access adminer

Open URL in web browser

```
http://[your.domain.com]/adminer
```

![Screenshot](https://raw.githubusercontent.com/onecentlin/laravel-adminer/master/screenshots/adminer-db-support.png "various database support")

## Remarks

Due to function name conflicts of Laravel 5 and Adminer, adminer.php file
functions `cookie()`, `redirect()` and `view()` are prefixed with `adm_` prefix.

Inspired by [miroc](https://github.com/miroc/Laravel-Adminer)
