<?php

namespace Onecentlin\Adminer\Http\Controllers;

use Config;

/**
 * Autologin with current Laravel database credentials
 */
class AdminerAutologinController extends AdminerController
{
    public function index()
    {
        if (! isset($_GET['db'])) {

            $database_config = Config::get('database.default');

            $database_driver = Config::get("database.connections.$database_config.driver");
            if ($database_driver === "mysql")
                $database_driver = "server";

            $_POST['auth']['driver'] = $database_driver;
            $_POST['auth']['server'] = Config::get("database.connections.$database_config.host");
            $_POST['auth']['db'] = Config::get("database.connections.$database_config.database");
            $_POST['auth']['username'] = Config::get("database.connections.$database_config.username");
            $_POST['auth']['password'] = Config::get("database.connections.$database_config.password");
        }

        parent::index();
    }

}
