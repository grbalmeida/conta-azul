<?php

namespace Models;

use \Core\Model;

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList(int $offset = 0): array
    {
        $array = [];

        $sql = 'SELECT id,
                       name,
                       phone,
                       city,
                       stars
                FROM customers
                LIMIT '.$offset.', 10';
        $sql = $this->database->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
}
