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
                       c.name,
                CASE
                    WHEN s.status = 0 THEN \'Aguardando pagamento\'
                    WHEN s.status = 1 THEN \'Pago\'
                    WHEN s.status = 2 THEN \'Cancelado\'
                END AS sale_status
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

    public function add(int $company_id, int $customer_id, int $user_id, float $total_price, int $status): void
    {
        $sql = 'INSERT INTO sales
                    (customer_id, user_id, sale_date, total_price, company_id, status)
                VALUES
                    (:customer_id, :user_id, NOW(), :total_price, :company_id, :status)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':customer_id', $customer_id);
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':total_price', $total_price);
        $sql->bindValue(':company_id', $company_id);
        $sql->bindValue(':status', $status);
        $sql->execute();
    }
}
