<?php

function adminer_object() {
    include_once __DIR__ . '/plugin.php';

    foreach (glob(resource_path('/adminer/plugins/*.php')) as $filename) {
        include_once $filename;
    }

    $plugins = array();

    foreach (config('adminer.plugins', []) as $class => $args) {
        if (is_numeric($class)) {
            $class = $args;
            array_push($plugins, new $class());
        }
        else {
            $args = is_array($args) ? $args : [$args];
            array_push($plugins, new $class(...$args));
        }
    }
    return new AdminerPlugin($plugins);
}
