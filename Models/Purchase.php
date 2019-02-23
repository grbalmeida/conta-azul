<?php

namespace Models;

use \Core\Model;

class Purchase extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalExpenses(int $company_id): float
    {
        $sql = 'SELECT COALESCE(TRUNCATE(SUM(total_price), 2), 0) AS total_expenses
                FROM purchases
                WHERE company_id = :company_id
                AND purchase_date
                BETWEEN ADDDATE(NOW(), INTERVAL - 1 MONTH)
                AND NOW()';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        return $sql->fetch(\PDO::FETCH_ASSOC)['total_expenses'];
    }
}
