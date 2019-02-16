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

    public function add(
        int $company_id, string $name, string $email, string $phone,
        int $stars, string $note, int $number, string $address,
        string $zipcode, string $city, string $state,
        string $country, string $neighborhood, string $complement
    ): void
    {
        $sql = 'INSERT INTO customers
                    (company_id, name, email, stars, phone,
                    note, number, address, zipcode, city,
                    state, country, neighborhood,
                    complement)
                VALUES
                    (:company_id, :name, :email, :stars, :phone,
                    :note, :number, :address, :zipcode, :city,
                    :state, :country, :neighborhood,
                    :complement)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':stars', $stars);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':note', $note);
        $sql->bindValue(':address', $address);
        $sql->bindValue(':number', $number);
        $sql->bindValue(':zipcode', $zipcode);
        $sql->bindValue(':city', $city);
        $sql->bindValue(':state', $state);
        $sql->bindValue(':country', $country);
        $sql->bindValue(':neighborhood', $neighborhood);
        $sql->bindValue(':complement', $complement);
        $sql->execute();
    }
}
