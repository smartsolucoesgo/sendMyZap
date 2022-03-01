<?php


namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\Webhook;
use SmartSolucoes\Libs\Helper;

use SmartSolucoes\Model\Pusher;

class WebhookController
{

    public function index()
    {
        $model = New Webhook();

        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Cache-Control: no-cache, must-revalidate');
        
        $data = json_decode( file_get_contents('php://input'));

        $conexao = $model->conexao($data->session);

        if($data->qrcode) {
            $model->save('conexoes', ['id'=>$conexao['id'], 'qrcode'=>$data->qrcode]);
        }

        if($data->status == 'connected') {
            $model->save('conexoes', ['id'=>$conexao['id'], 'conn'=>1]);
        } else if($data->status == 'desconnectedMobile') {
            $model->save('conexoes', ['id'=>$conexao['id'], 'conn'=>0]);
        }
    }
}