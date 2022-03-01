<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Home;
use React\ZMQ\Context;

class HomeController
{

    public function vazio()
    {
        if(@$_SESSION['acesso']) {
        header('location: ' . URL_ADMIN . '/inicio');
        } else {
            Helper::view('admin/auth/login');
        }

    }

    public function admin()
    {
        Helper::view('admin/home/index');
    }

    public function client()
    {
        Helper::view('admin/home/index');
    }

}
