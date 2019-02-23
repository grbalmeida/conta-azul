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

        $sql = $this->getDefaultSelectThatReturnInventory();
        $sql .= ' WHERE company_id = :company_id
                AND id NOT IN
                    (select product_id from inventory_history where product_id = inventory.id and inventory_history.action = \'del\')
                LIMIT '.$offset.', 10';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getFilteredInventory(int $company_id): array
    {
        $array = [];

        $sql = $this->getDefaultSelectThatReturnInventory();
        $sql .= ' WHERE company_id = :company_id';
        $sql .= ' AND quantity <= minimum_quantity';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    private function getDefaultSelectThatReturnInventory(): string
    {
        return 'SELECT id,
                    name,
                    price,
                    quantity,
                    minimum_quantity
                FROM inventory';
    }

    public function getInfo(int $inventory_id, int $company_id): array
    {
        $array = [];

        $sql = 'SELECT name,
                       price,
                       quantity,
                       minimum_quantity
                FROM inventory
                WHERE id = :inventory_id
                AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':inventory_id', $inventory_id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
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

        $this->setLog($this->database->lastInsertId(), $company_id, $user_id, 'add');
    }

    public function edit(int $inventory_id, int $company_id, int $user_id, string $name,
                        float $price, int $quantity, int $minimum_quantity): void
    {
        $sql = 'UPDATE inventory
                SET name = :name,
                    price = :price,
                    quantity = :quantity,
                    minimum_quantity = :minimum_quantity
                WHERE id = :inventory_id
                AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':quantity', $quantity);
        $sql->bindValue(':minimum_quantity', $minimum_quantity);
        $sql->bindValue(':inventory_id', $inventory_id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        $this->setLog($inventory_id, $company_id, $user_id, 'edit');
    }

    public function delete(int $inventory_id, int $company_id, int $user_id): void
    {
        $this->setLog($inventory_id, $company_id, $user_id, 'del');
    }

    private function setLog(int $inventory_id, int $company_id, int $user_id, string $action): void
    {
        $sql = 'INSERT INTO inventory_history
                    (product_id, user_id, action, action_date, company_id)
                VALUES
                    (:product_id, :user_id, :action, NOW(), :company_id)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':product_id', $inventory_id);
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':action', $action);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
    }
}
