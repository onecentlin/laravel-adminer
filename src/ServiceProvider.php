<?php

namespace Onecentlin\Adminer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'Onecentlin\Adminer\Http\Controllers';

    public function boot(Router $router)
    {
        $this->map($router);
        $this->publish();
    }

    protected function map($router)
    {
        if ($this->app->routesAreCached() === false) {
            $prefix = 'adminer';
            $group = $router->group([
                'namespace' => $this->namespace,
                'as' => 'adminer::',
                'prefix' => $prefix,
            ], function () {
                require __DIR__.'/Http/routes.php';
            });
        }
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path(),
        ], 'public');
    }

    public function register()
    {
    }
}
