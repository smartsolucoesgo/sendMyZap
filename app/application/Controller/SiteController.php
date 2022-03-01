<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\Site;
use SmartSolucoes\Libs\Helper;

class SiteController
{
    private $baseView = 'site/home';


    public function index()
    {
        $model = New Site();
        Helper::view($this->baseView.'/index');
    }

}
