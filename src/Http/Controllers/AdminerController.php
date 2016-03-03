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
        $this->version = '4.2.4';
        // default adminer
        $this->adminer = sprintf('adminer-%s-mysql-en.php', $this->version);
    }

    public function index()
    {
        $locale = app()->getLocale();

        // localization
        switch ($locale) {
            case 'zh-TW':
                $this->adminer = sprintf('adminer-%s-mysql-%s.php', $this->version, strtolower($locale));
                break;
        }

        require(__DIR__.'/../../../resources/'.$this->adminer);
    }
}
