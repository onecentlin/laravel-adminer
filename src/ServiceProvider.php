<?php

namespace Iamashishk\Adminer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'Iamashishk\Adminer\Http\Controllers';

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

            $routeConfig = [
                'namespace' => $this->namespace,
                'as' => 'adminer::',
                'prefix' => $prefix,
            ];
            if(filled(config("adminer.hostname"))){
                $routeConfig["domain"] = config("adminer.hostname");
            }
            $group = $router->group($routeConfig, function () {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path(),
            __DIR__ . '/../config/adminer.php' => config_path('adminer.php'),
            __DIR__ . '/../resources/plugins' => resource_path('adminer/plugins'),
        ], 'adminer');
    }

    public function register()
    {
    }
}
