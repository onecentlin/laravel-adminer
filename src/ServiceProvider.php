<?php

namespace Onecentlin\Adminer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'Onecentlin\Adminer\Http\Controllers';

    public function boot(Router $router)
    {
        $this->publish();

        $adminerEnabled = config('adminer.enabled');
        if (!$adminerEnabled) {
            return;
        }

        $this->map($router);
    }

    protected function map($router)
    {
        if ($this->app->routesAreCached() === false) {
            $prefix = config('adminer.route_prefix');

            if ($prefix == null) {
                $prefix = 'adminer';
            }

            $group = $router->group([
                'namespace' => $this->namespace,
                'as' => 'adminer::',
                'prefix' => $prefix,
            ], function () {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path(),
            __DIR__ . '/../config/adminer.php' => config_path('adminer.php'),
        ], 'adminer');
    }

    public function register()
    {
    }
}
