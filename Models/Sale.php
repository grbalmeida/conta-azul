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

        $sql = $this->getDefaultSelectThatReturnSales();
        $sql = $sql .= ' WHERE s.company_id = :company_id';
        $sql = $sql .= ' ORDER BY s.sale_date DESC LIMIT '.$offset.', 10';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getFilteredSales(
        int $company_id,
        string $customer_name,
        string $first_period,
        string $final_period,
        string $status,
        string $order_by): array
    {
        $array = [];
        $where = [];

        $sql = $this->getDefaultSelectThatReturnSales();
        $sql = $sql .= ' WHERE ';

        array_push($where, 'c.company_id = :company_id');

        if (!empty($customer_name))
            array_push($where, 'c.name LIKE :customer_name');
        if (!empty($first_period) && !empty($final_period))
            array_push($where, 's.sale_date BETWEEN :first_period AND :final_period');
        if (strlen($status) > 0)
            array_push($where, 's.status = :status');

        $sql .= implode(' AND ', $where);

        switch ($order_by) {
            case 'date_desc':
            default:
                $sql .= ' ORDER BY s.sale_date DESC';
                break;
            case 'date_asc':
                $sql .= ' ORDER BY s.sale_date ASC';
                break;
            case 'status':
                $sql .= ' ORDER BY s.status ASC';
        }

        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);

        if (!empty($customer_name))
            $sql->bindValue(':customer_name', '%'.$customer_name.'%');
        if (!empty($first_period) && !empty($final_period)) {
            $sql->bindValue(':first_period', $first_period);
            $sql->bindValue(':final_period', $final_period);
        }
        if (strlen($status) > 0)
            $sql->bindValue(':status', $status);
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

    private function getDefaultSelectThatReturnSales(): string
    {
        return 'SELECT s.id,
                       s.sale_date,
                       s.total_price,
                       c.name,
                CASE
                    WHEN s.status = 0 THEN \'Aguardando pagamento\'
                    WHEN s.status = 1 THEN \'Pago\'
                    WHEN s.status = 2 THEN \'Cancelado\'
                END AS sale_status
                FROM sales s
                INNER JOIN customers c
                ON s.customer_id = c.id';
    }
}
