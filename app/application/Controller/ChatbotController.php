<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Chatbot;

class ChatbotController
{
    private $table = 'chatbot';
    private $baseView = 'admin/chatbot';
    private $urlIndex = 'chatbot';

    public function index()
    {
        $model = New Chatbot();
        $response['conexoes'] = $model->allCon($this->table,'id DESC');
        $response['chatbot'] = $model->allChatBot();
        Helper::view($this->baseView.'/index', $response);
    }

    public function consultaChat()
    {
        
        $model = New Chatbot();
        $dados = $model->find($this->table, $_REQUEST['id']);
        echo json_encode($dados);
    }



    //////////////////////

    public function createAjax($param) 
    {
        $model = New Chatbot();
        $id = $model->create($this->table, $param);
        if($id) {
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function updateAjax($param) 
    {
        $model = New Chatbot();
        $model->save($this->table, $param);
        echo json_encode(array('status'=>'sucesso'));
    }

    public function deleteAjax($param)
    {
        $model = New Chatbot();
        $model->delete($this->table,'id', $param['id']);
        echo json_encode(array('status'=>'sucesso'));
    }

}