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
        $api = $model->find('api', $conexao['id_api']);

        if(@$data->qrcode) {
            $model->save('conexoes', ['id'=>$conexao['id'], 'qrcode'=>$data->qrcode]);
        }

        if($data->status == 'connected') {
            $model->save('conexoes', ['id'=>$conexao['id'], 'conn'=>1]);
        } else if($data->status == 'desconnectedMobile') {
            $model->save('conexoes', ['id'=>$conexao['id'], 'conn'=>0]);
        } else if($data->status == 'RECEIVED') {

            $chatbot = $model->allChatBot($data->content);

            if($chatbot) {

                $rota = 'reply';
                $time_out = 1;

                $parametros = array(
                    "session" => $conexao['nome'],
                    "number" => $data->phone,
                    "text" => $chatbot['resposta'],
                    "messageid" => $data->id
                    
                );

                $data_string = json_encode($parametros);

                $connected = @fsockopen($api['url'], $api['porta']); 

                if ($connected){
                    $is_conn = true;
                    fclose($connected);
                }else{
                    $is_conn = false;
                }

                if($is_conn == true) {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $api['protocol'].$api['url'].':'.$api['porta'].'/'.$rota,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => $time_out,  // padrao é 0
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $data_string,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'sessionkey: '.$conexao['sessionkey'].'',
                        'apitoken: '.$api['apitoken'].''
                    ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
    
    
                } 

            }

            

            
        }
    }
}