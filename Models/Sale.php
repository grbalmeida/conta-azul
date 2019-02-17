<?php

namespace Models;

use \Core\Model;

class Sale extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList(int $company_id, int $offset = 0): array
    {
        $array = [];

        $sql = 'SELECT s.id,
                       s.sale_date,
                       s.total_price,
                       s.status,
                       c.name
                FROM sales s
                INNER JOIN customers c
                ON s.customer_id = c.id
                WHERE s.company_id = :company_id
                ORDER BY s.sale_date DESC
                LIMIT '.$offset.', 10';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
}
