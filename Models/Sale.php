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

    public function getTotalRevenue(int $company_id): float
    {
        $sql = 'SELECT COALESCE(TRUNCATE(SUM(total_price), 2), 0) AS total_revenue
                FROM sales
                WHERE company_id = :company_id
                AND sale_date
                BETWEEN ADDDATE(NOW(), INTERVAL - 1 MONTH) AND NOW()';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        return $sql->fetch(\PDO::FETCH_ASSOC)['total_revenue'];
    }

    public function getTotalProducts(int $company_id): int
    {
        $sql = 'SELECT COALESCE(SUM(shp.quantity), 0) AS total_products
                FROM sales_has_products shp
                INNER JOIN sales s
                ON shp.sale_id = s.id
                WHERE shp.company_id = :company_id
                AND s.sale_date
                BETWEEN ADDDATE(NOW(), INTERVAL -1 MONTH) AND NOW()';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        return $sql->fetch(\PDO::FETCH_ASSOC)['total_products'];
    }

    public function getRevenueList(int $company_id, string $first_period, string $final_period): array
    {
        $array = [];
        $currentDay = $first_period;

        while ($final_period != $currentDay) {
            $array[$currentDay] = 0;
            $currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
        }

        $sql = 'SELECT DATE_FORMAT(s.sale_date, \'%Y-%m-%d\') AS sale_date,
                SUM(total_price) AS total_price
                FROM sales s
                WHERE company_id = :company_id
                AND s.sale_date
                BETWEEN :first_period AND :final_period
                GROUP BY DATE_FORMAT(s.sale_date, \'%Y-%m-%d\')';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->bindValue(':first_period', $first_period);
        $sql->bindValue(':final_period', $final_period);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rows as $sale_item) {
                $array[$sale_item['sale_date']] = $sale_item['total_price'];
            }
        }

        return array_values($array);
    }

    public function getQuantityStatusList(int $company_id): array
    {
        $array = [];

        $sql = 'SELECT COUNT(*) AS total, status
                FROM sales
                WHERE company_id = :company_id
                AND sale_date BETWEEN
                ADDDATE(NOW(), INTERVAL -1 MONTH) AND NOW()
                GROUP BY status';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rows as $sale_item) {
                $array[$sale_item['status']] = $sale_item['total'];
            }
        }

        return array_values($array);
    }
}
