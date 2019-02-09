<?php

namespace Models;

use \Core\Model;

class User extends Model
{
    private $user_info;

    public function __construct()
    {
        parent::__construct();
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public function doLogin(string $email, string $password): bool
    {
        $sql = 'SELECT id FROM users WHERE email = :email AND password = :password';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', md5($password));
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            return true;
        }

        return false;
    }

    public function setLoggedUser(): void
    {
        $sql = 'SELECT name, company_id FROM users WHERE id = :id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $_SESSION['user_id']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->user_info = $sql->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function getCompany(): int
    {
        return $this->user_info['company_id'];
    }
}
