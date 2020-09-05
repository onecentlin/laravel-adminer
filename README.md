# Laravel Adminer Database Manager

Light weight [Adminer](https://www.adminer.org) database management tool integrated into Laravel 5/6/7/8.

Various database support: MySQL, SQLite, PostgreSQL, Oracle, MS SQL, Firebird, SimpleDB, MongoDB, Elasticsearch, and etc.

## Installation

```
composer require onecentlin/laravel-adminer
```

OR

Update `composer.json` in require section:

```json
"require": {
    "onecentlin/laravel-adminer": "^4.7"
},
```

Run:
```
composer update
```

## Prerequisite

Update `config/app.php`

```php
'providers' => [
    ...
    Onecentlin\Adminer\ServiceProvider::class,
];
```

## Setup Access Permission

### Laravel 5.2 and above (Laravel 6 supported)

Setup for middleware group supported for Laravel 5.2 above

Modify `app/Http/Kernel.php` file with adminer in `$middlewareGroups`

```php
protected $middlewareGroups = [
    ...
    'adminer' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,

        // you may create customized middleware to fit your needs
        // example uses Laravel default authentication (default protection)
        \Illuminate\Auth\Middleware\Authenticate::class,
    ],
];
```

### Laravel 5.1 only

#### Disable CSRF

Modify `app/Http/Middleware/VerifyCsrfToken.php`, add `adminer` to `$except` array:

```php
protected $except = [
    'adminer'
];
```

#### Setup route middleware for access permission

Setup route middleware in `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    ...
    'adminer' => \App\Http\Middleware\Authenticate::class,
];
```

## Adminer Theme (Optional)

Publish theme file (You may use the default theme without executing this action)
```
php artisan vendor:publish --provider="Onecentlin\Adminer\ServiceProvider"
```

You may download `adminer.css` from [Adminer](https://www.adminer.org) or create custom style, and place it into `public` folder.

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
