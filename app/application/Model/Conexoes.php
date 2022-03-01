<?php

namespace SmartSolucoes\Model;

use SmartSolucoes\Core\Model;
use SmartSolucoes\Libs\Helper;

class Conexoes extends Model
{

    public function allApi()
    {
        $where = 'AND status = 1';
        $sql = "
          SELECT *
          FROM api
          WHERE 1=1 $where
        ";
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


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


    public function viewQrCode($conn)
    {
      $where = 'AND conn = "'.$conn.'"';
      $sql = "
        SELECT *
        FROM conexoes
        WHERE 1=1 $where
      ";
      $query = $this->PDO()->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }

}