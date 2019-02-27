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
        $this->version = '4.7.1';
        // default adminer
        $this->adminer = $this->getAdminerFileName();
    }

    public function index()
    {
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
