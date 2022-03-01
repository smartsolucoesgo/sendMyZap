<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Libs\Helper;
use SmartSolucoes\Model\Mensagens;

class MensagensController
{
    private $baseView = 'admin/mensagens';

    public function texto()
    {
        $model = New Mensagens();
        $response['conexoes'] = $model->allCon();
        Helper::view($this->baseView.'/texto', $response);
    }

    public function imagem()
    {
        $model = New Mensagens();
        $response['conexoes'] = $model->allCon();
        Helper::view($this->baseView.'/img', $response);
    }

    public function enviaImg()
    {
        $model = New Mensagens();
        $conexao = $model->find('conexoes', $_POST['conexao']);
        $api = $model->find('api', $conexao['id_api']);

        $caminho = 'files/imagens/';
        $nome_imagem = $_POST['conexao'].'_'.time();
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

        Helper::upload($_FILES['imagem'],$nome_imagem,$caminho);

        $connected = @fsockopen($api['url'], $api['porta']); 
        if ($connected){

            $parametros = array(
                "session: ".$conexao['nome']."",
                
            );

            $data_string = json_encode($parametros);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/SessionState');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'sessionkey: '.$conexao['sessionkey'].'',
                'apitoken: '.$api['apitoken'].''
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $resposta = json_decode($result);

            if($resposta->error == 'Sessão não informada.') {
                $parametros = array(
                    "session: ".$conexao['nome']."",
                    
                );
        
                $bodyCon = '{
                    "session": "'.$conexao['nome'].'" ,
                    "wh_status": "'.$api['webhook'].'",
                    "wh_message": "'.$api['webhook'].'",
                    "wh_qrcode": "'.$api['webhook'].'",
                    "wh_connect": "'.$api['webhook'].'"
                }';
        
                $data_string = json_encode($parametros);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/start');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyCon);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'sessionkey: '.$conexao['sessionkey'],
                    'apitoken: '.$api['apitoken'],
                ));
                $result = curl_exec($ch);
                curl_close($ch);
                $respostaCon = json_decode($result);

                if($respostaCon == true) {

                    $telefone = str_replace(array(".", "/", "-", " ", "(", ")"), "", $_POST['telefone']);
                    $parametrosEnvia = array(
                        "session" => $conexao['nome'],
                        "number" => '55'.$telefone,
                        "caption" => $_POST['mensagem'],
                        "path" => URL_PUBLIC . '/' . $caminho . '/' . $nome_imagem . '.' . $extensao
                    );

                    $data_stringEnvia = json_encode($parametrosEnvia);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/sendImage');
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_stringEnvia);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'sessionkey: '.$conexao['sessionkey'],
                        'apitoken: '.$api['apitoken']
                    ));

                    $result = curl_exec($ch);
                    curl_close($ch);
                    $res = json_decode($result);

                    if($res->result == 500) {
                        $response['sucesso'] = 'Mensagem enviada com sucesso.';
                        Helper::view($this->baseView.'/img',$response);
                    }
                }
            } else {
                $telefone = str_replace(array(".", "/", "-", " ", "(", ")"), "", $_POST['telefone']);
                $parametrosEnvia = array(
                    "session" => $conexao['nome'],
                    "number" => '55'.$telefone,
                    "caption" => $_POST['mensagem'],
                    "path" => URL_PUBLIC . '/' . $caminho . '/' . $nome_imagem . '.' . $extensao
                );

                $data_stringEnvia = json_encode($parametrosEnvia);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/sendImage');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_stringEnvia);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'sessionkey: '.$conexao['sessionkey'],
                    'apitoken: '.$api['apitoken']
                ));

                $result = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($result);

                if($res->result == 500) {
                    $response['sucesso'] = 'Mensagem enviada com sucesso.';
                    Helper::view($this->baseView.'/img',$response);
                }
            }

        } else {
            $response['erro'] = 'Mensagem não enviada, tente novamente.';
            Helper::view($this->baseView.'/img',$response);
        }
    }

}