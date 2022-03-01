<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\Configuracao;
use SmartSolucoes\Libs\Helper;

class ConfiguracaoController
{

	private $table = 'configuracao';
    private $baseView = 'admin/configuracao';
    private $urlIndex = 'configuracoes';

    public function index()
    {
        $model = New Configuracao();
        $response = $model->all('configuracao', 'id DESC');
        Helper::view($this->baseView.'/index',$response);
    }


    public function viewEdit($param)
    {
        $model = New Configuracao();
        $response = $model->find($this->table,$param['id']);
        Helper::view($this->baseView.'/edit',$response);
    }


    public function update()
    {
        $model = New Configuracao();
        if(@$_SESSION['acesso'] == 'Administrador') $_POST['id_update_user'] = $_SESSION['id_user'];
        if($model->save($this->table,$_POST,['image'])) {
            header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
        } else {
            Helper::view($this->baseView.'/edit/'.$_POST['id']);
        }
    }

    

}

