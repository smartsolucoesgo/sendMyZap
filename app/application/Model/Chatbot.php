<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class Chatbot extends Model
{

    public function allCon()
    {
        $sql = "
          SELECT c.*, ap.url api
          FROM conexoes c
          INNER JOIN api ap ON ap.id = c.id_api
          WHERE 1=1
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function allChatBot()
    {
        $sql = "
          SELECT c.*, cx.nome conexao
          FROM chatbot c
          INNER JOIN conexoes cx ON cx.id = c.id_conexao
          WHERE 1=1 AND c.status = 1
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}