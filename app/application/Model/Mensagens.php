<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class Mensagens extends Model
{

    public function allCon()
    {
        $sql = "
          SELECT c.*, ap.url api
          FROM conexoes c
          INNER JOIN api ap ON ap.id = c.id_api
          WHERE 1=1 AND c.status = 1
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}