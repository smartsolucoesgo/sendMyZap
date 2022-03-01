<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Conexoes;

class ConexoesController
{
    private $table = 'conexoes';
    private $baseView = 'admin/conexoes';
    private $urlIndex = 'conexoes';

    public function index()
    {
        $model = New Conexoes();
        $response['conexoes'] = $model->allCon($this->table,'id DESC');
        $response['api'] = $model->allApi();
        Helper::view($this->baseView.'/index', $response);
    }


    //////////////////////

    public function consultaConexao()
    {
        $model = New Conexoes();
        $dados = $model->find($this->table, $_REQUEST['id']);
        echo json_encode($dados);
    }

    public function createAjax($param)
    {
        $model = New Conexoes();
        $param['sessionkey'] = md5(time());
        $id = $model->create($this->table, $param);
        if($id) {
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function updateAjax($param) {
        $model = New Conexoes();
        $model->save($this->table, ['id'=>$param['id'], 'id_api'=>$param['id_api'], 'nome'=>$param['nome']]);
        echo json_encode(array('status'=>'sucesso'));
    }

    public function deleteAjax($param)
    {
        $model = New Conexoes();
        $model->delete($this->table,'id', $param['id']);
        echo json_encode(array('status'=>'sucesso'));
    }

}