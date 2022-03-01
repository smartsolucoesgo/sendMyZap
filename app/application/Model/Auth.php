<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class Auth extends Model
{

    public function login()
    {
        $PDO = $this->PDO();
        $query = $PDO->prepare("
            SELECT u.nome, u.id, u.acesso, u.imagem, u.senha, u.status, u.email, u.dark_mode, u.text_pequeno
            FROM user u
            WHERE u.email = :login 
            LIMIT 1");
        $query->execute([':login'=>$_POST['login']]);
        $result = $query->fetch();

        if($result && password_verify($_POST['senha'], $result['senha'])) {
            return $result;
        }
    }

    public function forgot($param=false)
    {
        if($param['session']) {
            $where = "session = :session";
            $set = [':session'=>$param['session']];
        } else {
            $where = "email = :email";
            $set = [':email'=>$_POST['email']];
        }
        $PDO = $this->PDO();
        $query = $PDO->prepare("SELECT id, email, nome, imagem FROM user WHERE " . $where . " LIMIT 1");
        $query->execute($set);
        $result = $query->fetch();
        return $result;
    }

}
