<?php

namespace SmartSolucoes\Controller;

use SmartSolucoes\Model\Auth;
use SmartSolucoes\Libs\Helper;

class AuthController
{

    private $baseView = 'admin/auth/login';
    private $baseViewForgot = 'admin/auth/forgot';

    public function login()
    {
        $login = New Auth();
        $user = $login->login();
        if($user['nome']) {
            if($user['status'] == '0') {
                $response['erro'] = "Usuário desligado, contate o administrador!";
                Helper::view($this->baseView ,$response);
            } else {
            $_SESSION['nome']   = $user['nome'];
            $_SESSION['id_user']   = $user['id'];
            $_SESSION['acesso']   = $user['acesso'];
            $_SESSION['imagem']   = $user['imagem'];
            $_SESSION['dark_mode']   = $user['dark_mode'];
            $_SESSION['text_pequeno']   = $user['text_pequeno'];

            header('location: ' . URL_ADMIN . '/inicio');
            }
        } else {

            $response['erro'] = "E-mail ou senha incorreto!";
            Helper::view($this->baseView ,$response);
            }
            exit();        
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        header('location: ' . URL_PUBLIC );
        exit();
    }

    public function forgot()
    {
        $model = New Auth();
        $account = $model->forgot();
        if($account['id']) {
            $account['session'] = str_replace([' ','.'],'',microtime());
            $model->save('user',$account);
            Helper::trataMail(['email'=>$account['email'],'nome'=>$account['nome'],'tipo'=>'forgot','session'=>$account['session']]);
            $response['email'] = 'Redefinição de senha enviada para o e-mail: '.$account['email'];
            Helper::view($this->baseViewForgot,$response);
        } else {
            $response['erro'] = 'Usuário não cadastrado.';
            Helper::view($this->baseViewForgot,$response);
        }

    }

    public function remember($param)
    {
        $model = New Auth();
        $response = $model->forgot($param);
        Helper::view('admin/auth/remember',$response);
    }

    public function newpassword()
    {
        $model = New Auth();
        $save['id'] = $_POST['id'];
        $save['session'] = null;
        $options = [
            'cost' => 12,
        ];
        if($_POST['senha']) $save['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT, $options);
        if($model->save('user',$save)) {
            header('location: ' . URL_ADMIN );
        } else {
            Helper::view('admin/auth/edit/');
        }
    }

    public function account()
    {
        $model = New Auth();
        $response = $model->find('user',$_SESSION['id_user']);
        Helper::view('admin/auth/edit',$response);
    }

    public function update()
    {
        $model = New Auth();
        $id = $save['id'] = $_SESSION['id_user'];
        $save['nome'] = $_SESSION['nome'] = $_POST['nome'];
        $save['telefone'] = $_POST['telefone'];
        $save['email'] = $_POST['email'];
        $options = [
            'cost' => 12,
        ];
        if($_POST['senha']) $save['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT, $options);
        if($model->save('user',$save)) {
            $caminho = 'files/user/';
            $nome_imagem = $id.'_'.time();
            $formato = 'jpg';
            if(Helper::upload($_FILES['imagem'],$nome_imagem,$caminho,$formato,200,200)) {
                $model->save('user',['id'=>$id,'imagem'=>$caminho.$nome_imagem.'.'.$formato]);
                $_SESSION['imagem'] = $caminho.$nome_imagem.'.'.$formato;
            }
            header('location: ' . URL_ADMIN . '/inicio');
        } else {
            Helper::view('admin/auth/edit/');
        }
    }

    ############3

    public function darkMode($param)
    {
        $model = New Auth();
        if($param['dark_mode'] == 1) {
            $model->save('user',['id'=>$param['user'],'dark_mode'=>0]);
            $_SESSION['dark_mode']   = 0;
            echo json_encode(array('status'=>'inativo'));
        } else {
            $model->save('user',['id'=>$param['user'],'dark_mode'=>1]);
            $_SESSION['dark_mode']   = 1;
            echo json_encode(array('status'=>'ativo'));
        }
    }

    public function text($param)
    {
        $model = New Auth();
        if($param['text_pequeno'] == 1) {
            $model->save('user',['id'=>$param['user'],'text_pequeno'=>0]);
            $_SESSION['text_pequeno']   = 0;
            echo json_encode(array('status'=>'inativo'));
        } else {
            $model->save('user',['id'=>$param['user'],'text_pequeno'=>1]);
            $_SESSION['text_pequeno']   = 1;
            echo json_encode(array('status'=>'ativo'));
        }
    }
    
}
