<?php

namespace Models;

use \Core\Model;

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList(int $offset = 0, int $company_id): array
    {
        $array = [];

        $sql = 'SELECT id,
                       name,
                       phone,
                       city,
                       stars
                FROM customers
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

    public function getInfo(int $user_id, int $company_id): array
    {
        $array = [];

        $sql = 'SELECT name,
                       email,
                       phone,
                       address,
                       neighborhood,
                       city,
                       state,
                       country,
                       zipcode,
                       stars,
                       note,
                       number,
                       complement
                FROM customers
                WHERE id = :user_id
                AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getCount(int $company_id): int
    {
        $sql = 'SELECT COUNT(*) AS count FROM customers WHERE company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        return $sql->fetch(\PDO::FETCH_ASSOC)['count'];
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

    public function edit(
        int $company_id, int $user_id, string $name, string $email, string $phone,
        int $stars, string $note, int $number, string $address,
        string $zipcode, string $city, string $state,
        string $country, string $neighborhood, string $complement
    ): void
    {
        $sql = 'UPDATE customers SET
                    name = :name,
                    email = :email,
                    stars = :stars,
                    phone = :phone,
                    note = :note,
                    address = :address,
                    number = :number,
                    zipcode = :zipcode,
                    city = :city,
                    state = :state,
                    country = :country,
                    neighborhood = :neighborhood,
                    complement = :complement
                WHERE id = :user_id
                AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
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
        $sql->bindValue(':company_id', $company_id);
        $sql->bindValue(':user_id', $user_id);
        $sql->execute();
    }

    public function delete(int $user_id, int $company_id): void
    {
        $sql = 'DELETE FROM customers WHERE id = :user_id AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
    }
}
