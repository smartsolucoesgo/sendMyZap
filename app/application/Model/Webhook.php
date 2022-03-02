<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class Webhook extends Model
{

    public function conexao($nome)
    {
        $where = 'nome = "'. $nome .'"';
        $sql = "
          SELECT *
          FROM conexoes
          WHERE $where
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function allChatBot($pergunta)
    {
        $where = 'pergunta = "'. $pergunta .'"';
        $sql = "
          SELECT *
          FROM chatbot
          WHERE $where
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    

}