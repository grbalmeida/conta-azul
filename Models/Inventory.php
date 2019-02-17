<?php

namespace Models;

use \Core\Model;

class Inventory extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList(int $company_id, int $offset = 0): array
    {
        $array = [];

        $sql = 'SELECT id,
                       name,
                       price,
                       quantity,
                       minimum_quantity
                FROM inventory
                WHERE company_id = :company_id
                LIMIT '.$offset.', 10';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add(int $company_id, int $user_id, string $name, float $price,
                        int $quantity, int $minimum_quantity): void
    {
        $sql = 'INSERT INTO inventory
                    (company_id, name, price, quantity, minimum_quantity)
                VALUES
                    (:company_id, :name, :price, :quantity, :minimum_quantity)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':quantity', $quantity);
        $sql->bindValue(':minimum_quantity', $minimum_quantity);
        $sql->execute();

        $sql = 'INSERT INTO inventory_history
                    (product_id, user_id, action, action_date, company_id)
                VALUES
                    (:product_id, :user_id, :action, NOW(), :company_id)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':product_id', $this->database->lastInsertId());
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':action', 'add');
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
    }
}
