<?php

namespace Onecentlin\Adminer\Http\Controllers;

use Illuminate\Routing\Controller;

class AdminerController extends Controller
{
    protected $adminer;
    protected $version;

    public function __construct()
    {
        // add custom middleware to restrict access permission
        $this->middleware('adminer');

        // adminer version
        $this->version = '4.7.8';
        // default adminer
        $this->adminer = $this->getAdminerFileName();
    }

    public function index()
    {
        // Autologin
        if (! isset($_GET['db']) && config('adminer.autologin')) {
            $_POST['auth']['driver'] = $this->getDatabaseDriver(env('DB_CONNECTION'));
            $_POST['auth']['server'] = env('DB_HOST');
            $_POST['auth']['db'] = env('DB_DATABASE');
            $_POST['auth']['username'] = env('DB_USERNAME');
            $_POST['auth']['password'] = env('DB_PASSWORD');
        }
        
        $locale = strtolower(app()->getLocale());

        // localization
        switch ($locale) {
            case 'zh-tw':
            case 'zh-hant':
                $this->adminer = $this->getAdminerFileName('zh-tw');
                break;
        }

        require(__DIR__.'/../../../resources/'.$this->adminer);
    }

    private function getAdminerFileName($locale = 'en')
    {
        return sprintf('adminer-%s-%s.php', $this->version, strtolower($locale));
    }

    /**
     * Mapping laravel db connection to adminer driver
     *
     * @param $connection
     * @return string
     */
    private function getDatabaseDriver($connection)
    {
        /*
            Adminer driver options

            <option value="server">MySQL</option>
            <option value="sqlite">SQLite 3</option>
            <option value="sqlite2">SQLite 2</option>
            <option value="pgsql">PostgreSQL</option>
            <option value="oracle">Oracle (beta)</option>
            <option value="mssql" selected="">MS SQL (beta)</option>
            <option value="firebird">Firebird (alpha)</option>
            <option value="simpledb">SimpleDB</option>
            <option value="mongo">MongoDB</option>
            <option value="elastic">Elasticsearch (beta)</option>
            <option value="clickhouse">ClickHouse (alpha)</option>
        */

        switch ($connection) {
            case "mysql":
                return "server";
            case "sqlsrv":
                return "mssql";
            default:
                if (is_null($connection)) {
                    return "server";
                }
                return $connection;
        }
    }
}
