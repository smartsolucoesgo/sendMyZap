<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\Api;
use SmartSolucoes\Libs\Helper;

class ApiController
{

	private $table = 'api';
    private $baseView = 'admin/api';
    private $urlIndex = 'api';

    public function index()
    {
        $model = New Api();
        $response = $model->all($this->table, 'id DESC');
        Helper::view($this->baseView.'/index',$response);
    }

    public function viewEdit($param)
    {
        $model = New Api();
        $response = $model->find($this->table,$param['id']);
        Helper::view($this->baseView.'/edit',$response);
    }


    public function update()
    {
        $model = New Api();
        if(@$_SESSION['acesso'] == 'Administrador') $_POST['id_update_user'] = $_SESSION['id_user'];
        if($model->save($this->table,$_POST,['image'])) {
            header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
        } else {
            Helper::view($this->baseView.'/edit/'.$_POST['id']);
        }
    }

    public function enable($param)
    {
        $model = New Api();        
        $model->save($this->table,['id'=>$param['id'],'status'=>1]);
        header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
    }

    public function disable($param)
    {
        $model = New Api();
        $model->save($this->table,['id'=>$param['id'],'status'=>0]);
        header('location: ' . URL_ADMIN . '/' . $this->urlIndex);
    }


    /////////

    public function createAjax($param)
    {
        $model = New Api();
        $id = $model->create($this->table, $param);
        if($id) {
            echo json_encode(array('status'=>'sucesso'));
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function updateAjax($param) {
        $model = New Api();
        $model->save($this->table, $param);
        echo json_encode(array('status'=>'sucesso'));
    }

    public function deleteAjax($param)
    {
        $model = New Api();
        $model->delete($this->table,'id', $param['id']);
        echo json_encode(array('status'=>'sucesso'));
    }

    public function consultaApi()
    {
        $model = New Api();
        $dados = $model->find($this->table, $_REQUEST['id']);
        echo json_encode($dados);
    }


    /////////

    public function session($param)
    {
        $model = New Api();
        $conexao = $model->find('conexoes', $param['id']);
        $api = $model->find($this->table, $conexao['id_api']);

        $model->save('conexoes', ['id'=>$conexao['id'], 'qrcode'=>null]);

        if ($conexao['conn'] == 0) {
            $rota = 'start';
            $time_out = 1;
        }
        if ($conexao['conn'] == 1) {
            $rota = 'close';
            $time_out = 1;
        }

        $header = [
            'Accept: application/json',
            'Content-Type: application/json',
            'sessionkey: '.$conexao['sessionkey'],
            'apitoken: '.$api['apitoken'],
        ];

        $body = '{
            "session": "'.$conexao['nome'].'" ,
            "wh_status": "'.$api['webhook'].'",
            "wh_message": "'.$api['webhook'].'",
            "wh_qrcode": "'.$api['webhook'].'",
            "wh_connect": "'.$api['webhook'].'"
        }';
        
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
              CURLOPT_POSTFIELDS => $body,
              CURLOPT_HTTPHEADER => $header,
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            echo json_encode(array('status'=>'sucesso'));


        } else {
            echo json_encode(array('status'=>'falha'));
        }
    }

    public function closeConnectionAjax($param)
    {
        $model = New Api();
        $conexao = $model->find('conexoes', $param['id']);
        $api = $model->find($this->table, $conexao['id_api']);

        $header = [
            'Accept: application/json',
            'Content-Type: application/json',
            'sessionkey: '.$conexao['sessionkey'],
            'apitoken: '.$api['apitoken'],
        ];

        $body = '{
            "session": "'.$conexao['nome'].'"
        }';

        $connected = @fsockopen($api['url'], $api['porta']); 
        if ($connected){
            $is_conn = true;
            fclose($connected);

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $api['protocol'].$api['url'].':'.$api['porta'].'/logout',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 1,  // padrao é 0
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => $body,
              CURLOPT_HTTPHEADER => $header,
            ));
            $response_server = curl_exec($curl);
            $response = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response_server));
            curl_close($curl);

            if(@$response->result == 401) {
                echo json_encode(array('status'=>'erro', 'mensagem' => $response->messages));
            } 
            
            echo json_encode(array('status'=>'desconectado'));

        }else{
            $is_conn = false;
        }
    }

    public function sendText($param)
    {
        $model = New Api();
        $conexao = $model->find('conexoes', $param['conexao']);
        $api = $model->find($this->table, $conexao['id_api']);

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
                    $telefone = str_replace(array(".", "/", "-", " ", "(", ")"), "", $param['telefone']);
                    $parametrosEnvia = array(
                        "session" => $conexao['nome'],
                        "number" => '55'.$telefone,
                        "text" => $param['mensagem']
                    );
            
                    $data_stringEnvia = json_encode($parametrosEnvia);
            
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/sendText');
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

                    if($res->result == 200) {
                        echo json_encode(array('status'=>'sucesso'));
                    } else {
                        echo json_encode(array('status'=>'erro'));
                    }
                }
            } else {
                $telefone = str_replace(array(".", "/", "-", " ", "(", ")"), "", $param['telefone']);
                $parametrosEnvia = array(
                    "session" => $conexao['nome'],
                    "number" => '55'.$telefone,
                    "text" => $param['mensagem']
                );
        
                $data_stringEnvia = json_encode($parametrosEnvia);
        
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/sendText');
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

                if($res->result == 200) {
                    echo json_encode(array('status'=>'sucesso'));
                } else {
                    echo json_encode(array('status'=>'erro'));
                }
            }

            
        } else {
            echo json_encode(array('status'=>'erro'));
        }
    }

    public function sendImage($param)
    {
        
        $model = New Api();
        // $conexao = $model->find('conexoes', $param['conexao']);
        // $api = $model->find($this->table, $conexao['id_api']);

        // $caminho = 'files/imagens/';
        // $nome_imagem = $param['conexao'].'_'.time();
        // $formato = 'jpg';
        // Helper::upload($param['imagem'],$nome_imagem,$caminho);

        var_dump($_POST);exit;

        $telefone = str_replace(array(".", "/", "-", " ", "(", ")"), "", $param['telefone']);
        $parametrosEnvia = array(
            "session" => $conexao['nome'],
            "number" => '55'.$telefone,
            "text" => $param['mensagem'],
            "path" => $param['imagem']
        );

        $data_stringEnvia = json_encode($parametrosEnvia);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api['protocol'].$api['url'].':'.$api['porta'].'/sendText');
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

        var_dump($res);
    }

    

}
