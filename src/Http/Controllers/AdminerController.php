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
            $database_driver = env('DB_CONNECTION');
            if ($database_driver === "mysql") {
                $database_driver = "server";
            }

            $_POST['auth']['driver'] = $database_driver;
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
}
