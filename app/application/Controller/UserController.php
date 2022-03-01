<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\User;
use SmartSolucoes\Libs\Helper;

class UserController
{

    private $table = 'user';
    private $baseView = 'admin/user';
    private $urlIndex = 'usuario';

    public function index()
    {
        $model = New User();
        $response = $model->all($this->table,'id DESC');
        Helper::view($this->baseView.'/index',$response);
    }

    public function viewNew()
    {
        $model = New User();
        Helper::view($this->baseView.'/edit');
    }

    public function viewEdit($param)
    {
        $model = New User();
        $response = $model->find($this->table,$param['id']);
        Helper::view($this->baseView.'/edit',$response);
    }

    public function create()
    {
        $model = New User();
        $options = [
            'cost' => 12,
        ];
        $_POST['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT, $options);
        $id = $model->create($this->table,$_POST,['id']);
        if($id) {
            header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
        } else {
            Helper::view($this->baseView.'/edit',$_POST);
        }
    }

    public function update()
    {
        $model = New User();
        $options = [
            'cost' => 12,
        ];
        if($_POST['senha']) $_POST['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT, $options);
        else unset($_POST['senha']);
        if($model->save($this->table,$_POST)) {
            header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
        } else {
            Helper::view($this->baseView.'/edit/'.$_POST['id']);
        }
    }

    public function deleteAjax($param)
    {
        $model = New User();
        $model->delete($this->table,'id', $param['id']);
        echo json_encode(array('status'=>'sucesso'));
    }

}
